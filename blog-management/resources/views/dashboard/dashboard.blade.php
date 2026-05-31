
@extends('master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Add Post</a>
                    <h3>Approved Posts</h3>
                    <ul class="list-group">
                        @foreach($posts as $post)
                            <li class="list-group-item">
                                <strong>{{ $post->title }}</strong> - {{ $post->post_date }}
                                <div>{{ $post->description }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
