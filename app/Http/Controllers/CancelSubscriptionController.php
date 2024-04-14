<?php

namespace App\Http\Controllers;

use App\Models\CtVip;
use Illuminate\Http\Request;

class CancelSubscriptionController extends Controller
{
    public function cancel(Request $request)
    {
        $ctVip = CtVip::where('user_id', auth()->id())
                      ->where('is_deleted', false)
                      ->first();

        if (!$ctVip) {
            return response()->json(['error' => 'Không tìm thấy đăng ký dịch vụ chưa bị xóa cho người dùng này'], 404);
        }

        $ctVip->update(['is_deleted' => true]);

        return redirect()->route('user.profile')->with('success', 'Đã hủy dịch vụ thành công');
    }
}
