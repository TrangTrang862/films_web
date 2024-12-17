<?php

namespace App\Http\Controllers;

use App\Film;
use App\FilmClickHistory;
use App\Rating;
use App\User;
use App\FilmView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        $films = Film::where(function ($query) use ($request) {
            $query->when($request->category, function ($q) use ($request) {
                return $q->whereHas('categories', function ($q2) use ($request) {
                    return $q2->whereIn('name', (array)$request->category);
                });
            });
        })->latest()->paginate(10);

        return view('movies.index', compact('films'));
    }

    // Hàm tính toán Cosine Similarity
    function cosineSimilarity($vec1, $vec2)
    {
        //Tính tích vô hướng (dot product) của hai vector.
        $dotProduct = array_sum(array_map(fn($x, $y) => $x * $y, $vec1, $vec2));
        //Tính độ lớn (kích cỡ) của vector thứ nhất.
        $magnitude1 = sqrt(array_sum(array_map(fn($x) => $x * $x, $vec1)));
        //Tính độ lớn (kích cỡ) của vector thứ hai.
        $magnitude2 = sqrt(array_sum(array_map(fn($x) => $x * $x, $vec2)));

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0; // Nếu một trong hai vector là vector không, trả về độ tương đồng là 0
        }

        return $dotProduct / ($magnitude1 * $magnitude2);
    }

    // Hàm lấy các phim liên quan
    private function getRelatedJobs($filmId, $filmSimilarityMatrix, $userFilmMatrix)
    {
        if (!isset($filmSimilarityMatrix[$filmId])) {
            return [];
        }

        arsort($filmSimilarityMatrix[$filmId]); // Sắp xếp theo thứ tự giảm dần của độ tương đồng
        $topRelatedJobs = array_slice($filmSimilarityMatrix[$filmId], 0, 6, true); // Lấy 6 phim liên quan nhất

        $relatedJobs = [];
        foreach ($topRelatedJobs as $relatedJobId => $similarity) {
            // Lọc các phim liên quan dựa trên mức độ tương đồng và đánh giá của người dùng
            foreach ($userFilmMatrix as $userId => $ratings) {
                if ($ratings[$relatedJobId] > 0) { // Nếu người dùng đã đánh giá phim liên quan
                    $relatedJobs[$relatedJobId] = $relatedJobId;
                    break;
                }
            }
        }

        return array_keys($relatedJobs);
    }



    public function show(Film $film)
    {
        $reviews = $film->reviews()->latest()->paginate(10);
        $danhgia = Rating::where('film_id', $film->id)->where('user_id', Auth::id())->first();

        $films = Film::all();
        $users = User::all();
        $countViews = FilmView::where('film_id', $film->id)->count();

        $filmView = FilmView::firstOrCreate(
            ['user_id' => Auth::id(), 'film_id' => $film->id],
            ['views_count' => 0]
        );
        $filmView->views_count++;
        $filmView->save();

        // Lưu lịch sử click
        if (Auth::check()) {
            FilmClickHistory::firstOrCreate([
                'user_id' => Auth::id(),
                'film_id' => $film->id,
            ]);
        }

        //Tạo ma trận người dùng - phim ($userFilmMatrix): Lưu trữ đánh giá của mỗi người dùng cho từng phim.
        $userFilmMatrix = [];
        foreach ($users as $user) {
            foreach ($films as $item) {
                $rating = Rating::where('user_id', $user->id)
                    ->where('film_id', $item->id)
                    ->first();
                $userFilmMatrix[$user->id][$item->id] = $rating ? $rating->rating : 0;
            }
        }

        //Tính toán ma trận tương đồng giữa các phim ($filmSimilarityMatrix): Sử dụng hàm cosineSimilarity để tính độ tương đồng giữa các cặp phim.
        $filmSimilarityMatrix = [];
        foreach ($films as $film1) {
            foreach ($films as $film2) {
                if ($film1->id != $film2->id) {
                    $vec1 = array_column($userFilmMatrix, $film1->id);
                    $vec2 = array_column($userFilmMatrix, $film2->id);
                    $filmSimilarityMatrix[$film1->id][$film2->id] = $this->cosineSimilarity($vec1, $vec2);
                }
            }
        }

        // Lấy các phim liên quan
        $relatedFilmIds = $this->getRelatedJobs($film->id, $filmSimilarityMatrix, $userFilmMatrix);
        $relatedFilms = !empty($relatedFilmIds) ? Film::whereIn('id', $relatedFilmIds)->get() : collect();

        return view('movies.show', compact('film', 'reviews', 'relatedFilms', 'countViews'));
    }

    // public function show($filmId)
    // {
    //     // Tăng lượt xem cho phim trước khi hiển thị
    //     $this->incrementView($filmId);

    //     // Lấy thông tin phim và số lượt xem
    //     $film = Film::findOrFail($filmId);
    //     $viewsCount = FilmView::where('film_id', $filmId)->sum('views_count');

    //     // Trả về trang chi tiết phim với số lượt xem
    //     return view('films.show', compact('film', 'viewsCount'));
    // }


    // public function incrementView($filmId, Request $request)
    // {
    //     $userId = auth()->id(); // Lấy user_id của người dùng hiện tại, nếu người dùng đã đăng nhập

    //     // Kiểm tra xem người dùng đã xem phim này chưa
    //     $filmView = FilmView::where('film_id', $filmId)
    //                         ->where('user_id', $userId)
    //                         ->first();

    //     if ($filmView) {
    //         // Nếu đã có bản ghi, cập nhật lại số lượt xem
    //         $filmView->increment('views_count');
    //     } else {
    //         // Nếu chưa có bản ghi, tạo mới bản ghi với views_count = 1
    //         FilmView::create([
    //             'film_id' => $filmId,
    //             'user_id' => $userId,
    //             'views_count' => 1,
    //         ]);
    //     }

    //     // Trả về trang chi tiết phim
    //     return redirect()->route('films.show', ['id' => $filmId]);
    // }
}
