@extends('layouts.master')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-success">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="/admin/create-post" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">

                            <label for="category">Category</label>
                            <select name="category" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control" rows="5">{{ old('content') }}</textarea>

                            <label for="image">Image</label>
                            <input type="file" name="image" accept=".png" class="form-control">

                            <hr>

                            <button type="submit" class="btn btn-primary">Submit</button>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection