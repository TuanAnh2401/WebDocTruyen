<!-- admin/movies/index.blade.php -->
@extends('admin.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <h1>Danh sách phim</h1>
        <!-- Add a button to navigate to the create movie page -->
        <a href="{{ route('movies.create') }}" class="btn btn-primary mb-3">Thêm phim mới</a>

        <!-- Search bar -->
        <form action="{{ route('admin.movies.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên" value="{{ $search }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-secondary">Tìm kiếm</button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Hình ảnh</th>
                    <th>Studio</th>
                    <th>Trạng thái</th>
                    <th>Ngày phát sóng</th>
                    <th>Điểm</th>
                    <th>Xếp hạng</th>
                    <th>Thời lượng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->name }}</td>
                    <td><img src="{{ asset('img/anime/' .$movie->avatar) }}" width="35" height="35"></td>
                    <td>{{ $movie->studio ? $movie->studio->name : 'N/A' }}</td>
                    <td>{{ $movie->status ? $movie->status->name : 'N/A' }}</td>
                    <td>{{ $movie->date_aired ? $movie->date_aired : 'N/A' }}</td>
                    <td>{{ $movie->scores ? $movie->scores : 'N/A' }}</td>
                    <td>{{ $movie->rating ? $movie->rating : 'N/A' }}</td>
                    <td>{{ $movie->duration ? $movie->duration : 'N/A' }}</td>
                    <td>
                        @if($movie->isDelete)
                            <form id="restore_form_{{ $movie->id }}" action="{{ route('admin.movies.restore', ['id' => $movie->id]) }}" method="post">
                                @csrf
                                @method('post')
                                <button type="submit" class="btn btn-success">Restore</button>
                            </form>
                        @else
                            <form id="delete_form_{{ $movie->id }}" action="{{ route('admin.movies.delete', ['id' => $movie->id]) }}" method="post">
                                @csrf
                                @method('post')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $movie->id }})">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center"> <!-- Center align pagination -->
            {{ $movies->links() }}
        </div>
    </div><!-- /.container-fluid -->
</div>
<script>
    function confirmDelete(movieId) {
        if (confirm('Bạn có chắc chắn muốn xóa phim này?')) {
            document.getElementById('delete_form_' + movieId).submit();
        }
    }
</script>
@endsection
