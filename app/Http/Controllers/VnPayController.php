<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CtVip;
use App\Models\Price;
use App\Models\Discount;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VnPayController extends Controller
{
    public function create(Request $request)
    {
        $price = Price::where('id', $request->price_id)->where('is_deleted', false)->first();
        if (!$price) {
            return response()->json(['error' => 'Hãy chọn gói dịch vụ'], 422);
        }
        
        $amount = $price->price_sale ?? $price->price;
        $userId = Auth::id();

        $CtVip = CtVip::where('user_id', $userId)->where('is_deleted', false)->first();
        if ($CtVip) {
            return response()->json(['warning' => 'Đã đăng ký gói dịch vụ, vui lòng hủy gói trước'], 422);
        }

        $discount = Discount::where('name', $request->discountCode)->where('is_deleted', false)->first();
        if ($discount) {
            $discountAmount =  $amount * $discount->price / 100;
            $amount -= $discountAmount;
        }

        $request->session()->put('price_id', $request->price_id);

        $vnp_Returnurl = env('VNP_RETURNURL');
        $vnp_TmnCode = env('VNP_TMNCODE');
        $vnp_HashSecret = env('VNP_HASHSECRET');
        $vnp_Url = env('VNP_URL');

        $vnp_TxnRef = uniqid();
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $amount * 100;
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

        return response()->json(['redirect_url' => $vnp_Url]);
    }


    public function handle(Request $request)
    {
        if ($request->vnp_ResponseCode == "00") {
            $userId = Auth::id();
            $user = User::find($userId);

            if ($user) {
                $priceId = $request->session()->pull('price_id');
                $price = Price::find($priceId);
                if (!$price) {
                    return Redirect::to('/')->with('error', 'Giá không tồn tại');
                }
                $numberOfDays = $price->number_of_days;
                $endDate = Carbon::now()->addDays($numberOfDays)->toDateTimeString();
                $newMoney = $user->money + $request->vnp_Amount / 100;
                CtVip::where('user_id', $userId)->update(['is_deleted' => true]);

                CtVip::create([
                    'user_id' => $userId,
                    'price_id' => $priceId,
                    'end_date' => $endDate,
                    'price' => $newMoney,
                ]);

                Session::flash('success', 'Thanh toán thành công');
            } else {
                Session::flash('error', 'Người dùng không tồn tại');
            }
        } else {
            Session::flash('error', 'Lỗi trong quá trình thanh toán');
        }

        return Redirect::to('/');
    }
}
