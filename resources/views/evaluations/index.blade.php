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
                <h2 class="my-4">Nueva Evaluación</h2>
                @if(auth()->user()->administrative_role === 'yes')
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
                <input type="text" class="form-control" id="resultado" name="resultado" required>
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
            <a href="{{ route('home') }}" class="btn btn-secondary ml-3">Atrás</a>
            </form>
            @else
                <div class="alert alert-danger mt-3" role="alert">
                    No tienes permiso para ver esta sección.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
