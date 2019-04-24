<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php");
if(!$_COOKIE['order_des']) {    
    header('Location:'.APP_URL);
    die();
}
setcookie('incart','', time() + 86400, "/");
setcookie('order_cookies','', time() + 86400, "/");
setcookie('order_des','', time() + 86400, "/");
include(TEMPLATEPATH."/mailer/class.phpmailer.php");
include(TEMPLATEPATH."/mailer/class.smtp.php");
?>
<meta http-equiv="REFRESH" content="5; url=<?php echo APP_URL; ?>">
</head>
<body id="store" class="subPage">
<?php include(TEMPLATEPATH."/libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(TEMPLATEPATH."/libs/sidebar.php"); ?>
	<div id="mainContent" class="clearfix">
        <h2 class="h3_page">Thank you for your purchase , <?php echo $_SESSION['fullname']; ?>!</h2>
        <?php
            $reg_fullname = $_SESSION['fullname'];
            $reg_address = $_SESSION['address'];
            $reg_phone = $_SESSION['mobile'];
            $reg_mail = $_SESSION['mail'];
            $reg_order = $_SESSION['order_des'];
            $cf_total = $_SESSION["total"];
            $cf_note = $_SESSION['note'];
            $idcustomer = $_SESSION['idcustomer'];
            $method = $_SESSION['payment'];

            $transactionNo = $_SESSION['transactionNo'];

            $f_isset = $_SERVER['DOCUMENT_ROOT'].'/ajax/tmp/'.$reg_order.'.json';
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
            add_post_meta($pid, 'cf_note', $cf_note);
            add_post_meta($pid, 'idcustomer', $idcustomer);
            add_post_meta($pid, 'transaction_number', $transactionNo);
            add_post_meta($pid, 'method', $method);
            add_post_meta($pid, 'cf_order_status', 'in progress');

            
            $order_detail  = json_decode(file_get_contents($f_isset),true);
            $count_product = count($order_detail);
        
            $listOrder = array();
            for($i=0; $i<$count_product;$i++)
            {
                $listOrder[] = array(
                    'cf_name' => $order_detail[$i]['name'],
                    'cf_quantity' => $order_detail[$i]['quantity'],
                    'cf_color' => '#'.$order_detail[$i]['color'],
                    'cf_id' => $order_detail[$i]['id'],
                );
            }
            update_field('order_list', $listOrder, $pid);
        //}
        

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Username = "order.desino@gmail.com";
            $mail->Password = "P@@55w0rd123456";
            $from = "order.desino@gmail.com";

            $to_admin = "khangpham421@gmail.com";
            $to_customer = $reg_mail;

            $name="Desino";

            $mail->From = $from;
            $mail->FromName = "DESINO Premium Leather Handbags and Accessories";
            $mail->AddAddress($to_admin,$name);
            $mail->AddAddress($to_customer,$name);

            //$mail->AddReplyTo($from,"khang test");
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = "Mail from Premium Leather Handbags and Accessories";
            $mail->CharSet = 'UTF-8';
            $msgBody = "
            <p>Fullname : $reg_fullname</p>
            <p>Email : $reg_mail</p>
            <p>Phone : $reg_phone</p>
            <p>Address : $reg_address </p>
            <p>Order Code : $reg_order</p>
            <br>
            <table style='border:1px solid #000;border-collapse: collapse;border-spacing: 0;'>
                <tr style='font-weight:bold; padding:5px'>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>PRODUCTS</td>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>PRICE</td>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>DETAIL</td>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>QTY</td>
                    <td style='border:1px solid #000;padding:5px;text-align:center'>TOTAL</td>
                </tr>
            ";
            for($i=0;$i<=($count_product-1);$i++) {
            $promo = get_field('special-offer',$order_detail[$i]['id']);
            if($promo!=0) {
                $price_real = get_field('price',$order_detail[$i]['id']);
                $price_dis = ($price_real * $promo) / 100;
                $price = $price_real - $price_dis;
            } else {
                $price = get_field('price',$order_detail[$i]['id']);
            }
            $tt = $price * $order_detail[$i]['quantity'];
            $msgBody .= "   
                <tr>
                    <td style='border:1px solid #000;padding:5px'>".get_the_title($order_detail[$i]['id'])."</td>
                    <td style='border:1px solid #000;padding:5px'>".number_format($price)."</td>
                    <td style='border:1px solid #000;padding:5px'>"
                    ;	
                    if($order_detail[$i]['size']!='') { 
                        $msgBody .= "
                        <p>SIZE:".$order_detail[$i]['size']."</p>
                        ";
                    }
                    if($order_detail[$i]['color']!='') {
                        $msgBody .= "
                        <p style='border:1px solid #000;width:20px;height:20px;background:#".$order_detail[$i]['color']."'></p>
                    ";
                    }
                    $msgBody .= "
                    </td>
                        <td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['quantity']."</td>    
                        <td style='border:1px solid #000;padding:5px'><strong>".number_format($tt)."VND</strong></td>
                    </tr>
                    ";
            }
            $msgBody .= " 
                <tr>
                    <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>Paid via:<strong>".$method."</strong></td>
                </tr>
                <tr>
                    <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>Transaction Number:<strong>".$transactionNo."</strong></td>
                </tr>
                <tr>
                    <td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>GRAND TOTAL:<strong>".number_format($cf_total)." VND</strong></td>
                </tr>
            </table>
            ";

            $mail->Body = $msgBody;
            $mail->AltBody = "Desino successful order";
            //$mail->SMTPDebug = 2;
            include(APP_PATH."libs/head.php"); 

            if(!$mail->Send())
            {
                echo "<h1>" . $mail->ErrorInfo . '</h1>';
            }
            else
            {
                echo '<p>
                You will receive an order confirmation with the details of your order in your email.<br>
                This page auto redirect to homepage in 5s.
                </p>';
            }
            // AFTER SUBMIT
            unlink($f_isset);
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
	

</body>
</html>	