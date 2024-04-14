@extends('admin.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <h1>Create CtMovie</h1>
        <form action="{{ route('admin.ct_movies.store') }}" method="POST" enctype="multipart/form-data"> <!-- Thêm enctype="multipart/form-data" để hỗ trợ upload file -->
            @csrf
            <div class="form-group">
                <label for="movie">Movie:</label>
                <select class="form-control" id="movie" name="movie_id">
                    @foreach ($movies as $movie)
                        <option value="{{ $movie->id }}">{{ $movie->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="episode">Episode:</label>
                <select class="form-control" id="episode" name="episode_id">
                    @foreach ($episodes as $episode)
                        <option value="{{ $episode->id }}">{{ $episode->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="link">Link:</label>
                <!-- Thay input type thành file để cho phép người dùng chọn file từ máy tính -->
                <input type="file" class="form-control" id="link" name="link">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is_block" name="isBlock">
                <label class="form-check-label" for="is_block">Is Blocked</label>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div><!-- /.container-fluid -->
</div>
@endsection
