@extends('admin.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <h1>Update Movie</h1>
        <form action="{{ route('admin.movies.update', ['id' => $movie->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Sử dụng phương thức PUT để cập nhật dữ liệu -->
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter movie name" value="{{ $movie->name }}">
            </div>
            <div class="form-group">
                <label for="avatar">Avatar:</label>
                <input type="file" class="form-control-file" id="avatar" name="avatar">
            </div>
            <div class="form-group">
                <label for="name_call">Name Call:</label>
                <input type="text" class="form-control" id="name_call" name="name_call" placeholder="Enter name call" value="{{ $movie->name_call }}">
            </div>
            <div class="form-group">
                <label for="studio">Studio:</label>
                <select class="form-control" id="studio" name="studio">
                    @foreach ($studios as $studio)
                        <option value="{{ $studio->id }}" {{ $studio->id == $movie->studio_id ? 'selected' : '' }}>{{ $studio->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="date_aired">Date Aired:</label>
                <input type="date" class="form-control" id="date_aired" name="date_aired" value="{{ $movie->date_aired }}">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ $status->id == $movie->status_id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quality">Quality:</label>
                <select class="form-control" id="quality" name="quality">
                    @foreach ($qualities as $quality)
                        <option value="{{ $quality->id }}" {{ $quality->id == $movie->quality_id ? 'selected' : '' }}>{{ $quality->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" id="type" name="type">
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" {{ $type->id == $movie->type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" value="{{ $movie->quantity }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
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
