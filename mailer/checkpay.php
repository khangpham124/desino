
<?php
session_start();
if(!$_COOKIE['order_cookies']) {    
    header('Location:https://desino.vn/');
    die();
}
?>
<?php
$err = $_GET['vpc_ResponseCode'];
switch ($err) {
    case 0:
    $ett_txt = "Giao dịch thanh toán thành công";
    break;
    case 1:
    $ett_txt = "Bank system reject (card closed, account closed)";
    break;
    case 3:
    $ett_txt = "Giao dịch không thành công, thẻ hoặc tài khoản bị khóa";
    break;
    case 4:
    $ett_txt = "Quý khách nhập sai mật khẩu OTP 3 lần liên tiếp, vui lòng thực hiện lại giao dịch";
    break;
    case 5:
    $ett_txt = "No reply from Bank";
    break;
    case 6:
    $ett_txt = "Bank Communication failure";
    break;
    case 7:
    $ett_txt = "Insufficient fund";
    break;
    case 8:
    $ett_txt = "Invalid checksum";
    break;
    case 9:
    $ett_txt = "Transaction type not support";
    break;
    case 10:
    $ett_txt = "Other error";
    break;
    case 11:
    $ett_txt = "Verify card is successful";
    break;
    case 12:
    $ett_txt = "Giao dịch không thành công, tài khoản khách hàng không đủ tiền để thanh toán";
    break;
    case 13:
    $ett_txt = "Quý khách chưa đăng ký dịch vụ thanh toán qua internet. Vui lòng liên hệ với Ngân hàng để biết thêm chi tiết";
    break;
    case 14:
    $ett_txt = "Qúy khách vui lòng nhập chính xác chuỗi ký tự hiển thị bên dưới";
    break;
    case 15:
    $ett_txt = "Sai tên truy cập, mật khẩu hoặc Quý khách đã ngừng sử dụng dịch vụ IB@nking";
    break;
    case 16:
    $ett_txt = "Tên chủ thẻ không đúng, Quý khách vui lòng nhập lại";
    break;
    case 17:
    $ett_txt = "Số thẻ không đúng, Quý khách vui lòng nhập lại";
    break;
    case 18:
    $ett_txt = "Thông tin thẻ không đúng, Quý khách vui lòng nhập lại";
    break;
    case 19:
    $ett_txt = "Thông tin thẻ không đúng, Quý khách vui lòng nhập lại";
    break;
    case 20:
    $ett_txt = "Giao dịch không thành công, vui lòng thực hiện lại giao dịch";
    break;
    case 21:
    $ett_txt = "Quý khách nhập sai OTP, vui lòng nhập lại";
    break;
    case 22:
    $ett_txt = "Unsuccessful transaction";
    break;
    case 23:
    $ett_txt = "Your payment is not approved. Your card/account is ineligible for payment";
    break;
    case 24:
    $ett_txt = "Giao dịch không thành công, tài khoản khách hàng không đủ tiền để thanh toán";
    break;
    case 25:
    $ett_txt = "Transaction exceeds amount limit.";
    break;
    case 26:
    $ett_txt = "Transactions awaiting confirmation from the bank";
    break;
    case 27:
    $ett_txt = "Quý khách đã nhập sai thông tin 3 lần, vui lòng thực hiện lại giao dịch";
    break;
    case 28:
    $ett_txt = "Giao dịch không thành công, tài khoản khách hàng không đủ tiền để thanh toán";
    break;
    case 28:
    $ett_txt = "Giao dịch không thành công, tài khoản khách hàng không đủ tiền để thanh toán";
    break;
    case 28:
    $ett_txt = "Giao dịch không thành công, tài khoản khách hàng không đủ tiền để thanh toán";
    break;
    case 29:
    $ett_txt = "Transaction failed. Please contact your bank for information.";
    break;
    case 30:
    $ett_txt = "Your payment is unsuccessful. Amount is less than minimum limit.";
    break;
    case 31:
    $ett_txt = "Orders not found";
    break;
    case 32:
    $ett_txt = "Orders not to make payments";
    break;
    case 33:
    $ett_txt = "Duplicate orders";
    break;
}

if ($_COOKIE['methodPay']!='cod')
{   
    if(($_GET['vpc_TransactionNo']!='') && ($_GET['vpc_ResponseCode']== 0|| $_GET['vpc_ResponseCode']== 11))
    {
        $_SESSION['paymemnt_status'] = 'Paid';
        $_SESSION['transactionNo'] = $_GET['vpc_TransactionNo'];
        header('Location:http://heartofdarknessbrewery.com/confirm/');
    } else {
        $ett_att = $ett_txt."Please check your information, or choose another payment method";
        setcookie('err_pay',$ett_txt, time() + 86400, "/");
        header('Location:http://heartofdarknessbrewery.com/checkout/?step=3');
    }
} else {
    header('Location:http://heartofdarknessbrewery.com/confirm/');
}
?>


