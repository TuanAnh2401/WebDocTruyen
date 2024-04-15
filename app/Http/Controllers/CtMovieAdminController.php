<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\CtMovie;
use App\Models\Movie;
use App\Models\Episode;

class CtMovieAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = CtMovie::query();
        if ($search) {
            // Truy vấn bảng CtMovie dựa trên tên phim từ bảng Movie
            $query->whereHas('movie', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }
        $ctMovies = $query->paginate(10);

        return view('admin.ct_movies.index', ['ctMovies' => $ctMovies, 'search' => $search]);
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

            $link = $request->file('link');

            if ($link) {
                $linkName = 'ctmovie_' . time() . '.' . $link->getClientOriginalExtension();
                $link->move(public_path('videos'), $linkName);
            }

            $ctMovie = new CtMovie();
            $ctMovie->movie_id = $request->movie_id;
            $ctMovie->episode_id = $request->episode_id;
            $ctMovie->link = isset($linkName) ? $linkName : null;
            $ctMovie->isBlock = $request->has('isBlock');
            $ctMovie->isDelete = $request->has('isDelete');
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
            $ctMovie->isDelete = true;
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
            $ctMovie->isDelete = false;
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
            return redirect()->route('admin.ct_movies.index')->with('success', 'CtMovie unblocked successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to unblock CtMovie. Please try again later.');
        }
    }
}
