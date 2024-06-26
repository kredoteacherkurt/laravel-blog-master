@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form action="{{route('post.update', $post->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="title" class="form-label text-muted">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title here" autofocus value="{{old('title', $post->title)}}">
            @error('title')
                <p class="text-danger small">{{$message}}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="body" class="from-label text-muted">Body</label>
            <textarea name="body" id="body" rows="5" class="form-control" placeholder="Start writing...">{{old('body', $post->body)}}</textarea>
            @error('body')
                <p class="text-danger small">{{$message}}</p>
            @enderror
        </div>
        <div class="mb-3 row">
            <div class="col-6">
                <label for="image" class="form-label text-muted">Image</label>
                {{-- <img src="{{asset('storage/images/'.$post->image)}}" alt="{{$post->image}}" class="w-100 img-thumbnail"> --}}
                <img src="{{$post->image}}" alt="{{$post->title}}" class="w-100 img-thumbnail">
                <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">
                <div class="form-text" id="image-info">
                    Acceptable formats: jpeg, jpg, png, gif only <br>
                    Maximum file size: 1048kb
                </div>
                @error('image')
                    <p class="text-danger small">{{$message}}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
@endsection


