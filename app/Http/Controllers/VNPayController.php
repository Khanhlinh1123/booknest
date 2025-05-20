<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VnPayController extends Controller
{
    public function createPayment(Request $request)
    {
        // Lấy tổng tiền từ request (đơn vị VND)
        $amount = $request->input('tongTien');
        if (!$amount) {
            return redirect()->route('dathang.step1')->with('error', 'Không có tổng tiền để thanh toán.');
        }

        // Cấu hình VNPAY (bạn có thể lấy từ env)
        $vnp_TmnCode = env('VNPAY_TMNCODE', '2QXUI4J4');
        $vnp_HashSecret = env('VNPAY_HASHSECRET', '4F774DCE7A6F5F0FADC1F6410B57C87B');
        $vnp_Url = env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $vnp_Returnurl = env('VNPAY_RETURN_URL', 'http://localhost:8080/vnpay-return');

        $vnp_TxnRef = time(); // Mã giao dịch (có thể thay bằng mã đơn hàng)
        $vnp_OrderInfo = 'Thanh toan don hang BookNest';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $amount * 100; // VNPAY tính tiền theo đơn vị nhỏ nhất (đồng * 100)
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();
        if ($vnp_IpAddr == '::1') {
            $vnp_IpAddr = '127.0.0.1';
        }
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData, '', '&', PHP_QUERY_RFC3986);
        $hashData = $query; // Không urldecode gì thêm
        $vnp_SecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Tạo url thanh toán hoàn chỉnh
        $vnp_Url .= "?" . $query . "&vnp_SecureHash=" . $vnp_SecureHash;

       

        // Chuyển hướng đến cổng thanh toán VNPAY
        return redirect($vnp_Url);
    }

    public function handleReturn(Request $request)
    {
        $input = $request->all();

        $secureHash = $input['vnp_SecureHash'] ?? '';
        unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);

        ksort($input);

        $hashData = http_build_query($input, '', '&', PHP_QUERY_RFC3986);
        $vnp_HashSecret = env('VNPAY_HASHSECRET', '4F774DCE7A6F5F0FADC1F6410B57C87B');

        $reHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        if ($secureHash === $reHash && ($input['vnp_ResponseCode'] ?? '') == '00') {
            // Thanh toán thành công, xử lý lưu đơn hàng...

            return view('dathang.thankyou'); // hoặc redirect về trang khác
        } else {
            return redirect()->route('dathang.step1')->with('error', 'Thanh toán không thành công hoặc bị từ chối.');
        }
    }
}
