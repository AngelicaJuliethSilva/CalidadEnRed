<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation; // Asegúrate de tener un modelo llamado Evaluation si tienes una tabla para evaluaciones
use App\Models\User;

class EvaluationController extends Controller
{
    /**
     * Display a listing of evaluations.
     */
    public function index()
    {
        if (auth()->user()->administrative_role !== 'yes') {
            return redirect()->route('evaluations.index')->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        
        // Obtener todos los usuarios
        $users = User::all();
        // Obtener todas las evaluaciones
        $evaluations = Evaluation::all();

        // Pasar los usuarios y las evaluaciones a la vista
        return view('evaluations.index', compact('evaluations', 'users'));
    }

    public function create()
    {
        // Obtener todos los usuarios
        $users = User::all();  
        
        // Pasar los usuarios a la vista
        return view('evaluations.index', compact('users'));  
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'evaluated_id' => 'required|exists:users,id', // El ID del usuario evaluado debe existir en la tabla users
            'resultado' => 'required|string', // Validación para el resultado
            'comentarios' => 'nullable|string', // Los comentarios son opcionales
            'fecha' => 'required|date', // Validación para la fecha
        ]);

        // Crear la nueva evaluación
        $evaluation = new Evaluation();
        $evaluation->evaluator_id = auth()->id();  // El usuario autenticado es el que evalúa
        $evaluation->evaluated_id = $validatedData['evaluated_id'];  // El usuario evaluado
        $evaluation->resultado = $validatedData['resultado'];
        $evaluation->comentarios = $validatedData['comentarios'];
        $evaluation->fecha = $validatedData['fecha'];
        $evaluation->save();  // Guardar la evaluación

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('home')->with('status', 'Evaluación guardada correctamente.');
    }
}
