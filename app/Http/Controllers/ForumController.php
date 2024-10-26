<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\ForumReply;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    // Mostrar todos los temas
    public function index()
    {
        $forumTopics = ForumTopic::with(['user', 'replies.user'])->latest()->get();
        return view('home', compact('forumTopics'));
    }

    // Guardar un nuevo tema
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        ForumTopic::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('status', 'Tema creado con éxito');
    }
    public function storeReply(Request $request, $topicId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        ForumReply::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'topic_id' => $topicId,
        ]);

        return redirect()->back()->with('status', 'Respuesta publicada con éxito!');
    }
    
}
