@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input 
                type="text" 
                class="form-control" 
                id="title" 
                name="title" 
                placeholder="Enter title"
                value="{{ old('title') }}"
                {{-- old('title') is used to retain the value of the input field in case of validation error --}}
                autofocus
            >
            @error('title')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        {{-- body --}}
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea 
                class="form-control" 
                id="body" 
                name="body" 
                rows="5"
                placeholder="Say something..."
            >{{ old('body') }}</textarea>
            @error('body')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        {{-- image --}}
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input 
                type="file" 
                class="form-control" 
                id="image" 
                name="image"
            >
            <div class="text-muted">
                Accepted formats: jpg, jpeg, png, gif <br>
                Max size: 1MB or 1024KB
            </div>
            @error('image')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        {{-- submit --}}
        <div class="mb-3">
            <button type="submit" class="btn btn-primary px-5">Create</button>
        </div>
    </form>
@endsection