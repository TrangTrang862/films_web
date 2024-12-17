<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Category;
use App\Film;
use App\FilmClickHistory;
use App\FilmSearchHistory;
use App\Favorite;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rubix\ML\Regressors\KNNRegressor;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;

class HomeController extends Controller
{
    // Phương thức lấy gợi ý phim cho người dùng
    public function getRecommendationsForUser($userId)
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (is_null($userId)) {
            // Nếu người dùng chưa đăng nhập, lấy ngẫu nhiên 10 phim
            $recommendations = Film::inRandomOrder()->take(10)->get();
        } else {
            // Lấy lịch sử tương tác của người dùng (click, tìm kiếm, yêu thích)
            $clickHistory = FilmClickHistory::where('user_id', $userId)->get();
            $searchHistory = FilmSearchHistory::where('user_id', $userId)->get();
            $favorites = Favorite::where('user_id', $userId)->get();

            // Kiểm tra nếu người dùng chưa tương tác với bất kỳ phim nào
            if ($clickHistory->isEmpty() && $searchHistory->isEmpty() && $favorites->isEmpty()) {
                // Nếu người dùng chưa tương tác, lấy ngẫu nhiên 10 phim
                $recommendations = Film::inRandomOrder()->take(10)->get();
            } else {
                // Nếu người dùng đã tương tác, lấy danh sách phim mà người dùng đã tương tác
                $films = $this->getFilmsFromUserInteraction($clickHistory, $searchHistory, $favorites);

                // Chuẩn bị dữ liệu cho mô hình (mã hóa các thuộc tính, tính năng của phim)
                $data = $this->prepareDataForModel($films);

                // Xây dựng mô hình khuyến nghị (KNN)
                $model = $this->buildModel();

                // Tạo gợi ý phim dựa trên mô hình
                $recommendations = $this->getFilmRecommendations($model, $data, $films);
            }
        }

        // Trả về kết quả gợi ý phim
        return $recommendations;
    }

    // Lấy danh sách phim mà người dùng đã tương tác (click, tìm kiếm, yêu thích)
    private function getFilmsFromUserInteraction($clickHistory, $searchHistory, $favorites)
    {
        // Lấy tất cả các phim mà người dùng đã tương tác (click, tìm kiếm, yêu thích)
        $filmIds = $clickHistory->pluck('film_id')  // Lấy ID phim từ lịch sử click
            ->merge($favorites->pluck('film_id'))  // Lấy ID phim từ danh sách yêu thích
            ->unique();  // Loại bỏ trùng lặp

        // Lấy danh sách phim từ lịch sử tìm kiếm (so sánh theo tên phim)
        $searchFilmNames = $searchHistory->pluck('key_search')->unique();  // Lấy các từ khóa tìm kiếm (tên phim)

        // Tìm các phim có tên trùng với từ khóa tìm kiếm
        $filmsFromSearch = Film::whereIn('name', $searchFilmNames)->pluck('id');  // Tìm phim theo tên

        // Kết hợp các ID phim từ lịch sử click, yêu thích và tìm kiếm
        $filmIds = $filmIds->merge($filmsFromSearch)->unique();  // Hợp nhất các ID phim từ ba nguồn

        // Lấy phim từ cơ sở dữ liệu dựa trên ID phim
        return Film::whereIn('id', $filmIds)->get();
    }


    // Chuẩn bị dữ liệu cho mô hình khuyến nghị (bao gồm các thuộc tính như thể loại và diễn viên)
    private function prepareDataForModel($films)
    {
        $data = [];
        $labels = [];

        // Tạo một danh sách tất cả các thể loại và diễn viên độc nhất
        $allCategories = Category::all()->pluck('name')->toArray();
        $allActors = Actor::all()->pluck('name')->toArray();

        // Tạo các chỉ số duy nhất cho thể loại và diễn viên
        $categoryIndex = array_flip($allCategories); // Mã hóa thể loại thành chỉ số
        $actorIndex = array_flip($allActors); // Mã hóa diễn viên thành chỉ số

        foreach ($films as $film) {
            // Lấy các thể loại và diễn viên của phim
            $categories = $film->categories()->pluck('name')->toArray();
            $actors = $film->actors()->pluck('name')->toArray();

            // Chuyển thể loại và diễn viên thành các chỉ số
            $categoryVector = array_map(function ($category) use ($categoryIndex) {
                return $categoryIndex[$category] ?? -1; // -1 nếu thể loại không tồn tại
            }, $categories);

            $actorVector = array_map(function ($actor) use ($actorIndex) {
                return $actorIndex[$actor] ?? -1; // -1 nếu diễn viên không tồn tại
            }, $actors);

            // Đảm bảo rằng mỗi bộ phim có một vector đồng nhất có đúng 20 đặc trưng
            $fixedCategoryCount = 10; // Ví dụ: 10 thể loại
            $fixedActorCount = 10; // Ví dụ: 10 diễn viên

            // Đệm (padding) hoặc cắt (truncate) các vector thể loại và diễn viên
            $categoryVector = array_pad($categoryVector, $fixedCategoryCount, -1); // Đệm với -1
            $actorVector = array_pad($actorVector, $fixedActorCount, -1); // Đệm với -1

            // Kết hợp tất cả tính năng lại thành một vector duy nhất có đúng 20 đặc trưng
            $features = array_merge($categoryVector, $actorVector);

            // Kiểm tra và đảm bảo tổng số tính năng là 20
            if (count($features) !== 20) {
                // Nếu tổng số tính năng không phải là 20, bạn có thể quyết định thêm giá trị mặc định hoặc xử lý khác
                $features = array_pad($features, 20, -1); // Đệm với -1 nếu cần
            }

            // Sử dụng ID phim làm nhãn
            $labels[] = $film->id;

            // Lưu các tính năng của phim
            $data[] = $features;
        }

        // Kiểm tra lại số lượng mẫu và nhãn
        if (count($data) !== count($labels)) {
            throw new \Exception("Number of samples and labels must be equal. Found " . count($data) . " samples but " . count($labels) . " labels.");
        }

        return [$data, $labels];
    }


    // Xây dựng mô hình KNN với K=5
    private function buildModel()
    {
        return new KNNRegressor(5);
    }

    // Tạo gợi ý phim dựa trên mô hình KNN đã huấn luyện
    private function getFilmRecommendations($model, $data, $films)
    {
        // Huấn luyện mô hình KNN với dữ liệu phim
        list($data, $labels) = $data;
        $dataset = new Labeled($data, $labels);  // Sử dụng Labeled thay vì Dataset

        // Đảm bảo rằng các mẫu có số chiều chính xác
        if (count($data[0]) !== 20) {
            throw new \Exception("Each sample must have exactly 20 features. Found " . count($data[0]) . " features.");
        }

        $model->train($dataset);

        $recommendations = [];
        $clickedFilmIds = $films->pluck('id')->toArray(); // Lấy danh sách ID phim mà người dùng đã tương tác

        foreach ($films as $film) {
            // Lấy các tính năng của phim hiện tại (thể loại và diễn viên)
            $features = array_merge($film->categories()->pluck('name')->toArray(), $film->actors()->pluck('name')->toArray());

            // Lấy các phim có cùng thể loại hoặc diễn viên
            $similarFilms = Film::whereHas('categories', function ($query) use ($film) {
                $query->whereIn('name', $film->categories()->pluck('name')->toArray());
            })->orWhereHas('actors', function ($query) use ($film) {
                $query->whereIn('name', $film->actors()->pluck('name')->toArray());
            })->get();

            // Mã hóa các tính năng của phim để sử dụng trong mô hình
            $encodedFeatures = array_map(function ($feature) use ($features) {
                return array_search($feature, array_unique($features));
            }, $features);

            // Đảm bảo rằng có 20 đặc trưng
            $encodedFeatures = array_pad($encodedFeatures, 20, -1);  // Đệm nếu cần

            // Dự đoán các phim tương tự dựa trên mô hình KNN đã huấn luyện
            $predictions = $model->predict(new Unlabeled([$encodedFeatures]));

            // Thêm các phim được dự đoán vào danh sách gợi ý
            foreach ($predictions as $prediction) {
                $recommendedFilm = Film::find($prediction);
                if ($recommendedFilm && !in_array($recommendedFilm->id, $clickedFilmIds)) {
                    $recommendations[] = $recommendedFilm;
                }
            }

            // Thêm các phim có cùng thể loại hoặc diễn viên vào danh sách gợi ý, nếu phim đó chưa được người dùng click hoặc yêu thích
            foreach ($similarFilms as $similarFilm) {
                if (!in_array($similarFilm->id, $clickedFilmIds)) {
                    $recommendations[] = $similarFilm;
                }
            }
        }

        // Loại bỏ các phim trùng lặp trong danh sách gợi ý
        $recommendations = array_unique($recommendations, SORT_REGULAR);

        return $recommendations;
    }


    // Main Controller Method
    public function index()
    {
        $userId = Auth::id() ?? 1;

        $recommendationFilms = $this->getRecommendationsForUser($userId);
        $sliderFilms = Film::with('categories', 'ratings')->latest()->take(10)->get();
        $headerCategoryFilms = Category::with('films')->get();
        $categoryFilms = Category::with('films')->take(3)->get();

        return view('home', compact('sliderFilms', 'headerCategoryFilms',  'categoryFilms', 'recommendationFilms'));
    }

    public function search(Request $request)
    {
        switch ($request->search_category) {
            case 'movies':
                // Lưu lịch sử click
                try {
                    if (Auth::check()) {
                        FilmSearchHistory::create([
                            'user_id' => Auth::id(),
                            'key_search' => $request->search,
                        ]);
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'code' => 0,
                        'message' => 'Lưu lịch sử click thất bại',
                        'error' => $e->getMessage(),
                    ], 500);
                }

                $films = Film::where('name', 'like', '%' . $request->search . '%')->paginate(10);
                return view('movies.index', compact('films'));
            case 'actors':
                $actors = Actor::where('name', 'like', '%' . $request->search . '%')->paginate(10);
                return view('actors.index', compact('actors'));
            default:
                return redirect()->back();
        }
    }

    public function message(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email',
            'title' => 'required|string',
            'message' => 'required|string|max:250',
        ]);

        Message::create($attributes);

        session()->flash('success', 'Thank you for contacting us.');
        return redirect()->back();
    }
}
