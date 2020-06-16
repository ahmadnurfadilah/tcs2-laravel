@extends('layouts.master')

@section('content')
    <div class="container my-5">
        <div class="row">
            @foreach($blogs as $blog)
                <div class="col-md-4">
                    <div class="card">
                        @if($blog->image == null)
                            <img src="https://via.placeholder.com/600x600.png?text=Image" class="card-img-top" alt="...">
                        @else
                            <img src="/storage/{{ $blog->image }}" class="card-img-top" alt="...">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $blog->title }}</h5>
                            <p class="card-text">{{ $blog->content }}</p>
                            <a href="/blog/{{ $blog->id }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection