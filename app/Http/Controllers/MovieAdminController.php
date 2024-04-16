<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // Import thêm ValidationException
use App\Models\Movie;
use App\Models\Studio;
use App\Models\Status;
use App\Models\Quality;
use App\Models\FilmFormats;

class MovieAdminController extends Controller
{
    public function index(Request $request)
    {
        // Lấy dữ liệu từ trường tìm kiếm (nếu có)
        $search = $request->input('search');

        // Query các bộ phim với tìm kiếm theo tên
        $query = Movie::query();
        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }
        $movies = $query->paginate(10);

        // Trả về view 'admin.movies.index' với dữ liệu phân trang của các bộ phim
        return view('admin.movies.index', ['movies' => $movies, 'search' => $search]);
    }

    public function create()
    {
        // Retrieve the list of studios, statuses, qualities, and types from the database
        $studios = Studio::all();
        $statuses = Status::all();
        $qualities = Quality::all();
        $film_formats = FilmFormats::all();

        // Return the 'admin.movies.create' view along with the lists of studios, statuses, qualities, and types
        return view('admin.movies.create', ['studios' => $studios, 'statuses' => $statuses, 'qualities' => $qualities, 'types' => $film_formats]);
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'required',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Thêm kiểm tra loại hình ảnh và kích thước tối đa
                'name_call' => 'required',
                'studio' => 'required|exists:studios,id',
                'date_aired' => 'required|date',
                'status' => 'required|exists:statuses,id',
                'quality' => 'required|exists:qualities,id',
                'type' => 'required|exists:film_formats,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Lấy tệp ảnh từ request
            $avatar = $request->file('avatar');

            // Đặt tên mới cho tệp ảnh
            $avatarName = 'movie_' . time() . '.' . $avatar->getClientOriginalExtension();

            // Di chuyển tệp ảnh vào thư mục lưu trữ
            $avatar->move(public_path('img/anime'), $avatarName);

            // Tạo một bộ phim mới
            $movie = new Movie();
            $movie->name = $request->name;
            $movie->avatar = $avatarName;
            $movie->name_call = $request->name_call;
            $movie->studio_id = $request->studio;
            $movie->date_aired = $request->date_aired;
            $movie->status_id = $request->status;
            $movie->quality_id = $request->quality;
            $movie->type_id = $request->type;
            $movie->quantity = $request->quantity;
            // Lưu bộ phim
            $movie->save();

            // Redirect về trang danh sách phim với thông báo thành công
            return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully!');
        } catch (ValidationException $e) {
            // Nếu validation thất bại, redirect về trang trước với thông báo lỗi
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Nếu có lỗi không mong muốn, redirect về trang trước với thông báo lỗi
            return redirect()->back()->with('error', 'Failed to create movie. Please try again later.');
        }
    }

    public function delete($id)
    {
        try {
            // Tìm bộ phim cần xóa
            $movie = Movie::findOrFail($id);

            // Thay đổi trạng thái IsDelete thành true
            $movie->isDelete = true;

            // Lưu thay đổi
            $movie->save();

            // Redirect về trang danh sách phim với thông báo thành công
            return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully!');
        } catch (\Exception $e) {
            // Nếu xảy ra lỗi không mong muốn, redirect về trang trước với thông báo lỗi
            return redirect()->back()->with('error', 'Failed to delete movie. Please try again later.');
        }
    }
    public function restore($id)
    {
        try {
            // Tìm bộ phim cần xóa
            $movie = Movie::findOrFail($id);

            // Thay đổi trạng thái IsDelete thành true
            $movie->isDelete = false;

            // Lưu thay đổi
            $movie->save();

            // Redirect về trang danh sách phim với thông báo thành công
            return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully!');
        } catch (\Exception $e) {
            // Nếu xảy ra lỗi không mong muốn, redirect về trang trước với thông báo lỗi
            return redirect()->back()->with('error', 'Failed to delete movie. Please try again later.');
        }
    }
    public function edit($id)
    {
        try {
            // Tìm bộ phim cần chỉnh sửa
            $movie = Movie::findOrFail($id);

            // Retrieve the list of studios, statuses, qualities, and types from the database
            $studios = Studio::all();
            $statuses = Status::all();
            $qualities = Quality::all();
            $film_formats = FilmFormats::all();

            // Return the 'admin.movies.edit' view along with the movie and lists of studios, statuses, qualities, and types
            return view('admin.movies.edit', ['movie' => $movie, 'studios' => $studios, 'statuses' => $statuses, 'qualities' => $qualities, 'types' => $film_formats]);
        } catch (\Exception $e) {
            // Nếu có lỗi không mong muốn, redirect về trang trước với thông báo lỗi
            return redirect()->back()->with('error', 'Failed to fetch movie details. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Tìm bộ phim cần cập nhật
            $movie = Movie::findOrFail($id);

            // Validate the request data
            $request->validate([
                'name' => 'required',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'name_call' => 'required',
                'studio' => 'required|exists:studios,id',
                'date_aired' => 'required|date',
                'status' => 'required|exists:statuses,id',
                'quality' => 'required|exists:qualities,id',
                'type' => 'required|exists:film_formats,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Lấy tên mới của bộ phim
            $movie->name = $request->name;

            // Nếu có tệp ảnh được tải lên, xử lý và lưu tệp ảnh mới
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = 'movie_' . time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('img/anime'), $avatarName);
                $movie->avatar = $avatarName;
            }

            // Cập nhật các thông tin khác của bộ phim
            $movie->name_call = $request->name_call;
            $movie->studio_id = $request->studio;
            $movie->date_aired = $request->date_aired;
            $movie->status_id = $request->status;
            $movie->quality_id = $request->quality;
            $movie->type_id = $request->type;
            $movie->quantity = $request->quantity;

            // Lưu các thay đổi vào cơ sở dữ liệu
            $movie->save();

            // Redirect về trang danh sách phim với thông báo thành công
            return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully!');
        } catch (ValidationException $e) {
            // Nếu validation thất bại, redirect về trang trước với thông báo lỗi
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Nếu có lỗi không mong muốn, redirect về trang trước với thông báo lỗi
            return redirect()->back()->with('error', 'Failed to update movie. Please try again later.');
        }
    }
}
