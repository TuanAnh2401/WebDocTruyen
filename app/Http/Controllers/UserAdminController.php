<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Role;

class UserAdminController extends Controller
{
    public function index()
    {
        // Lấy danh sách người dùng với phân trang
        $users = User::paginate(10); // Số lượng người dùng trên mỗi trang là 10, bạn có thể điều chỉnh số này nếu cần

        // Trả về view 'admin.users.index' cùng với danh sách người dùng đã được phân trang
        return view('admin.users.index', ['users' => $users]);
    }
    
    public function create()
    {
        // Lấy danh sách các vai trò từ cơ sở dữ liệu
        $roles = Role::all();
        
        // Trả về view 'admin.users.create' cùng với danh sách các vai trò
        return view('admin.users.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        try {
            // Validate dữ liệu yêu cầu
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'role_id' => 'required|exists:roles,id',
            ]);

            // Lấy tệp ảnh từ yêu cầu
            $avatar = $request->file('avatar');

            // Đặt tên mới cho tệp ảnh
            $avatarName = 'user_' . time() . '.' . $avatar->getClientOriginalExtension();

            // Di chuyển tệp ảnh vào thư mục lưu trữ
            $avatar->move(public_path('avatars'), $avatarName);

            // Tạo một người dùng mới
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password); // Hash mật khẩu
            $user->avatar = $avatarName; 
            $user->role_id = $request->role_id;
            
            // Lưu người dùng
            $user->save();

            // Redirect về trang danh sách người dùng với thông báo thành công
            return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
        } catch (ValidationException $e) {
            // Nếu validation thất bại, redirect về trang trước với thông báo lỗi
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Nếu có lỗi không mong muốn, redirect về trang trước với thông báo lỗi
            return redirect()->back()->with('error', 'Failed to create user. Please try again later.');
        }
    }

    // Thêm các phương thức xử lý xóa và khôi phục tài khoản người dùng tương tự như trong controller MovieAdminController
}
