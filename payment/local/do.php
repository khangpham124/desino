<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
$_SESSION['fullname']= htmlspecialchars($_POST['fullname']);
$_SESSION['address']= htmlspecialchars($_POST['address']);
$_SESSION['phone']= htmlspecialchars($_POST['phone']);
$_SESSION['mail']= htmlspecialchars($_POST['mail']);
$_SESSION['note']= htmlspecialchars($_POST['note']);
$_SESSION['order_des']= $_POST['order_des'];
$_SESSION['payment']= $_POST['payment'];
include(APP_PATH_WP."/wp-load.php");
/* -----------------------------------------------------------------------------
 Version 2.0
 @author OnePAY
------------------------------------------------------------------------------*/

// *********************
// START OF MAIN PROGRAM
// *********************

// Define Constants
// ----------------
// This is secret for encoding the MD5 hash
// This secret will vary from merchant to merchant
// To not create a secure hash, let SECURE_SECRET be an empty string - ""
// $SECURE_SECRET = "secure-hash-secret";
// Khóa bí mật - được cấp bởi OnePAY
$SECURE_SECRET = "A3EFDFABA8653DF2342E8DAC29B51AF0";

// add the start of the vpcURL querystring parameters
// *****************************Lấy giá trị url cổng thanh toán*****************************
$vpcURL = $_POST["virtualPaymentClientURL"] . "?";

// Remove the Virtual Payment Client URL from the parameter hash as we 
// do not want to send these fields to the Virtual Payment Client.
// bỏ giá trị url và nút submit ra khỏi mảng dữ liệu
unset($_POST["virtualPaymentClientURL"]); 
unset($_POST["SubButL"]);

//$stringHashData = $SECURE_SECRET; *****************************Khởi tạo chuỗi dữ liệu mã hóa trống*****************************
$stringHashData = "";
// sắp xếp dữ liệu theo thứ tự a-z trước khi nối lại
// arrange array data a-z before make a hash
// echo $_POST['order_des'];
$f_isset = $_SERVER['DOCUMENT_ROOT'].'/ajax/tmp/'.$_POST['order_des'].'.json';
$curr_cart  = json_decode(file_get_contents($f_isset));
// var_dump($curr_cart);
$arr_price = array();
foreach($curr_cart as $mydata)
{
    if(get_field('special-offer',$mydata->id)!=0) {
        $price_real = get_field('price',$mydata->id);
        $promo = get_field('special-offer',$mydata->id);
        $price_dis = ($price_real * $promo) / 100;
        $price_no = $price_real - $price_dis;
    }else{
        $price_no = get_field('price',$mydata->id);
    }
    $count_price = ($mydata->quantity * $price_no);
    $arr_price[] = $count_price;
    $amount = $price_no * $mydata->quantity;
}

$_SESSION['amount']= $amount;


$arr = array() ;
$arr['vpc_OrderInfo'] = $_POST['order_des'];
$arr['vpc_ReturnURL'] = vpc_ReturnURL;
$arr['vpc_Merchant'] = "ONEPAY";
$arr['vpc_AccessCode'] = "D67342C2";
$arr['vpc_MerchTxnRef'] = date ( "YmdHis" ).rand () ;
$arr['vpc_Amount'] = $amount * 100;
$arr['vpc_Version'] = "2";
$arr['vpc_Command'] = "pay";
$arr['vpc_Locale'] = "vn";
$arr['vpc_Currency'] = "VND";

ksort ($arr);
// set a parameter to show the first pair in the URL
// đặt tham số đếm = 0
$appendAmp = 0;

foreach($arr as $key => $value) {

    // create the md5 input and URL leaving out any fields that have no value
    // tạo chuỗi đầu dữ liệu những tham số có dữ liệu
    if (strlen($value) > 0) {
        // this ensures the first paramter of the URL is preceded by the '?' char
        if ($appendAmp == 0) {
            $vpcURL .= urlencode($key) . '=' . urlencode($value);
            $appendAmp = 1;
        } else {
            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
        }
        //$stringHashData .= $value; *****************************sử dụng cả tên và giá trị tham số để mã hóa*****************************
        if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
		    $stringHashData .= $key . "=" . $value . "&";
		}
    }
}
//*****************************xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa*****************************
$stringHashData = rtrim($stringHashData, "&");
// Create the secure hash and append it to the Virtual Payment Client Data if
// the merchant secret has been provided.
// thêm giá trị chuỗi mã hóa dữ liệu được tạo ra ở trên vào cuối url
if (strlen($SECURE_SECRET) > 0) {
    //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($stringHashData));
    // *****************************Thay hàm mã hóa dữ liệu*****************************
    $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$SECURE_SECRET)));
}


// FINISH TRANSACTION - Redirect the customers using the Digital Order
// ===================================================================
// chuyển trình duyệt sang cổng thanh toán theo URL được tạo ra
header("Location: ".$vpcURL);


// *******************
// END OF MAIN PROGRAM
// *******************

