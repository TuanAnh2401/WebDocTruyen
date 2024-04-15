<!-- admin/ct_movies/index.blade.php -->
@extends('admin.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <h1>List of CtMovies</h1>
        <!-- Add a button to navigate to the create ct_movie page -->
        <a href="{{ route('admin.ct_movies.create') }}" class="btn btn-primary mb-3">Add a new CtMovie</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Movie</th>
                    <th>Episode</th>
                    <th>Link</th>
                    <th>Is Blocked</th>
                    <th>Is Deleted</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ctMovies as $ctMovie)
                <tr>
                    <td>{{ $ctMovie->movie ? $ctMovie->movie->name : 'N/A' }}</td>
                    <td>{{ $ctMovie->episode ? $ctMovie->episode->name : 'N/A' }}</td>
                    <td>{{ $ctMovie->link }}</td>
                    <td>
                        @if($ctMovie->isBlock)
                            <form id="unblock_form_{{ $ctMovie->id }}" action="{{ route('admin.ct_movies.unblock', ['id' => $ctMovie->id]) }}" method="post">
                                @csrf
                                @method('post')
                                <button type="submit" class="btn btn-success">Un Block</button>
                            </form>
                        @else
                            <form id="block_form_{{ $ctMovie->id }}" action="{{ route('admin.ct_movies.block', ['id' => $ctMovie->id]) }}" method="post">
                                @csrf
                                @method('post')
                                <button type="button" class="btn btn-danger" onclick="confirmBlock({{ $ctMovie->id }})">Block</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if($ctMovie->isDelete)
                            <form id="restore_form_{{ $ctMovie->id }}" action="{{ route('admin.ct_movies.restore', ['id' => $ctMovie->id]) }}" method="post">
                                @csrf
                                @method('post')
                                <button type="submit" class="btn btn-success">Restore</button>
                            </form>
                        @else
                            <form id="delete_form_{{ $ctMovie->id }}" action="{{ route('admin.ct_movies.delete', ['id' => $ctMovie->id]) }}" method="post">
                                @csrf
                                @method('post')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $ctMovie->id }})">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center"> <!-- Center align pagination -->
            {{ $ctMovies->links() }}
        </div>
    </div><!-- /.container-fluid -->
</div>
<script>
    function confirmDelete(ctMovieId) {
        if (confirm('Are you sure you want to delete this CtMovie?')) {
            document.getElementById('delete_form_' + ctMovieId).submit();
        }
    }
    function confirmBlock(ctMovieId) {
        if (confirm('Are you sure you want to block this CtMovie?')) {
            document.getElementById('block_form_' + ctMovieId).submit();
        }
    }
</script>
@endsection
