@extends('layouts.master')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
				<div class="row">
					<div class="col-md-9">
						<a href="/admin/create" class="btn btn-primary mb-3">Create</a>
					</div>
					<div class="col-md-3">
						<form action="" method="get">
							<input type="text" class="form-control" name="search" placeholder="Search..." value="{{ $search }}">
						</form>
					</div>
				</div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Content</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($blogs) > 0)
                            @foreach($blogs as $blog)
                                <tr>
                                    <td>{{ $blog->id }}</td>
                                    <td>{{ $blog->title }}</td>
                                    <td>{{ $blog->user->name }}</td>
                                    <td>{{ $blog->content }}</td>
                                    <td>
																			<a href="/admin/edit/{{ $blog->id }}" class="btn btn-primary">Edit</a>
																			<form method="post" action="/admin/delete/{{ $blog->id }}">
																				@csrf
																				<button type="submit" class="btn btn-danger">Delete</button>
																			</form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Tidak ada data.</td>
                            </tr>
                        @endif
                    </tbody>
				</table>
				
				{{ $blogs->links() }}
            </div>
        </div>
    </div>
@endsection