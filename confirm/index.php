<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
if(!$_COOKIE['order_cookies']) {    
    header('Location:http://golf-warehouse.vn');
    die();
}
setcookie('incart', '', time() + 86400, "/");
setcookie('order_cookies','', time() + 86400, "/");
setcookie('order_gwh','', time() + 86400, "/");

include($_SERVER["DOCUMENT_ROOT"] . "/wp/wp-load.php");
include "class.phpmailer.php"; 
include "class.smtp.php"; 
?>
<meta http-equiv="refresh" content="5;url=<?php echo APP_URL; ?>" />
</head>

<body id="category">
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header.php"); ?>
<!--/Header-->
<div class="maxW">
	<ul class="break clearfix">
		<li><a href="<?php echo APP_URL; ?>">Home</a></li>
		<li>Order Success</li>
	</ul>
	<div class="flexBox flexBox--between flexBox--wrap flexBox--nosp">
		<div class="leftCart">
		<?php
		$fullname = $_POST['fullname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$grandTotal = $_SESSION['grandTotal'];
		$order_code = $_COOKIE['order_gwh'];

		$order_post = array(
			'post_title'    => $order_code,
			'post_status'   => 'publish',
			'post_type' => 'getorder'
		);
		$pid = wp_insert_post($order_post); 
		add_post_meta($pid, 'cf_fullname', $fullname);
		add_post_meta($pid, 'cf_email', $email);
		add_post_meta($pid, 'cf_phone', $phone);
		add_post_meta($pid, 'cf_address', $address);
		add_post_meta($pid, 'cf_grand_total', $grandTotal);
		add_post_meta($pid, 'cf_order_status', 'in progress');

		$time_now = time(date('m/d/Y h:i:s a', time()));
		$time_sale = strtotime('31-12-2018');
		if($time_now <= $time_sale) {
			$onsale = 'onsale';
			$count_prommo = 30;
		}
		//LIST PORDUCT
		$f_isset = $_SERVER["DOCUMENT_ROOT"].'/ajax/tmp/'.$_COOKIE['order_gwh'].'.json';
		$order_detail  = json_decode(file_get_contents($f_isset),true);
		$count_product = count($order_detail);
		add_post_meta($pid, 'order_list', $count_product, true);
		for($i=0;$i<=$count_product;$i++) {
		$sub_field_name1 = 'order_list'.'_'.$i.'_'.'cf_sku';
		$sub_field_name2 = 'order_list'.'_'.$i.'_'.'cf_name';
		$sub_field_name3 = 'order_list'.'_'.$i.'_'.'cf_color';
		$sub_field_name4 = 'order_list'.'_'.$i.'_'.'cf_size';
		$sub_field_name5 = 'order_list'.'_'.$i.'_'.'cf_shaft';
		$sub_field_name6 = 'order_list'.'_'.$i.'_'.'cf_flex';
		$sub_field_name7 = 'order_list'.'_'.$i.'_'.'cf_loft';
		$sub_field_name8 = 'order_list'.'_'.$i.'_'.'cf_quantity';

		add_post_meta($pid, $sub_field_name1, $order_detail[$i]['sku'], false);
		add_post_meta($pid, $sub_field_name2, get_the_title($order_detail[$i]['id']), false);
		add_post_meta($pid, $sub_field_name3, '#'.$order_detail[$i]['color'], false);
		add_post_meta($pid, $sub_field_name4, $order_detail[$i]['size'], false);
		add_post_meta($pid, $sub_field_name5, $order_detail[$i]['shaft'], false);
		add_post_meta($pid, $sub_field_name6, $order_detail[$i]['flex'], false);
		add_post_meta($pid, $sub_field_name7, $order_detail[$i]['loft'], false);
		add_post_meta($pid, $sub_field_name8, $order_detail[$i]['quantity'], false);
		}

		unlink($f_isset);

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = "order.gwh@gmail.com";
		$mail->Password = "A@*#029!";
		$from = "order.gwh@gmail.com";

		$to_admin = "khangpham421@gmail.com";
		$to_gw = "warehouse.golf2018@gmail.com";
		$to_customer = $email;

		$name="GOLF-WAREHOUSE ORDER";

		$mail->From = $from;
		$mail->FromName = "GOLF-WAREHOUSE ORDER SYSTEM";
		$mail->AddAddress($to_admin,$name);
		$mail->AddAddress($to_gw,$name);
		$mail->AddAddress($to_customer,$name);

		//$mail->AddReplyTo($from,"khang test");
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject = "MAIL FROM GOLF-WAREHOUSE";
		$mail->CharSet = 'UTF-8';
		$msgBody = "
		<p>Fullname : $fullname</p>
		<p>Email : $email</p>
		<p>Phone : $phone</p>
		<p>Address : $address </p>
		<p>Order Code : $order_code</p>
		<br>
		<table style='border:1px solid #000;border-collapse: collapse;border-spacing: 0;'>
			<tr style='font-weight:bold; padding:5px'>
				<td style='border:1px solid #000;padding:5px;text-align:center'>PRODUCTS</td>
				<td style='border:1px solid #000;padding:5px;text-align:center'>SKU</td>
				<td style='border:1px solid #000;padding:5px;text-align:center'>PRICE</td>
				<td style='border:1px solid #000;padding:5px;text-align:center'>DETAIL</td>
				<td style='border:1px solid #000;padding:5px;text-align:center'>QTY</td>
				<td style='border:1px solid #000;padding:5px;text-align:center'>TOTAL</td>
			</tr>
		";
		for($i=0;$i<=($count_product-1);$i++) {
		$tt = $order_detail[$i]['price'] * $order_detail[$i]['quantity'];
		$msgBody .= "   
			<tr>
				<td style='border:1px solid #000;padding:5px'>".get_the_title($order_detail[$i]['id'])."</td>
				<td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['sku']."</td>
				<td style='border:1px solid #000;padding:5px'>".number_format($order_detail[$i]['price'])."</td>
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
				if(($order_detail[$i]['shaft']!='null')||($order_detail[$i]['shaft']!='undefined')) {
					$msgBody .= "
					<p>SHAFT:".$order_detail[$i]['shaft']."</p>
					";
				}
				if(($order_detail[$i]['flex']!='null')||($order_detail[$i]['flex']!='undefined')) {
					$msgBody .= "
					<p>FLEX:".$order_detail[$i]['flex']."</p>
					";
				}
				if(($order_detail[$i]['loft']!='null')||($order_detail[$i]['loft']!='undefined')) {
					$msgBody .= "
					<p>LOFT:".$order_detail[$i]['loft']."</p>
					";
				}
				$msgBody .= "
				</td>
					<td style='border:1px solid #000;padding:5px'>".$order_detail[$i]['quantity']."</td>    
					<td style='border:1px solid #000;padding:5px'><strong>".number_format($tt)."VND</strong></td>
				</tr>
				";
		}
		if($onsale=='onsale') {
			$msgBody .= " 
			<tr>
				<td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>PROMOTION (GRANG OPENING): <strong>-30%</strong></td>
			</tr>
			";
		}
		$msgBody .= " 
			<tr>
				<td style='border:1px solid #000;padding:5px;text-align:right' colspan='6'>GRAND TOTAL:<strong>".number_format($grandTotal)." VND</strong></td>
			</tr>
		</table>
		";

		$mail->Body = $msgBody;
		$mail->AltBody = "GolfwareHouse successful order";
		//$mail->SMTPDebug = 2;
		include(APP_PATH."libs/head.php"); 

		if(!$mail->Send())
		{
			echo "<h1>" . $mail->ErrorInfo . '</h1>';
		}
		else
		{
		?>
			<p class="successNote">Your order has been placed !</p>
		<?php } ?>	
		</div>
	</div>
</div>	

<!--Footer-->
<?php include(APP_PATH."libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->
</body>
</html>	
