<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumTopic;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Aquí cargamos los temas del foro
        $forumTopics = ForumTopic::latest()->get();

        // Pasamos los temas del foro a la vista del dashboard (home)
        return view('home', compact('forumTopics'));
    }
}