<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumTopic;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = auth()->id();

        // Aquí cargamos los temas del foro
        $forumTopics = ForumTopic::latest()->get();
    
        // Obtener las evaluaciones de la persona autenticada
        $evaluations = Evaluation::where('evaluated_id', $userId)->get();
    
        // Calcular el promedio de las notas y la cantidad de evaluaciones
        $averageScore = $evaluations->avg('resultado');
        $evaluationCount = $evaluations->count();
        $averageGeneral = DB::table('evaluations')
        ->avg('resultado');
    
        // Pasar las variables a la vista
        return view('home', compact('forumTopics', 'averageScore', 'evaluationCount', 'averageGeneral'));
    }
    public function showUserEvaluations()
    {
        
        $userId = auth()->id();
    
        // Obtener las evaluaciones de la persona autenticada
        $evaluations = Evaluation::where('evaluated_id', $userId)->get();
    
        // Calcular el promedio de las notas y la cantidad de evaluaciones

        $averageScore = $evaluations->avg('resultado'); // Promedio de las notas
        $evaluationCount = $evaluations->count(); // Contar las evaluaciones

        dd($averageScore, $evaluationCount);
        return view('home', compact('averageScore', 'evaluationCount'));
    }
    public function generalAverage()
    {
        $averageGeneral = Evaluation::avg('resultado'); // Calcula el promedio de todas las evaluaciones
        return view('evaluations.general-chart', compact('averageGeneral')); // Enviar a la vista
    }
}