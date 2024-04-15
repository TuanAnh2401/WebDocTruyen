<!-- admin/movies/index.blade.php -->
@extends('admin.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <h1>List of Movies</h1>
        <!-- Add a button to navigate to the create movie page -->
        <a href="{{ route('movies.create') }}" class="btn btn-primary mb-3">Add a new movie</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Avatar</th>
                    <th>Studio</th>
                    <th>Status</th>
                    <th>Date Aired</th>
                    <th>Scores</th>
                    <th>Rating</th>
                    <th>Duration</th>
                    <th>IsDetele</th> <!-- Thêm cột cho các hành động -->
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
        if (confirm('Are you sure you want to delete this movie?')) {
            document.getElementById('delete_form_' + movieId).submit();
        }
    }
</script>
@endsection
