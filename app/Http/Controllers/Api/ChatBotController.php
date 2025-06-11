<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sach;
use App\Models\TacGia;
use App\Models\DanhMuc;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Models\KhuyenMai; // Assuming you have a KhuyenMai model for promotions

class ChatBotController extends Controller
{
    public function handle(Request $request)
    {
        $text = $request->input('queryInput.text.text');
        if (!$text) {
            return response()->json(['fulfillmentText' => 'Không nhận được câu hỏi.']);
        }

        Log::info('Người dùng hỏi:', [$text]);

        // ===== 1. Tìm theo tác giả =====
        $tacgiaList = TacGia::all();
        foreach ($tacgiaList as $tg) {
            if (Str::contains(Str::lower($text), Str::lower($tg->tenTG))) {
                $sach = Sach::where('maTG', $tg->maTG)->pluck('tenSach');
                if ($sach->isEmpty()) {
                    return response()->json([
                        'fulfillmentText' => 'Không tìm thấy sách nào của ' . $tg->tenTG . '.'
                    ]);
                }
                return response()->json([
                    'fulfillmentText' => 'Các sách của ' . $tg->tenTG . ': ' . $sach->join(', ')
                ]);
            }
        }

        // ===== 2. Tìm theo danh mục (thể loại) =====
        $danhMucList = DanhMuc::all();
        foreach ($danhMucList as $dm) {
            if (Str::contains(Str::lower($text), Str::lower($dm->tenDM))) {
                $sach = Sach::where('maDM', $dm->maDM)->pluck('tenSach');
                if ($sach->isEmpty()) {
                    return response()->json([
                        'fulfillmentText' => "Không tìm thấy sách thuộc thể loại {$dm->tenDM}."
                    ]);
                }
                return response()->json([
                    'fulfillmentText' => "Hiện BookNest đang có một số sách thuộc thể loại {$dm->tenDM} là " . $sach->join(', ')
                ]);
            }
        }

        // ===== 3. Tìm theo từ khóa trong tên sách =====
        if (Str::contains(Str::lower($text), 'sách') && Str::contains(Str::lower($text), 'tên')) {
            preg_match('/tên (.+)/i', $text, $matches);
            $keyword = $matches[1] ?? null;
            if ($keyword) {
                $sach = Sach::where('tenSach', 'like', '%' . $keyword . '%')->pluck('tenSach');
                if ($sach->isEmpty()) {
                    return response()->json([
                        'fulfillmentText' => "Không tìm thấy sách nào có từ '$keyword' trong tên."
                    ]);
                }
                return response()->json([
                    'fulfillmentText' => "Các sách có chữ '$keyword' trong tên: " . $sach->join(', ')
                ]);
            }
            return response()->json([
                'fulfillmentText' => 'Bạn muốn tìm sách có từ nào trong tên?'
            ]);
        }
        // ===== 4. Xin chào, Hello =====
        if (preg_match('/^(xin chào|hello|hi|chào|yo)/i', $text)) {
            return response()->json([
                'fulfillmentText' => 'Chào bạn 👋 Mình là chatbot của BookNest! Bạn muốn tìm sách theo tác giả, thể loại hay hỏi về đặt hàng nè?'
            ]);
        }

        // ===== 5. Phương thức thanh toán =====
        if (Str::contains(Str::lower($text), 'thanh toán') || Str::contains(Str::lower($text), 'trả tiền')) {
            return response()->json([
                'fulfillmentText' => 'Bạn có thể thanh toán qua các phương thức: COD (trả tiền khi nhận hàng), ví Momo hoặc chuyển khoản ngân hàng nhé.'
            ]);
        }

        // ===== 6. Phương thức vận chuyển / giao hàng =====
        if (
            Str::contains(Str::lower($text), 'vận chuyển') ||
            Str::contains(Str::lower($text), 'giao hàng') ||
            Str::contains(Str::lower($text), 'ship')
        ) {
            return response()->json([
                'fulfillmentText' => 'BookNest hỗ trợ giao hàng toàn quốc thông qua đối tác như GHTK, J&T, Viettel Post... Giao nhanh từ 2–5 ngày tùy khu vực nha!'
            ]);
        }

        // ===== 7. Hỏi giá sách =====
        if (Str::contains(Str::lower($text), 'giá') && Str::contains(Str::lower($text), 'sách')) {
            $sachList = Sach::all();
            foreach ($sachList as $s) {
                if (Str::contains(Str::lower($text), Str::lower($s->tenSach))) {
                    $gia = number_format($s->giaGoc, 0, ',', '.') . 'đ';
                    return response()->json([
                        'fulfillmentText' => "Giá của sách \"{$s->tenSach}\" là $gia."
                    ]);
                }
            }
            return response()->json([
                'fulfillmentText' => 'Bạn muốn hỏi giá sách nào nhỉ?'
            ]);
        }

        // ===== 8. Hỏi về khuyến mãi hiện tại =====
        if (
            Str::contains(Str::lower($text), 'khuyến mãi') ||
            Str::contains(Str::lower($text), 'khuyến mại') ||
            Str::contains(Str::lower($text), 'giảm giá') ||
            Str::contains(Str::lower($text), 'sale')
        ) {
            $now = Carbon::now();
            $km = KhuyenMai::where('batDau', '<=', $now)
                ->where('ketThuc', '>=', $now)
                ->get();

            if ($km->isEmpty()) {
                return response()->json([
                    'fulfillmentText' => 'Hiện tại không có chương trình khuyến mãi nào đang diễn ra.'
                ]);
            }

            $info = $km->map(fn($k) => "{$k->tenKM} ({$k->giaTri}% {$k->loaiGiam}) đến {$k->ketThuc->format('d/m')}")->join('; ');
            return response()->json([
                'fulfillmentText' => "Các chương trình khuyến mãi hiện có: $info"
            ]);
        }

        // ===== Mặc định =====
        return response()->json([
            'fulfillmentText' => 'Xin lỗi, mình chưa hiểu yêu cầu. Bạn có thể hỏi về tên sách, thể loại hoặc tác giả nha!'
        ]);
    }
}
