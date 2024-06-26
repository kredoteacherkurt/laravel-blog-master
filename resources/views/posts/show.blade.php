@extends('layouts.app')

@section('title', 'Show Post')

@section('content')

    <div class="mt-2 border border-2 rounded py-3 px-4 shadow-sm">
        <h2 class="h4">{{$post->title}}</h2>
        <h3 class="h6 text-muted">
                {{$post->user->name}}
        </h3>
        <p>{{$post->body}}</p>
        {{--
            call the image from the storage/public/images folder
            --}}
        {{-- <img src="{{asset('images/'.$post->image)}}" alt="{{$post->image}}" class="w-100 shadow"> --}}
        <img src="{{$post->image}}" alt="{{$post->title}}" class="w-100 shadow">
    </div>
    {{-- Prepare the form that submits a comment. --}}
    <form action="{{ route('comment.store', $post->id) }}" method="POST">
        @csrf
        <div class="input-group mt-5">
            <input type="text" class="form-control" name="comment" id="comment" placeholder="Enter your comment here..." value="{{ old('comment') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm ">Post</button>
        </div>
        @error('comment')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </form>
    {{-- Display all comments. --}}
    @if ($post->comments)
        <div class="mt-2 ">
        @foreach ($post->comments as $comment)
            <div class="row p-2">
                <div class="col-10">
                    <span class="fw-bold">
                        {{$comment->user->name}}
                    </span>
                    {{--
                        &nbsp; is a non-breaking space in HTML. It is used to create multiple spaces that are non-collapsible.
                        diffForHumans() is a Carbon method that outputs a human-readable time difference.
                        --}}
                    &nbsp;
                    <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                    <p class="mb-0">{{ $comment->body }}</p>
                </div>

                <div class="col-2 text-end">
                    @if(Auth::user()->id === $comment->user_id)
                        <form action="{{route('comment.destroy', $comment->id)}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i> Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
        </div>
    @endif

@endsection
