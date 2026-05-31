
@extends('master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Post') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
    @enderror
                            <!-- resources/views/posts/edit.blade.php -->
                            <div class="mb-3">
                                <label for="post_date" class="form-label">Post Date</label>
                                <input id="post_date" type="date" class="form-control @error('post_date') is-invalid @enderror" name="post_date" value="{{ old('post_date', $post->post_date) }}" required>
                                @error('post_date')
                                <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

