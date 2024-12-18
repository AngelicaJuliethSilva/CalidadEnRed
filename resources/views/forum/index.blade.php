@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Foro</h1>

    <!-- Mostrar temas del foro -->
    @foreach ($topics as $topic)
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
@endsection
