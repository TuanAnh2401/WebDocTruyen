<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy danh sách tất cả các bộ phim từ cơ sở dữ liệu, kèm theo thể loại của mỗi bộ phim
        $movies = Movie::with('genres')->get();
        
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
        // Lấy thông tin của một bộ phim dựa trên ID từ cơ sở dữ liệu
        $movie = Movie::findOrFail($id);
        
        // Trả về view 'show' và truyền dữ liệu của bộ phim vào view
        return view('index', compact('movie'));
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
}
