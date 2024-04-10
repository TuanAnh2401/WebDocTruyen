<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Session;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        // Lấy danh sách tất cả các bộ phim từ cơ sở dữ liệu, kèm theo thể loại và tập phim của mỗi bộ phim
        $movies = Movie::with(['genres', 'episodes'])->get();

        // Trả về view 'index' và truyền dữ liệu bộ phim vào view
        return view('index', compact('movies'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Lấy thông tin của bộ phim từ cơ sở dữ liệu
        $movie = Movie::with(['genres', 'episodes' => function ($query) {
            $query->withPivot('link');
        }, 'studio', 'status', 'quality', 'filmformat','comments'])->findOrFail($id);

        // Trả về view 'details' và truyền dữ liệu của bộ phim vào view
        return view('details', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function watching($id)
    {
        $movie = Movie::findOrFail($id);

        // Kiểm tra xem người dùng đã xem phim này trong phiên hiện tại chưa
        if (!Session::has('watched_movie_' . $id)) {
            // Nếu chưa, tăng số lượng view lên và đánh dấu phim đã được xem trong phiên này
            $movie->views += 1;
            $movie->save();
            Session::put('watched_movie_' . $id, true); // Đánh dấu rằng phim đã được xem trong phiên này
        }

        return view('watching', compact('movie'));
    }
}
