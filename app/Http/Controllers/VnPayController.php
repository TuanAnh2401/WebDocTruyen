<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class VnPayController extends Controller
{
    public function create(Request $request)
    {
        if ($request->amount == 0) {
            return redirect()->back()->with('error', 'Hãy chọn gói dịch vụ');
        }

        $vnp_Returnurl = env('VNP_RETURNURL');
        $vnp_TmnCode = env('VNP_TMNCODE');
        $vnp_HashSecret = env('VNP_HASHSECRET');
        $vnp_Url = env('VNP_URL');

        $vnp_TxnRef = uniqid(); 
        $vnp_OrderInfo = "Thanh toán hóa đơn"; 
        $vnp_OrderType = 'billpayment'; 
        $vnp_Amount = $request->amount * 100; 
        $vnp_Locale = 'vn';
        $vnp_BankCode = $request->bank_code;
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = http_build_query($inputData);

        $vnp_Url = $vnp_Url . "?" . $query;

        if (!empty($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $query, $vnp_HashSecret);
            $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect()->away($vnp_Url);
    }
    public function handle(Request $request)
    {
        if ($request->vnp_ResponseCode == "00") {
            $userId = Auth::id();
            $user = User::find($userId);
    
            if ($user) {
                $newMoney = $user->money + $request->vnp_Amount / 100;
                $user->update(['money' => $newMoney]);
    
                return Redirect::to('/')->with('success', 'Thanh toán thành công');
            } else {
                return Redirect::to('/')->with('error', 'Người dùng không tồn tại');
            }
        } else {
            return Redirect::to('/')->with('error', 'Lỗi trong quá trình thanh toán');
        }
    }
}
