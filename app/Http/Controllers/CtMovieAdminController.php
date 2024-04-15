<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\CtMovie;
use App\Models\Movie;
use App\Models\Episode;

class CtMovieAdminController extends Controller
{
    public function index()
    {
        $ctMovies = CtMovie::paginate(10);

        return view('admin.ct_movies.index', ['ctMovies' => $ctMovies]);
    }

    public function create()
    {
        $movies = Movie::all();
        $episodes = Episode::all();

        return view('admin.ct_movies.create', ['movies' => $movies, 'episodes' => $episodes]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'movie_id' => 'required|exists:movies,id',
                'episode_id' => 'required|exists:episodes,id',
                'link' => 'required|file|mimes:mp4,mov,avi,wmv',
                'isBlock' => 'boolean',
                'isDelete' => 'boolean',
            ]);
    
            $link = $request->file('link'); // Sửa 'avatar' thành 'link'
    
            // Kiểm tra xem đã có file được tải lên chưa
            if ($link) {
                // Đặt tên mới cho tệp video
                $linkName = 'ctmovie_' . time() . '.' . $link->getClientOriginalExtension();
    
                // Di chuyển tệp video vào thư mục lưu trữ
                $link->move(public_path('videos'), $linkName);
            }
    
            $ctMovie = new CtMovie();
            $ctMovie->movie_id = $request->movie_id;
            $ctMovie->episode_id = $request->episode_id;
            $ctMovie->link = isset($linkName) ? $linkName : null; // Lưu tên file nếu có
            $ctMovie->isBlock = $request->has('isBlock'); // Convert to boolean
            $ctMovie->isDelete = $request->has('isDelete'); // Convert to boolean
            $ctMovie->save();
    
            return redirect()->route('admin.ct_movies.index')->with('success', 'CtMovie created successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create CtMovie. Please try again later.');
        }
    }
    


public function delete($id)
{
    try {
        $ctMovie = CtMovie::findOrFail($id);
        $ctMovie->isDelete = true; // Sử dụng biến isDelete thay vì IsDelete

        $ctMovie->save();
        return redirect()->route('admin.ct_movies.index')->with('success', 'CtMovie deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete CtMovie. Please try again later.');
    }
}

public function restore($id)
{
    try {
        $ctMovie = CtMovie::findOrFail($id);
        $ctMovie->isDelete = false; // Sử dụng biến isDelete thay vì IsDelete

        $ctMovie->save();

        return redirect()->route('admin.ct_movies.index')->with('success', 'CtMovie restored successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to restore CtMovie. Please try again later.');
    }
}
public function block($id)
{
    try {
        $ctMovie = CtMovie::findOrFail($id);
        $ctMovie->isBlock = true;
        $ctMovie->save();

        return redirect()->route('admin.ct_movies.index')->with('success', 'CtMovie blocked successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to block CtMovie. Please try again later.');
    }
}


public function unblock($id)
{
    try {
        $ctMovie = CtMovie::findOrFail($id);
        $ctMovie->isBlock = false; 

        $ctMovie->save();

        return redirect()->route('admin.ct_movies.index')->with('success', 'CtMovie unblock successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to unblock CtMovie. Please try again later.');
    }
}

}
