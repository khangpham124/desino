<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php"); 
if(!$_COOKIE['order_des']) {    
    header('Location:'.APP_URL);
    die();
}
?>
<link rel="stylesheet" href="<?php echo APP_URL; ?>checkform/exvalidation.css" media="all">
</head>

<body id="men" class="subPage">
<?php include(TEMPLATEPATH."/libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(TEMPLATEPATH."/libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(TEMPLATEPATH."/libs/sidebar.php"); ?>
	<div id="mainContent">
		<h3 class="h3_page">Checkout</h3>
		<div class="boxTotal">
			<h3 class="h3_checkout">SUMMARY<em> in your cart (<span class="numbCart"></span>)</em></h3>
			<table class="tblCheckout">
				<?php
					$f_isset = $_SERVER['DOCUMENT_ROOT'].'/ajax/tmp/'.$_COOKIE['order_des'].'.json';
					$curr_cart  = json_decode(file_get_contents($f_isset));
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
				?>
				<tr>
					<th><?php echo $mydata->name; ?></th>
					<td><?php echo number_format($price_no); ?>VND x <?php echo $mydata->quantity; ?></td>
					<td><?php echo number_format($price_no * $mydata->quantity); ?>VND</td>
				</tr>
					<?php } ?>
				<tr class="totalCost">
					<th  colspan="2">TOTAL</th>
					<td><?php echo number_format(array_sum($arr_price)); 
					$_SESSION["total"] = array_sum($arr_price);
					
					?>VND</td>
				</tr>
			</table>
		</div>	
		<form action="<?php echo APP_URL; ?>payment/visa/do.php" class="formChk" method="post" id="formCheckout">		
			<div class="flexBox flexBox--between checkOutcontent">
				
				<div class="leftCheck">
					<h3 class="h3_checkout">SHIPPING INFORMATION</h3>
					
						<p class="inputForm">
							<label>Full name<span>(*)</span></label>
							<input type="text" name="fullname_chk" value="<?php echo $_SESSION['fullname']; ?>" id="fullname_chk" class="inputText">
						</p>
						<p class="inputForm">
							<label>Address<span>(*)</span></label>
							<input type="text" name="address_chk" value="<?php echo $_SESSION['address']; ?>" id="address_chk" class="inputText">
						</p>
						<p class="inputForm">
							<label>Phone<span>(*)</span></label>
							<input type="text" name="mobile_chk" value="<?php echo $_SESSION['mobile']; ?>" id="mobile_chk"  class="inputText">
						</p>
						<p class="inputForm">
							<label>E-mail<span>(*)</span></label>
							<input type="text" name="mail_chk" value="<?php echo $_SESSION['login']; ?>" id="mail_chk" class="inputText">
						</p>
					<h3 class="h3_checkout">NOTE</h3>
					<textarea id="note_order" name="comt_order" placeholder="Note"></textarea>	
				</div>
				<div class="leftCheck">
					<h3 class="h3_checkout">PAYMENT METHOD</h3>
					<div class="chkradio" id="radPay">
						<p class="inputRadio">
						<input type="radio" <?php if($_SESSION['payment']=='atm') { ?>checked<?php } ?> id="pay_atm" name="payment" value="atm">
							<label for="pay_atm">Secure Online Payment with Domestic ATM Cards</label>
						</p>
						<div class="atmCard boxLogoBank">
							<div class="flexBox logoBank  flexBox--wrap logoBank--4">
								<?php for($i=1;$i<28;$i++) { ?>
									<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/logo<?php echo $i; ?>.jpg" alt=""></p>
								<?php } ?>
							</div>	
						</div>
						<p class="inputRadio"><input type="radio" <?php if(($_SESSION['payment']=='creditcard')||($_SESSION['payment']=='')) { ?>checked<?php } ?>  id="pay_visa" name="payment" value="creditcard"><label for="pay_visa" >Secure Online Payment with Visa, Master, JCB, American Express Cards</label></p>
						<div class="visaCard boxLogoBank">
							<div class="flexBox logoBank flexBox--start">
								<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/visa.png" alt=""></p>
								<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/master.png" alt=""></p>
								<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/jcb.png" alt=""></p>
								<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/amex.png" alt=""></p>
							</div>
						</div>
					</div>
					
					<?php if($_SESSION['err_fail']!="") { ?>
						<?php if($lang_web=='en') { ?>
							<label class="messErr">Failured</label>
						<?php } else { ?>
							<label class="messErr">Giao dịch thất bại</label>
						<?php } ?>
						<p class="messErr_text"><?php echo $_SESSION['err_fail']; ?></p>
					<?php } ?>
				</div>
			</div>
			<div class="boxBtn">
				<a href="<?php echo APP_URL; ?>shop/" class="btnPage"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;CONTINUE SHOPPING</a>
				<input type="hidden" value="<?php echo $_COOKIE['order_des']; ?>" name="order_des" >
				<input type="hidden" value="<?php echo virtualPaymentClientURL_visa; ?>" id="virtualPaymentClientURL" name="virtualPaymentClientURL" >
				<input type="hidden" name="Title" value="VPC 3-Party"/>
				<input type="submit" class="btnPage" value="PAY NOW">
			</div>
		</form>
			
		</div>  
</div>
<!-- container -->


<!--Footer-->
<?php include(TEMPLATEPATH."/libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->

<script type="text/javascript">
$(function(){
	$('.lstProdMen li').biggerlink();
});
</script>

<script type="text/javascript" src="<?php echo APP_URL; ?>checkform/exvalidation.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>checkform/exchecker-ja.js"></script>
<script type="text/javascript">
$(function(){
	  $("#formCheckout").exValidation({
	    rules: {
			fullname_chk: "chkrequired",
			address_chk: "chkrequired",
			mail_chk: "chkrequired chkemail",
			mobile_chk: "chkrequired chktel",
	    },
	    stepValidation: true,
	    scrollToErr: true,
	    errHoverHide: true
	  });
	$('.visaCard').show();


	if($("#pay_atm").prop("checked")) {
		$('.visaCard').slideUp(200);
		$('.atmCard').slideDown(200);
		$('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL; ?>');
		$('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/local/do.php');
		$('.infoVisa').slideUp(200);
	}

	if($("#pay_visa").prop("checked")) {
		$('.visaCard').slideDown(200);
		$('.atmCard').slideUp(200);
		$('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL_visa; ?>');
		$('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/visa/do.php');
		$('.infoVisa').slideDown(200);
	}

	$('input[name="payment"]').on('change', function() {
	   var pay = $(this).val();
	   if(pay=='atm') {
			$('.visaCard').slideUp(200);
			$('.atmCard').slideDown(200);
		   $('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL; ?>');
		   $('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/local/do.php');
		   $('.infoVisa').slideUp(200);
	   } else {
			$('.visaCard').slideDown(200);
			$('.atmCard').slideUp(200);
			$('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL_visa; ?>');
			$('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/visa/do.php');
			$('.infoVisa').slideDown(200);
	   }
    });
});
</script>

</body>
</html>	