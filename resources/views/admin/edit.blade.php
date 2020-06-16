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

                        <form action="/admin/edit/{{ $blog->id }}" method="POST">
                            @csrf
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $blog->title }}">

                            <label for="category">Category</label>
                            <select name="category" class="form-control">
                                @foreach($categories as $category)
                                    <option @if($category->id == $blog->category_id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control" rows="5">{{ $blog->content }}</textarea>

                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control">

                            <hr>

                            <button type="submit" class="btn btn-primary">Submit</button>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection