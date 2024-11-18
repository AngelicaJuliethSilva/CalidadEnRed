<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation; // Asegúrate de tener un modelo llamado Evaluation si tienes una tabla para evaluaciones
use App\Models\User;
use Carbon\Carbon;

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
            'resultado' => 'required|integer', // Validación para el resultado
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
    public function generateReport(Request $request)
    {
        $users = User::all();
        $evaluations = Evaluation::all();
        
        // Validar las fechas ingresadas
    $request->validate([

        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);
    

    // Parsear las fechas asegurándose de que son solo fechas sin hora
    $startDate = \Carbon\Carbon::parse($request->start_date)->toDateString(); // Convertir solo a fecha (YYYY-MM-DD)
    $endDate = \Carbon\Carbon::parse($request->end_date)->toDateString(); // Convertir solo a fecha (YYYY-MM-DD)

    // Mostrar las fechas después de procesarlas (para depuración)
    \Log::info('Start Date (processed): ' . $startDate);
    \Log::info('End Date (processed): ' . $endDate);

    // Filtrar las evaluaciones en el rango de fechas (solo fecha, sin hora)
    $evaluations = Evaluation::whereBetween('fecha', [$startDate, $endDate])->get();

    // Verificar si hay evaluaciones encontradas
    \Log::info('Evaluations count: ' . $evaluations->count());

    // Calcular la cantidad de evaluaciones y el promedio de las notas
    $evaluationCount = $evaluations->count();
    $averageScore = $evaluations->avg('resultado');
    
    // Pasar los datos a la vista
    return view('evaluations.index', compact('evaluations', 'evaluationCount', 'averageScore', 'startDate', 'endDate', 'users'));
    } 
   
    
}
