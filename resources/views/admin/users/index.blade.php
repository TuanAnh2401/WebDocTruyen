<!-- resources/views/admin/users/index.blade.php -->
@extends('admin.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <h1>List of Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <select class="form-control role-dropdown" onchange="updateRole({{ $user->id }}, this)">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    
                    <td>
                        <!-- Add action buttons (edit, delete) here -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center"> <!-- Center align pagination -->
            {{ $users->links() }}
        </div>
    </div><!-- /.container-fluid -->
</div>
<script>
    function updateRole(userId, select) {
        var roleId = select.value;
        fetch('/admin/users/' + userId + '/update-role', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                role_id: roleId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to update role.');
            }
            return response.json();
        })
        .then(data => {
            // Cập nhật giao diện nếu cần
            console.log('Role updated successfully!');
        })
        .catch(error => {
            console.error(error.message);
            // Xử lý lỗi nếu cần
        });
    }
</script>
@endsection
