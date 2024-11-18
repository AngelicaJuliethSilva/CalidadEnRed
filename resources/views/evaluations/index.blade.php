@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bienvenido') }}</div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="width: 200px; height: auto;">
                    </div>

                    <!-- Nueva Evaluación -->
                    <h2 class="my-4">Nueva Evaluación</h2>
                    @if(optional(auth()->user())->administrative_role === 'yes')
                    <form action="{{ route('evaluations.store') }}" method="POST">
                        @csrf
                        <!-- Formulario de evaluación -->
                        <div class="mb-3">
                            <label for="evaluated_id" class="form-label">Usuario a Evaluar</label>
                            <select class="form-control" id="evaluated_id" name="evaluated_id" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="resultado" class="form-label">Resultado</label>
                            <input type="number" class="form-control" id="resultado" name="resultado" required>
                        </div>

                        <div class="mb-3">
                            <label for="comentarios" class="form-label">Comentarios</label>
                            <textarea class="form-control" id="comentarios" name="comentarios"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha de Evaluación</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Evaluación</button>
                        
                    </form>
                    @else
                    <div class="alert alert-danger mt-3" role="alert">
                        No tienes permiso para ver esta sección.
                    </div>
                    @endif

                    <!-- Reporte de Evaluaciones -->
                    <h2 class="my-4">Reporte de Evaluaciones</h2>
                    <form action="{{ route('evaluations.generateReport') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Fecha Inicio</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Fecha Fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Generar Reporte</button>
                    </form>

                    @isset($evaluations)
                        @if($evaluations->count() > 0)
                            <h3>Resultados de Evaluaciones</h3>
                            <p>Total de Evaluaciones: {{ $evaluationCount ?? 0 }}</p>
                            <p>Promedio de Notas: {{ number_format($averageScore ?? 0, 2) }}</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Evaluador</th>
                                        <th>Evaluado</th>
                                        <th>Resultado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluations as $evaluation)
                                        <tr>
                                            <td>{{ $evaluation->evaluator->name }}</td>
                                            <td>{{ $evaluation->evaluated->name }}</td>
                                            <td>{{ $evaluation->resultado }}</td>
                                            <td>{{ $evaluation->fecha }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No se encontraron evaluaciones para el rango de fechas seleccionado.</p>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
