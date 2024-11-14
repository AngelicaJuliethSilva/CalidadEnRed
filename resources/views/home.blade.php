@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bienvenido') }}</div>
                <div class="card-body">
                    <!-- Agregar el logo -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="width: 350px; height: auto;">
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Pestañas -->
                    <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="forum-tab" data-bs-toggle="tab" href="#forum" role="tab" aria-controls="forum" aria-selected="true">Foro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="results-tab" data-bs-toggle="tab" href="#results" role="tab" aria-controls="results" aria-selected="false">Resultados</a>
                        </li>
                        @if(auth()->user()->administrative_role === 'yes')
                        <li class="nav-item">
                            <a class="nav-link" id="evaluations-tab" href="{{ route('evaluations.index') }}">Nueva Evaluación</a>
                        </li>
                        @endif                        
                    </ul>

                    <!-- Contenido de las pestañas -->
                    <div class="tab-content" id="dashboardTabsContent">
                        <!-- Contenido Foro -->
                        <div class="tab-pane fade show active" id="forum" role="tabpanel" aria-labelledby="forum-tab">
                            <h3>Foro de Discusión</h3>
                            @foreach ($forumTopics as $topic)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $topic->title }}</h5>
                                        <p class="card-text">{{ $topic->content }}</p>
                                        <p class="card-text"><small class="text-muted">Por {{ $topic->user->name }} el {{ $topic->created_at->format('d/m/Y') }}</small></p>

                                        <!-- Mostrar respuestas al tema -->
                                        @if($topic->replies->count())
                                            <h6>Respuestas:</h6>
                                            @foreach ($topic->replies as $reply)
                                                <div class="card mb-2">
                                                    <div class="card-body">
                                                        <p class="card-text">{{ $reply->content }}</p>
                                                        <p class="card-text"><small class="text-muted">Por {{ $reply->user->name }} el {{ $reply->created_at->format('d/m/Y') }}</small></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        <!-- Formulario para nueva respuesta -->
                                        <form action="{{ route('forum.reply.store', $topic->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="replyContent" class="form-label">Tu respuesta</label>
                                                <textarea class="form-control" id="replyContent" name="content" rows="2" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-secondary">Responder</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Formulario para nuevo tema -->
                            <form action="{{ route('forum.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Título del tema</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Contenido</label>
                                    <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Crear tema</button>
                            </form>
                        </div>

                        <!-- Contenido Resultados -->
                        <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="results-tab">
                            <h3>Resultados</h3>
                            <p>Aquí se mostrarán los resultados de las evaluaciones.</p>
                            <!-- Puedes agregar una tabla o gráfica con resultados -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection