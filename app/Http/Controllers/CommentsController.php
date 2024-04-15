<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to login to comment.');
        }

        // Kiểm tra và lưu trữ comment
        $request->validate([
            'content' => 'required|string',
            'movie_id' => 'required|exists:movies,id',
        ]);

        Comments::create([
            'user_id' => auth()->user()->id,
            'movie_id' => $request->movie_id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Your comment has been posted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
