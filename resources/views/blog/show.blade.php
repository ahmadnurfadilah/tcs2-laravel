@extends('layouts.master')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    @if($blog->image)
                        <img src="/storage/{{ $blog->image }}" style="width:100%" alt="">
                    @endif
                    <div class="card-body">
                        <h1>{{ $blog->title }}</h1>
                        <p>{{ $blog->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection