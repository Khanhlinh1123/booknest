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

    $vnp_TmnCode = config('vnpay.tmn_code');
    $vnp_HashSecret = config('vnpay.hash_secret');
    $vnp_Url = config('vnpay.url');
    $vnp_Returnurl = config('vnpay.return_url');

    $vnp_TxnRef = time(); // Mã giao dịch (có thể thay bằng mã đơn hàng)
    $vnp_OrderInfo = 'Thanh toan don hang BookNest';
    $vnp_OrderType = 'billpayment';
    $amount = (int) $request->input('tongTien');
    $vnp_Amount = $amount * 100;    
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
        "vnp_TxnRef" => $vnp_TxnRef,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_BankCode" => "NCB"
 // ✅ ĐÚNG KEY CHUẨN
    ];
    

    ksort($inputData);
 
// 1. Build query string
$queryString = http_build_query($inputData, '', '&', PHP_QUERY_RFC3986);

// 2. Tạo secure hash
$hashData = $queryString;
$vnp_SecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// 3. Gắn đầy đủ vào URL
$vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?' . $queryString . '&vnp_SecureHash=' . $vnp_SecureHash;
dd([
    'return_url_env' => env('VNPAY_RETURN_URL'),
    'return_url_config' => config('vnpay.return_url'),
]);
// 4. Chuyển hướng
return redirect($vnp_Url);
}

public function handleReturn(Request $request)
{
    $input = $request->all();

    // Lấy Secure Hash từ kết quả trả về
    $secureHash = $input['vnp_SecureHash'] ?? '';
    unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);

    // Sắp xếp dữ liệu trả về theo key
    ksort($input); // Quan trọng! VNPAY yêu cầu các tham số phải SORT theo key

    // ✅ Dùng đúng format encode
    $hashData = http_build_query($input, '', '&', PHP_QUERY_RFC3986);

    $vnp_HashSecret = config('vnpay.hash_secret'); // nên dùng config thay vì env trực tiếp
    $reHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    dd([
        'all' => $request->all(),
        'secureHash' => $request->input('vnp_SecureHash'),
    ]);
    
    // So sánh chữ ký để xác thực
    if ($secureHash === $reHash && ($input['vnp_ResponseCode'] ?? '') == '00') {
        // Thanh toán thành công
        return view('dathang.thankyou');
    } else {
        return redirect()->route('dathang.step1')->with('error', 'Thanh toán không thành công hoặc bị từ chối.');
    }
}

}
