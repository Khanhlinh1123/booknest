<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\GioHang;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;


class MomoController extends Controller
{

    public function createPayment(Request $request)
    {
        Log::info('Đã vào createPayment MoMo');
        Log::info('Bắt đầu gọi MoMo với:', $request->all());

        $paymentSession = session('tam_thanh_toan');

        if (!$paymentSession) {
            return redirect()->route('giohang.index')->with('error', 'Phiên thanh toán không hợp lệ.');
        }

        $tongTien = (int) $request->tongTien; // ép về số nguyên
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderId = time() . "";
        $orderInfo = "Thanh toán đơn hàng tại Capuccina Bookstore";
        $redirectUrl = route('momo.callback');
        $ipnUrl = route('momo.callback');
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";

        $rawHash = "accessKey=$accessKey&amount=$tongTien&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "MoMo Payment",
            'storeId' => "Booknest",
            'requestId' => $requestId,
            'amount' => $tongTien,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        Log::info('Phản hồi MoMo:', ['raw' => $result]);

        $jsonResult = json_decode($result, true);


        if (isset($jsonResult['payUrl'])) {
            return redirect($jsonResult['payUrl']);
        }

        return back()->with('error', 'Không thể khởi tạo thanh toán MoMo.');
    }

    public function momoCallback(Request $request)
{
    Log::info('MoMo callback:', $request->all());

    if ($request->resultCode == 0) {
        // Giao dịch thành công → tạo đơn hàng tại đây
        $session = session('tam_thanh_toan');

        if (!$session) {
            return view('payment.momo_callback')->with('error', 'Không tìm thấy phiên thanh toán.');
        }

        $user = auth()->user();
        $gioHang = $session['gioHang'];
        $thongTin = $session['thongTin'];
        $tongTien = $request->amount;

        $donHang = DonHang::create([
            'maND' => $user->maND,
            'tenNguoiNhan' => $thongTin['ten'],
            'soDT' => $thongTin['soDT'],
            'diaChi' => $thongTin['diaChiFull'],
            'tongTien' => $tongTien,
            'phuongThucGH' => 'momo',
            'tinhTrang' => 'Đang xử lý',
        ]);

        foreach ($gioHang as $item) {
            ChiTietDonHang::create([
                'maDH' => $donHang->maDH,
                'maSach' => $item['sach']->maSach,
                'soLuong' => $item['soLuong'],
                'giaMua' => $item['sach']->giaDaGiam,
            ]);

            $item['sach']->soLuong -= $item['soLuong'];
            $item['sach']->save();
        }

        session()->forget(['gioHangDat', 'tam_thanh_toan']);

        return view('dathang.thankyou', compact('donHang'));
    }

    return view('payment.momo_callback')->with('error', 'Giao dịch thất bại hoặc bị huỷ.');
}

}
