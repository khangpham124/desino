<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
$SECURE_SECRET = "A3EFDFABA8653DF2342E8DAC29B51AF0";
$vpc_Txn_Secure_Hash = $_GET ["vpc_SecureHash"];
unset ( $_GET ["vpc_SecureHash"] );
unset ( $_SESSION['err_pend'] );
unset ( $_SESSION['err_fail'] );

// set a flag to indicate if hash has been validated
$errorExists = false;

ksort ($_GET);

if (strlen ( $SECURE_SECRET ) > 0 && $_GET ["vpc_TxnResponseCode"] != "7" && $_GET ["vpc_TxnResponseCode"] != "No Value Returned") {
    
    //$stringHashData = $SECURE_SECRET;
    //*****************************khởi tạo chuỗi mã hóa rỗng*****************************
    $stringHashData = "";
    
    // sort all the incoming vpc response fields and leave out any with no value
    foreach ( $_GET as $key => $value ) {
//        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
//            $stringHashData .= $value;
//        }
//      *****************************chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về*****************************
        if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
            $stringHashData .= $key . "=" . $value . "&";
        }
    }
//  *****************************Xóa dấu & thừa cuối chuỗi dữ liệu*****************************
    $stringHashData = rtrim($stringHashData, "&");	
    
    
//    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $stringHashData ) )) {
//    *****************************Thay hàm tạo chuỗi mã hóa*****************************
    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$SECURE_SECRET)))) {
        // Secure Hash validation succeeded, add a data field to be displayed
        // later.
        $hashValidated = "CORRECT";
    } else {
        // Secure Hash validation failed, add a data field to be displayed
        // later.
        $hashValidated = "INVALID HASH";
    }
} else {
    // Secure Hash was not validated, add a data field to be displayed later.
    $hashValidated = "INVALID HASH";
}

// Define Variables
// ----------------
// Extract the available receipt fields from the VPC Response
// If not present then let the value be equal to 'No Value Returned'
// Standard Receipt Data
$amount = null2unknown ( $_GET ["vpc_Amount"] );
$locale = null2unknown ( $_GET ["vpc_Locale"] );
//$batchNo = null2unknown ( $_GET ["vpc_BatchNo"] );
$command = null2unknown ( $_GET ["vpc_Command"] );
//$message = null2unknown ( $_GET ["vpc_Message"] );
$version = null2unknown ( $_GET ["vpc_Version"] );
//$cardType = null2unknown ( $_GET ["vpc_Card"] );
$orderInfo = null2unknown ( $_GET ["vpc_OrderInfo"] );
//$receiptNo = null2unknown ( $_GET ["vpc_ReceiptNo"] );
$merchantID = null2unknown ( $_GET ["vpc_Merchant"] );
//$authorizeID = null2unknown ( $_GET ["vpc_AuthorizeId"] );
$merchTxnRef = null2unknown ( $_GET ["vpc_MerchTxnRef"] );
$transactionNo = null2unknown ( $_GET ["vpc_TransactionNo"] );
//$acqResponseCode = null2unknown ( $_GET ["vpc_AcqResponseCode"] );
$txnResponseCode = null2unknown ( $_GET ["vpc_TxnResponseCode"] );

// This is the display title for 'Receipt' page 
//$title = $_GET ["Title"];


// This method uses the QSI Response code retrieved from the Digital
// Receipt and returns an appropriate description for the QSI Response Code
//
// @param $responseCode String containing the QSI Response Code
//
// @return String containing the appropriate description
//
function getResponseDescription($responseCode) {
    
    switch ($responseCode) {
        case "0" :
            $result = "Giao dịch thành công - Approved";
            break;
        case "1" :
            $result = "Ngân hàng từ chối giao dịch - Bank Declined";
            break;
        case "3" :
            $result = "Mã đơn vị không tồn tại - Merchant not exist";
            break;
        case "4" :
            $result = "Không đúng access code - Invalid access code";
            break;
        case "5" :
            $result = "Số tiền không hợp lệ - Invalid amount";
            break;
        case "6" :
            $result = "Mã tiền tệ không tồn tại - Invalid currency code";
            break;
        case "7" :
            $result = "Lỗi không xác định - Unspecified Failure ";
            break;
        case "8" :
            $result = "Số thẻ không đúng - Invalid card Number";
            break;
        case "9" :
            $result = "Tên chủ thẻ không đúng - Invalid card name";
            break;
        case "10" :
            $result = "Thẻ hết hạn/Thẻ bị khóa - Expired Card";
            break;
        case "11" :
            $result = "Thẻ chưa đăng ký sử dụng dịch vụ - Card Not Registed Service(internet banking)";
            break;
        case "12" :
            $result = "Ngày phát hành/Hết hạn không đúng - Invalid card date";
            break;
        case "13" :
            $result = "Vượt quá hạn mức thanh toán - Exist Amount";
            break;
        case "21" :
            $result = "Số tiền không đủ để thanh toán - Insufficient fund";
            break;
        case "99" :
            $result = "Người sủ dụng hủy giao dịch - User cancel";
            break;
        default :
            $result = "Giao dịch thất bại - Failured";
    }
    return $result;
}

//  -----------------------------------------------------------------------------
// If input is null, returns string "No Value Returned", else returns input
function null2unknown($data) {
    if ($data == "") {
        return "No Value Returned";
    } else {
        return $data;
    }
}
//  ----------------------------------------------------------------------------
if($_SESSION['payment']=='atm') {
    $transStatus = "";
    if($hashValidated=="CORRECT" && $txnResponseCode=="0"){
        $_SESSION['transactionNo'] = $transactionNo;
        header("Location: ".urlConfirm);
    }elseif ($hashValidated=="INVALID HASH" && $txnResponseCode=="0"){
        $_SESSION['err_pend'] = $message. "Your payment is pending. Please try again.";
        header("Location: ".urlError);
    }else {
        $_SESSION['err_fail'] = $message. "Your payment is fail. Please check and try again.";
    header("Location: ".urlError);
    } 
?>

<?php
} else {

    $SECURE_SECRET = "6D0870CDE5F24F34F3915FB0045120DB";

    // get and remove the vpc_TxnResponseCode code from the response fields as we
    // do not want to include this field in the hash calculation
    $vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
    $vpc_MerchTxnRef = $_GET["vpc_MerchTxnRef"];
    $vpc_AcqResponseCode = $_GET["vpc_AcqResponseCode"];
    unset($_GET["vpc_SecureHash"]);
    // set a flag to indicate if hash has been validated
    $errorExists = false;
    
    if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {
    
        ksort($_GET);
        //$md5HashData = $SECURE_SECRET;
        //khởi tạo chuỗi mã hóa rỗng
        $md5HashData = "";
        // sort all the incoming vpc response fields and leave out any with no value
        foreach ($_GET as $key => $value) {
    //        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
    //            $md5HashData .= $value;
    //        }
    //      chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về
            if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                $md5HashData .= $key . "=" . $value . "&";
            }
        }
    //  Xóa dấu & thừa cuối chuỗi dữ liệu
        $md5HashData = rtrim($md5HashData, "&");
    
    //    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $md5HashData ) )) {
    //    Thay hàm tạo chuỗi mã hóa
        if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$SECURE_SECRET)))) {
            // Secure Hash validation succeeded, add a data field to be displayed
            // later.
            $hashValidated = "CORRECT";
        } else {
            // Secure Hash validation failed, add a data field to be displayed
            // later.
            $hashValidated = "INVALID HASH";
        }
    } else {
        // Secure Hash was not validated, add a data field to be displayed later.
        $hashValidated = "INVALID HASH";
    }
    
    // Define Variables
    // ----------------
    // Extract the available receipt fields from the VPC Response
    // If not present then let the value be equal to 'No Value Returned'
    
    // Standard Receipt Data
    $amount = null2unknown($_GET["vpc_Amount"]);
    $locale = null2unknown($_GET["vpc_Locale"]);
    $batchNo = null2unknown($_GET["vpc_BatchNo"]);
    $command = null2unknown($_GET["vpc_Command"]);
    $message = null2unknown($_GET["vpc_Message"]);
    $version = null2unknown($_GET["vpc_Version"]);
    $cardType = null2unknown($_GET["vpc_Card"]);
    $orderInfo = null2unknown($_GET["vpc_OrderInfo"]);
    $receiptNo = null2unknown($_GET["vpc_ReceiptNo"]);
    $merchantID = null2unknown($_GET["vpc_Merchant"]);
    //$authorizeID = null2unknown($_GET["vpc_AuthorizeId"]);
    $merchTxnRef = null2unknown($_GET["vpc_MerchTxnRef"]);
    $transactionNo = null2unknown($_GET["vpc_TransactionNo"]);
    $acqResponseCode = null2unknown($_GET["vpc_AcqResponseCode"]);
    $txnResponseCode = null2unknown($_GET["vpc_TxnResponseCode"]);
    // 3-D Secure Data
    $verType = array_key_exists("vpc_VerType", $_GET) ? $_GET["vpc_VerType"] : "No Value Returned";
    $verStatus = array_key_exists("vpc_VerStatus", $_GET) ? $_GET["vpc_VerStatus"] : "No Value Returned";
    $token = array_key_exists("vpc_VerToken", $_GET) ? $_GET["vpc_VerToken"] : "No Value Returned";
    $verSecurLevel = array_key_exists("vpc_VerSecurityLevel", $_GET) ? $_GET["vpc_VerSecurityLevel"] : "No Value Returned";
    $enrolled = array_key_exists("vpc_3DSenrolled", $_GET) ? $_GET["vpc_3DSenrolled"] : "No Value Returned";
    $xid = array_key_exists("vpc_3DSXID", $_GET) ? $_GET["vpc_3DSXID"] : "No Value Returned";
    $acqECI = array_key_exists("vpc_3DSECI", $_GET) ? $_GET["vpc_3DSECI"] : "No Value Returned";
    $authStatus = array_key_exists("vpc_3DSstatus", $_GET) ? $_GET["vpc_3DSstatus"] : "No Value Returned";
    
    // *******************
    // END OF MAIN PROGRAM
    // *******************
    
    // FINISH TRANSACTION - Process the VPC Response Data
    // =====================================================
    // For the purposes of demonstration, we simply display the Result fields on a
    // web page.
    
    // Show 'Error' in title if an error condition
    $errorTxt = "";
    
    // Show this page as an error page if vpc_TxnResponseCode equals '7'
    if ($txnResponseCode == "7" || $txnResponseCode == "No Value Returned" || $errorExists) {
        $errorTxt = "Error ";
    }
    
    // This is the display title for 'Receipt' page 
    $title = $_GET["Title"];
    
    // The URL link for the receipt to do another transaction.
    // Note: This is ONLY used for this example and is not required for 
    // production code. You would hard code your own URL into your application
    // to allow customers to try another transaction.
    //TK//$againLink = URLDecode($_GET["AgainLink"]);
    
    if($hashValidated=="CORRECT" && $txnResponseCode=="0"){
        $_SESSION['transactionNo'] = $merchTxnRef;
        header("Location: ".urlConfirm);
    }elseif ($hashValidated=="INVALID HASH" && $txnResponseCode=="0"){
        $_SESSION['err_pend'] = $txnResponseCode . "Your payment is pending. Please try again.";
        header("Location: ".urlConfirm);
    }else {
        $_SESSION['err_fail'] = $txnResponseCode . "Your payment is failed. Please check and try again.";
        header("Location: ".urlError);
    }

}
?>