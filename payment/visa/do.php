<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH_WP."/wp-load.php");
$_SESSION['fullname']= htmlspecialchars($_POST['fullname']);
$_SESSION['address']= htmlspecialchars($_POST['address']);
$_SESSION['phone']= htmlspecialchars($_POST['phone']);
$_SESSION['mail']= htmlspecialchars($_POST['mail']);
$_SESSION['note']= htmlspecialchars($_POST['note']);
$_SESSION['order_des']= $_POST['order_des'];
$_SESSION['payment']= $_POST['payment'];
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

$arr = array() ;
$arr['vpc_OrderInfo'] = $_POST['order_des'];
$arr['vpc_ReturnURL'] = vpc_ReturnURL;
$arr['vpc_Merchant'] = "TESTONEPAY";
$arr['vpc_AccessCode'] = "6BEB2546";
$arr['vpc_MerchTxnRef'] = date ( "YmdHis" ).rand () ;
$arr['vpc_Amount'] = $amount * 100;
$arr['vpc_Version'] = "2";
$arr['vpc_Command'] = "pay";
$arr['vpc_Locale'] = "en";
$arr['vpc_Currency'] = "VND";

$arr['AVS_Country'] = $_POST['AVS_Country'];
$arr['AVS_City'] = $_POST['AVS_City'];
$arr['AVS_StateProv'] = $_POST['AVS_StateProv'];
$arr['AVS_PostCode'] = $_POST['AVS_PostCode'];
$arr['display'] = $_POST['display'];
$arr['Title'] = $_POST['Title'];
$arr['AgainLink']=urlencode($_SERVER['HTTP_REFERER']);


 //Version 2.0

// *********************
// START OF MAIN PROGRAM
// *********************

// Define Constants
// ----------------
// This is secret for encoding the MD5 hash
// This secret will vary from merchant to merchant
// To not create a secure hash, let SECURE_SECRET be an empty string - ""
// $SECURE_SECRET = "secure-hash-secret";
$SECURE_SECRET = "6D0870CDE5F24F34F3915FB0045120DB";

// add the start of the vpcURL querystring parameters
$vpcURL = $_POST["virtualPaymentClientURL"] . "?";

// Remove the Virtual Payment Client URL from the parameter hash as we 
// do not want to send these fields to the Virtual Payment Client.
unset($_POST["virtualPaymentClientURL"]); 

// The URL link for the receipt to do another transaction.
// Note: This is ONLY used for this example and is not required for 
// production code. You would hard code your own URL into your application.

// Get and URL Encode the AgainLink. Add the AgainLink to the array
// Shows how a user field (such as application SessionIDs) could be added



//$_POST['AgainLink']=urlencode($_SERVER['HTTP_REFERER']);
// Create the request to the Virtual Payment Client which is a URL encoded GET
// request. Since we are looping through all the data we may as well sort it in
// case we want to create a secure hash and add it to the VPC data if the
// merchant secret has been provided.
//$md5HashData = $SECURE_SECRET; Khởi tạo chuỗi dữ liệu mã hóa trống
$md5HashData = "";


ksort ($arr);

// set a parameter to show the first pair in the URL
$appendAmp = 0;

foreach($arr as $key => $value) {

    // create the md5 input and URL leaving out any fields that have no value
    if (strlen($value) > 0) {
        
        // this ensures the first paramter of the URL is preceded by the '?' char
        if ($appendAmp == 0) {
            $vpcURL .= urlencode($key) . '=' . urlencode($value);
            $appendAmp = 1;
        } else {
            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
        }
        //$md5HashData .= $value; sử dụng cả tên và giá trị tham số để mã hóa
        if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
		    $md5HashData .= $key . "=" . $value . "&";
		}
    }
}
//xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa
$md5HashData = rtrim($md5HashData, "&");
// Create the secure hash and append it to the Virtual Payment Client Data if
// the merchant secret has been provided.
if (strlen($SECURE_SECRET) > 0) {
    //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
    // Thay hàm mã hóa dữ liệu
    $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$SECURE_SECRET)));
}

// FINISH TRANSACTION - Redirect the customers using the Digital Order
// ===================================================================
header("Location: ".$vpcURL);

// *******************
// END OF MAIN PROGRAM
// *******************

