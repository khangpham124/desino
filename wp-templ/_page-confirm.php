<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php");
// if(!$_COOKIE['order_des']) {    
//     header('Location:'.APP_URL);
//     die();
// }
// require(APP_PATH."mailer/jphpmailer.php");

?>
</head>

<body id="store" class="subPage">
<?php include(TEMPLATEPATH."/libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php //include(APP_PATH."libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(TEMPLATEPATH."/libs/sidebar.php"); ?>
	<div id="mainContent" class="clearfix">
    <h2 class="h2_site">Success order</h2>
    <?php
        $action = htmlspecialchars($_POST['action']);
        $reg_fullname = htmlspecialchars($_POST['fullname']);
        $reg_address = htmlspecialchars($_POST['address']);
        $reg_phone = htmlspecialchars($_POST['phone']);
        $reg_mail = htmlspecialchars($_POST['mail']);
        $reg_order = htmlspecialchars($_POST['order_des']);

        // if($_SESSION['paymemnt_status']) {
        //     $paidstt = $_SESSION['paymemnt_status'];
        // } else {
        //     $paidstt = '';
        // }
        // if($_SESSION['transactionNo']) {
        //     $pay_info = $_SESSION['transactionNo'];
        // } else {
        //     $pay_info = '';
        // }
        $f_isset = $_SERVER['DOCUMENT_ROOT'].'/ajax/tmp/'.$reg_order.'.json';
        // var_dump($f_isset);
        $order_post = array(
        'post_title'    => $reg_order,
        'post_status'   => 'publish',
        'post_type' => 'getorder'
        );


        $pid = wp_insert_post($order_post); 
        add_post_meta($pid, 'cf_fullname', $reg_fullname);
        add_post_meta($pid, 'cf_address', $reg_address);
        add_post_meta($pid, 'cf_phone', $reg_phone);
        add_post_meta($pid, 'cf_mail', $reg_mail);
        add_post_meta($pid, 'cf_total', $cf_total);
        add_post_meta($pid, 'cf_order_status', 'in progress');

        
        $order_detail  = json_decode(file_get_contents($f_isset),true);
        $count_product = count($order_detail);


        add_post_meta($pid, 'order_list', $count_product, true);

        for($i=0;$i<=$count_product;$i++) {
        $sub_field_name1 = 'order_list'.'_'.$i.'_'.'cf_name';
        $sub_field_name2 = 'order_list'.'_'.$i.'_'.'cf_quantity';
        $sub_field_name3 = 'order_list'.'_'.$i.'_'.'cf_color';

        add_post_meta($pid, $sub_field_name1, $order_detail[$i]['name'], false);
        add_post_meta($pid, $sub_field_name2, $order_detail[$i]['quantity'], false);
        add_post_meta($pid, $sub_field_name3, '#'.$order_detail[$i]['color'], false);

        }
        // AFTER SUBMIT
        unlink($f_isset);

        $aMailto = array("khangpham421@gmail.com");
        $from = "khangpham421@gmail.com";
        
        mb_internal_encoding("UTF-8");

        $subject = "DELIVERY SUMMARY FROM HEART OF DARKNESS";
        $msgBody = "
        <p>Fullname : $fullname</p>
        <p>Phone : $phone</p>
        <p>Address : $address - $city</p>
        <p>Order Code : $reg_order</p>
        ";
        if($cmt_order != '') {
            $msgBody .= "
            <div>Note : $cmt_order</div>
            ";
        }
        if($paidstt == 'Paid') {
        $msgBody .= "
        <p>Paymemnt Status : <strong>$paidstt via $payment</strong></p>
        ";
        }
        $msgBody .= "
        <br>
        <table style='border:1px solid #000;border-collapse: collapse;border-spacing: 0;'>
            <tr style='font-weight:bold; padding:5px'>
                <td style='border:1px solid #000;padding:5px;text-align:center'>PRODUCTS</td>
                <td style='border:1px solid #000;padding:5px;text-align:center'>PRICE</td>
                <td style='border:1px solid #000;padding:5px;text-align:center'>QTY</td>
                <td style='border:1px solid #000;padding:5px;text-align:center'>NOTE</td>
                <td style='border:1px solid #000;padding:5px;text-align:center'>TOTAL</td>
            </tr>
       ";
       for($i=0;$i<=($count_product-1);$i++) {
        $tt = $order_detail[$i]['price'] * $order_detail[$i]['quantity'];
        $msgBody .= "   
            <tr>
                <td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['name']."</td>
                <td style='border:1px solid #000;padding:5px'>".number_format($order_detail[$i]['price'])."</td>
                <td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['quantity']."</td> 
                <td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['note']."</td>
                <td style='border:1px solid #000;padding:5px'>".number_format($tt)."VND</td>
            </tr>
        ";
        }
        $msgBody .= " 
            <tr>
                <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>VAT(10%):".number_format(($grandTotal_novat * 10) / 100)." VND</td>
            </tr>
            <tr>
                <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>Shipping Fee:".number_format($shipcost)." VND</td>
            </tr>
            <tr>
                <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>".number_format($grandTotal)." VND</td>
            </tr>
        </table>
        ";

        $subject1 = "CONFIRM DELIVERY SUMMARY FROM HEART OF DARKNESS";
        $msgBody_customer = "
        <p>Fullname : $fullname</p>
        <p>Phone : $phone</p>
        <p>Address : $address - $city</p>
        <p>Order Code : $order_code</p>
        <br>
        <table style='border:1px solid #000;border-collapse: collapse;border-spacing: 0;'>
            <tr style='font-weight:bold; padding:5px'>
                <td style='border:1px solid #000;padding:5px;text-align:center'>PRODUCTS</td>
                <td style='border:1px solid #000;padding:5px;text-align:center'>PRICE</td>
                <td style='border:1px solid #000;padding:5px;text-align:center'>QTY</td>
                <td style='border:1px solid #000;padding:5px;text-align:center'>NOTE</td>
                <td style='border:1px solid #000;padding:5px;text-align:center'>TOTAL</td>
            </tr>
       ";
       for($i=0;$i<=($count_product-1);$i++) {
        $tt = $order_detail[$i]['price'] * $order_detail[$i]['quantity'];
        $msgBody_customer .= "   
            <tr>
                <td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['name']."</td>
                <td style='border:1px solid #000;padding:5px'>".number_format($order_detail[$i]['price'])."</td>
                <td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['quantity']."</td>
                <td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['note']."</td>
                <td style='border:1px solid #000;padding:5px'>".number_format($tt)."</td>
            </tr>
        ";
        }
        $msgBody_customer .= " 
            <tr>
            <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>VAT(10%):".number_format(($grandTotal_novat * 10) / 100)." VND</td>
            </tr>
            <tr>
                <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>Shipping Fee:".number_format($shipcost)." VND</td>
            </tr>
            <tr>
                <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>".number_format($grandTotal)." VND</td>
            </tr>    
        </table>

        <p>---------------------------------------------------------------</p>
        <p>
        <img src='https://www.desino.vn/common/img/header/logo.png'><br>
        <p>---------------------------------------------------------------</p>
        ";

        $fromname = "DESINO DELIVERY SYSTEM";

        //Mail to Customer
        $email1 = new JPHPmailer();
        $email1->addTo($reg_mail);
        $email1->setFrom($from,$fromname);
        $email1->setSubject($subject1);
        $email1->setBody($msgBody_customer);
        $email1->CharSet = 'UTF-8';
        if($email1->Send()) {
                
        };

        
        //Mail to Admin
        $email = new JPHPmailer();
        for($i = 0; $i < count($aMailto); $i++)
        {
            $email->addTo($aMailto[$i]);
        }
        $email->setFrom($reg_mail, 'DESINO Delivery System');
        $email->setSubject($subject);
        $email->setBody($msgBody);
        $email->CharSet = 'UTF-8';
        if($email->Send()) {
            echo "
            <div class='boxThx'>
                <p class='warningTxt'><i class='fa fa-check-circle'></i>Your order has been placed</p>
            </div>
            ";
        }
        
    setcookie('incart', null, -1, '/');
    setcookie('order_cookies', null, -1, '/');
    setcookie('order_des', null, -1, '/');
    ?>
	</div>
      
<!-- container -->

<!--Footer-->
<?php include(TEMPLATEPATH."/libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->
<script type="text/javascript"src="http://202.9.84.88/documents/payment/logoscript.jsp?logos=v,m,a,j,u,at&lang=en"></script>
	

</body>
</html>	