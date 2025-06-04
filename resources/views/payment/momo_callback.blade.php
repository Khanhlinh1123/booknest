@include ('header');
<h3>🎉 Thanh toán MoMo callback</h3>

@if (isset($error))
    <p style="color: red">{{ $error }}</p>
@else
    <p style="color: green">Giao dịch thành công. Cảm ơn bạn đã mua hàng tại Capuccina Bookstore!</p>
@endif