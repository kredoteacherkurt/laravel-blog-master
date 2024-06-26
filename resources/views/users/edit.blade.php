@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row mt-2 mb-3">
            {{-- if there is avatar --}}
            <div class="col-4 mb-3">
                @if ($user->avatar)
                    {{-- <img src="{{ asset('avatars/' . $user->avatar) }}" class="img-thumbnail w-100" alt="user image"> --}}
                    <img src="{{$user->avatar}}" class="img-thumbnail w-100" alt="user image">
                @else
                    <i class="fa-solid fa-image fa-10x d-block text-center"></i>
                @endif
            </div>

            <input
                type="file"
                class="form-control mt-1 @error('avatar') is-invalid @enderror"
                id="avatar"
                name="avatar"
                aria-describedby="avatar-info"
                {{-- value="{{ old('avatar') }}" --}}
            >
            <div id="avatar-info" class="form-text">
                Accepted formats: jpg, jpeg, png, gif
                Max size: 1MB or 1024KB
            </div>
            @error('avatar')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label text-muted">Name</label>
            <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                value="{{ old('name') ?? $user->name }}"
            >
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                value="{{ old('email') ?? $user->email }}"
            >
            @error('email')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>


@endsection
