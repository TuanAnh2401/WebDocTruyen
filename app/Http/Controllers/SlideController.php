<?php
namespace App\Http\Controllers;

use App\Models\Slide;

class SlideController extends Controller
{
    public function index()
    {
        // Lấy danh sách tất cả các slides từ database
        $slides = Slide::all();
        
        // Trả về view 'index' và truyền đối tượng slides vào view
        return view('index', ['slides' => $slides]);
    }
}
