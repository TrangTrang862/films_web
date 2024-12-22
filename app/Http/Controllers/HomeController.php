<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Category;
use App\Film;
use App\FilmClickHistory;
use App\FilmSearchHistory;
use App\Favorite;
use App\Message;
use App\Rating;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rubix\ML\Regressors\KNNRegressor;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Kernels\Distance\Euclidean;

class HomeController extends Controller
{
    public function getRecommendationsForUser($userId)
    {
        if (is_null($userId)) {
            // Nếu người dùng chưa đăng nhập, lấy ngẫu nhiên 10 phim
            return Film::inRandomOrder()->take(10)->get();
        }

        // Lấy dữ liệu đánh giá của tất cả người dùng
        $ratings = $this->getUserFilmRatings(); // Ma trận đánh giá: [user_id][film_id] => rating
        // Tạo dataset từ ma trận đánh giá
        [$data, $labels, $filmIds] = $this->trainingRS($ratings, $userId);
        // Hàm tính khoảng cách Euclidean giữa 2 mảng
        function euclideanDistance($vector1, $vector2)
        {
            $sum = 0;
            // Tính tổng bình phương của sự chênh lệch
            for ($i = 0; $i < count($vector1); $i++) {
                $sum += pow($vector1[$i] - $vector2[$i], 2);
            }
            // Trả về căn bậc hai của tổng
            return sqrt($sum);
        }

        // Tính khoảng cách Euclidean giữa từng phần tử trong mảng data và label
        $distances = [];
        foreach ($data as $index => $dataPoint) {
            $distance = euclideanDistance($dataPoint, $labels);
            $distances[] = ['index' => $index, 'distance' => $distance];
        }

        // Sắp xếp các khoảng cách theo thứ tự từ thấp đến cao (khoảng cách nhỏ nhất ở đầu)
        usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);
        //dd($distances);
        $nearestUsers = array_slice($distances, 0, 2);
        //dd($nearestUsers);
        // Lấy danh sách các phim chưa được đánh giá
        $userRatings = $ratings[$userId] ?? [];
        $unratedFilms = array_filter($userRatings, fn($rating) => $rating === 0);

        // Dự đoán điểm đánh giá cho các phim chưa đánh giá
        $predictedRatings = [];
        foreach (array_keys($unratedFilms) as $filmId) {
            $totalRating = 0;
            $totalUsers = 0;

            // Duyệt qua các người dùng gần nhất để lấy điểm đánh giá
            foreach ($nearestUsers as $user) {
                $nearestUserIndex = $user['index'];
                $nearestUserRatings = $data[$nearestUserIndex]; // Đánh giá của người dùng gần nhất

                // Nếu người dùng gần nhất đã đánh giá phim này, cộng vào tổng
                if (isset($nearestUserRatings[$filmId]) && $nearestUserRatings[$filmId] > 0) {
                    $totalRating += $nearestUserRatings[$filmId];
                    $totalUsers++;
                    //dd($totalRating);
                }
            }
            // Xử lý nếu không có đánh giá từ người dùng gần nhất
            if ($totalUsers === 0) {
                // Lấy điểm trung bình toàn bộ người dùng cho phim này
                $totalRating = array_sum(array_column($ratings, $filmId)) ?? 0;
                $totalUsers = count(array_filter(array_column($ratings, $filmId), fn($rating) => $rating > 0));
            }


            // Tính trung bình cộng nếu có ít nhất một người dùng đã đánh giá
            $predictedRating = $totalUsers > 0 ? $totalRating / $totalUsers : 0;

            // Điền điểm dự đoán vào danh sách
            $predictedRatings[$filmId] = $predictedRating;
        }
        arsort($predictedRatings);




        // Lấy danh sách ID của 3 phim đầu tiên
        $topFilmIds = array_slice(array_keys($predictedRatings), 0, 3);
        // Truy vấn phim theo thứ tự của $topFilmIds
        $recommendedFilms = Film::whereIn('id', $topFilmIds)
            ->orderByRaw('FIELD(id, ' . implode(',', $topFilmIds) . ')')
            ->get();

        // Kiểm tra kết quả
        //dd($recommendedFilms);
        return $recommendedFilms;
    }


    // Lấy tất cả dữ liệu đánh giá của người dùng từ bảng ratings
    private function getUserFilmRatings()
    {
        // Lấy tất cả các đánh giá của người dùng và phim từ bảng ratings
        $ratings = DB::table('ratings')
            ->select('user_id', 'film_id', 'rating')
            ->get();

        // Lấy tất cả các phim (có thể lấy theo ID hoặc tên, tùy theo yêu cầu)
        $filmIds = Film::orderBy('id', 'asc')->pluck('id')->toArray(); // Lấy tất cả ID phim theo thứ tự giảm dần


        // Khởi tạo mảng để lưu ma trận đánh giá
        $matrix = [];

        // Duyệt qua tất cả các đánh giá để tạo ma trận [user_id][film_id] => rating
        foreach ($ratings as $rating) {
            $matrix[$rating->user_id][$rating->film_id] = $rating->rating;
        }

        // Đảm bảo rằng mỗi người dùng có đầy đủ vector đánh giá cho tất cả các phim
        foreach ($matrix as $userId => $userRatings) {
            // Tạo vector đánh giá cho mỗi người dùng, nếu chưa đánh giá phim nào thì gán giá trị 0
            foreach ($filmIds as $filmId) {
                if (!isset($userRatings[$filmId])) {
                    $matrix[$userId][$filmId] = 0; // Gán 0 cho các phim chưa đánh giá
                }
            }
            ksort($matrix[$userId]);
        }

        return $matrix;
    }




    private function trainingRS($ratings, $userId)
    {
        $data = [];
        $labels = [];
        $filmIds = [];

        // Chuyển ma trận đánh giá thành dataset
        foreach ($ratings as $uid => $userRatings) {
            if ($uid == $userId) {
                continue; // Bỏ qua người dùng hiện tại
            }

            // Vector đánh giá của người dùng (thay null bằng 0)
            $data[] = $this->getUserRatingsVector($ratings, $uid);
            //Vector nhãn (rating của phim cụ thể)
            foreach ($userRatings as $filmId => $rating) {
                if (!in_array($filmId, $filmIds)) {
                    $filmIds[] = $filmId;
                }
                // if ($rating !== null) {
                //     $labels[] = $rating;
                // }
            }
        }
        $labels = $this->getUserRatingsVector($ratings, $userId);
        return [$data, $labels, $filmIds];
    }

    // Tạo vector đánh giá của người dùng, sử dụng danh sách phim đầy đủ theo thứ tự
    private function getUserRatingsVector($ratings, $userId)
    {
        // Lấy tất cả phim đã đánh giá của người dùng
        $userRatings = $ratings[$userId] ?? [];

        // Lấy danh sách tất cả các phim theo thứ tự cố định (theo ID)
        $allFilmIds = Film::orderBy('id', 'asc')->pluck('id')->toArray(); // Lấy tất cả các phim theo thứ tự cố định

        $vector = [];
        foreach ($allFilmIds as $filmId) {
            // Nếu người dùng đã đánh giá thì lấy rating, nếu không thì gán 0
            $vector[] = $userRatings[$filmId] ?? 0;
        }

        return $vector;
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
