<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the admin home page.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('admin.home.index');
    }
}
