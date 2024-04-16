@extends('admin.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <h1>Thêm mới phim</h1>
        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter movie name">
            </div>
            <div class="form-group">
                <label for="avatar">Hình ảnh:</label>
                <input type="file" class="form-control-file" id="avatar" name="avatar">
            </div>
            <div class="form-group">
                <label for="name_call">Tên gọi khác:</label>
                <input type="text" class="form-control" id="name_call" name="name_call" placeholder="Enter name call">
            </div>
            <div class="form-group">
                <label for="studio">Hãng làm phim:</label>
                <select class="form-control" id="studio" name="studio">
                    @foreach ($studios as $studio)
                        <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="date_aired">Ngày phát sóng:</label>
                <input type="date" class="form-control" id="date_aired" name="date_aired">
            </div>
            <div class="form-group">
                <label for="status">Trạng tháithái:</label>
                <select class="form-control" id="status" name="status">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quality">Chất lượng:</label>
                <select class="form-control" id="quality" name="quality">
                    @foreach ($qualities as $quality)
                        <option value="{{ $quality->id }}">{{ $quality->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="type">Kiểu:</label>
                <select class="form-control" id="type" name="type">
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="Số lượng tập">Số tập:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity">
            </div>
            <button type="submit" class="btn btn-primary">Thêm mới</button>
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
