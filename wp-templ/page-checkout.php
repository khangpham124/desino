<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH."libs/header.php"); 
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
							<label>First name<span>(*)</span></label>
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
					<div class="infoVisa">
					<h3 class="h3_checkout">BILLING INFORMATION</h3>
						<p class="inputForm">
							<label>Bank Address</label>
							<input type="text" name="AVS_Street01" value="" id="AVS_City" class="inputText">
						</p>

						<p class="inputForm">
							<label>Bank City</label>
							<input type="text" name="AVS_City" value="" id="AVS_City" class="inputText">
						</p>

						<p class="inputForm">
							<label>Bank Stage</label>
							<input type="text" name="AVS_StateProv" value="" id="AVS_StateProv" class="inputText">
						</p>

						<p class="inputForm">
							<label>Zip/Code</label>
							<input type="text" name="AVS_PostCode" value="" id="AVS_PostCode" class="inputText">
						</p>

						<p class="inputForm">
							<select name="AVS_Country">
								<OPTION VALUE="">--Select Country--</OPTION>
								<OPTION VALUE="AF">Afghanistan</OPTION>
								<OPTION VALUE="AL">Albania</OPTION>
								<OPTION VALUE="DZ">Algeria</OPTION>
								<OPTION VALUE="AS">American Samoa</OPTION>
								<OPTION VALUE="AD">Andorra</OPTION>
								<OPTION VALUE="AO">Angola</OPTION>
								<OPTION VALUE="AI">Anguilla</OPTION>
								<OPTION VALUE="AQ">Antarctica</OPTION>
								<OPTION VALUE="AG">Antigua and Barbuda</OPTION>
								<OPTION VALUE="AR">Argentina</OPTION>
								<OPTION VALUE="AM">Armenia</OPTION>
								<OPTION VALUE="AW">Aruba</OPTION>
								<OPTION VALUE="AU">Australia</OPTION>
								<OPTION VALUE="AT">Austria</OPTION>
								<OPTION VALUE="AZ">Azerbaijan</OPTION>
								<OPTION VALUE="BS">Bahamas</OPTION>
								<OPTION VALUE="BH">Bahrain</OPTION>
								<OPTION VALUE="BD">Bangladesh</OPTION>
								<OPTION VALUE="BB">Barbados</OPTION>
								<OPTION VALUE="BY">Belarus</OPTION>
								<OPTION VALUE="BE">Belgium</OPTION>
								<OPTION VALUE="BZ">Belize</OPTION>
								<OPTION VALUE="BJ">Benin</OPTION>
								<OPTION VALUE="BM">Bermuda</OPTION>
								<OPTION VALUE="BT">Bhutan</OPTION>
								<OPTION VALUE="BO">Bolivia</OPTION>
								<OPTION VALUE="BA">Bosnia and Herzegovina</OPTION>
								<OPTION VALUE="BW">Botswana</OPTION>
								<OPTION VALUE="BV">Bouvet Island</OPTION>
								<OPTION VALUE="BR">Brazil</OPTION>
								<OPTION VALUE="IO">British Indian Ocean Territory</OPTION>
								<OPTION VALUE="VG">British Virgin Islands</OPTION>
								<OPTION VALUE="BN">Brunei</OPTION>
								<OPTION VALUE="BG">Bulgaria</OPTION>
								<OPTION VALUE="BF">Burkina Faso</OPTION>
								<OPTION VALUE="BI">Burundi</OPTION>
								<OPTION VALUE="KH">Cambodia</OPTION>
								<OPTION VALUE="CM">Cameroon</OPTION>
								<OPTION VALUE="CA">Canada</OPTION>
								<OPTION VALUE="CV">Cape Verde</OPTION>
								<OPTION VALUE="KY">Cayman Islands</OPTION>
								<OPTION VALUE="CF">Central African Republic</OPTION>
								<OPTION VALUE="TD">Chad</OPTION>
								<OPTION VALUE="CL">Chile</OPTION>
								<OPTION VALUE="CN">China</OPTION>
								<OPTION VALUE="CX">Christmas Island</OPTION>
								<OPTION VALUE="CC">Cocos Islands</OPTION>
								<OPTION VALUE="CO">Colombia</OPTION>
								<OPTION VALUE="KM">Comoros</OPTION>
								<OPTION VALUE="CG">Congo</OPTION>
								<OPTION VALUE="CK">Cook Islands</OPTION>
								<OPTION VALUE="CR">Costa Rica</OPTION>
								<OPTION VALUE="HR">Croatia</OPTION>
								<OPTION VALUE="CU">Cuba</OPTION>
								<OPTION VALUE="CY">Cyprus</OPTION>
								<OPTION VALUE="CZ">Czech Republic</OPTION>
								<OPTION VALUE="CI">Côte d'Ivoire</OPTION>
								<OPTION VALUE="DK">Denmark</OPTION>
								<OPTION VALUE="DJ">Djibouti</OPTION>
								<OPTION VALUE="DM">Dominica</OPTION>
								<OPTION VALUE="DO">Dominican Republic</OPTION>
								<OPTION VALUE="EC">Ecuador</OPTION>
								<OPTION VALUE="EG">Egypt</OPTION>
								<OPTION VALUE="SV">El Salvador</OPTION>
								<OPTION VALUE="GQ">Equatorial Guinea</OPTION>
								<OPTION VALUE="ER">Eritrea</OPTION>
								<OPTION VALUE="EE">Estonia</OPTION>
								<OPTION VALUE="ET">Ethiopia</OPTION>
								<OPTION VALUE="FK">Falkland Islands</OPTION>
								<OPTION VALUE="FO">Faroe Islands</OPTION>
								<OPTION VALUE="FJ">Fiji</OPTION>
								<OPTION VALUE="FI">Finland</OPTION>
								<OPTION VALUE="FR">France</OPTION>
								<OPTION VALUE="GF">French Guiana</OPTION>
								<OPTION VALUE="PF">French Polynesia</OPTION>
								<OPTION VALUE="TF">French Southern Territories</OPTION>
								<OPTION VALUE="GA">Gabon</OPTION>
								<OPTION VALUE="GM">Gambia</OPTION>
								<OPTION VALUE="GE">Georgia</OPTION>
								<OPTION VALUE="DE">Germany</OPTION>
								<OPTION VALUE="GH">Ghana</OPTION>
								<OPTION VALUE="GI">Gibraltar</OPTION>
								<OPTION VALUE="GR">Greece</OPTION>
								<OPTION VALUE="GL">Greenland</OPTION>
								<OPTION VALUE="GD">Grenada</OPTION>
								<OPTION VALUE="GP">Guadeloupe</OPTION>
								<OPTION VALUE="GU">Guam</OPTION>
								<OPTION VALUE="GT">Guatemala</OPTION>
								<OPTION VALUE="GN">Guinea</OPTION>
								<OPTION VALUE="GW">Guinea-Bissau</OPTION>
								<OPTION VALUE="GY">Guyana</OPTION>
								<OPTION VALUE="HT">Haiti</OPTION>
								<OPTION VALUE="HM">Heard Island And McDonald Islands</OPTION>
								<OPTION VALUE="HN">Honduras</OPTION>
								<OPTION VALUE="HK">Hong Kong</OPTION>
								<OPTION VALUE="HU">Hungary</OPTION>
								<OPTION VALUE="IS">Iceland</OPTION>
								<OPTION VALUE="IN">India</OPTION>
								<OPTION VALUE="ID">Indonesia</OPTION>
								<OPTION VALUE="IR">Iran</OPTION>
								<OPTION VALUE="IQ">Iraq</OPTION>
								<OPTION VALUE="IE">Ireland</OPTION>
								<OPTION VALUE="IL">Israel</OPTION>
								<OPTION VALUE="IT">Italy</OPTION>
								<OPTION VALUE="JM">Jamaica</OPTION>
								<OPTION VALUE="JP">Japan</OPTION>
								<OPTION VALUE="JO">Jordan</OPTION>
								<OPTION VALUE="KZ">Kazakhstan</OPTION>
								<OPTION VALUE="KE">Kenya</OPTION>
								<OPTION VALUE="KI">Kiribati</OPTION>
								<OPTION VALUE="KW">Kuwait</OPTION>
								<OPTION VALUE="KG">Kyrgyzstan</OPTION>
								<OPTION VALUE="LA">Laos</OPTION>
								<OPTION VALUE="LV">Latvia</OPTION>
								<OPTION VALUE="LB">Lebanon</OPTION>
								<OPTION VALUE="LS">Lesotho</OPTION>
								<OPTION VALUE="LR">Liberia</OPTION>
								<OPTION VALUE="LY">Libya</OPTION>
								<OPTION VALUE="LI">Liechtenstein</OPTION>
								<OPTION VALUE="LT">Lithuania</OPTION>
								<OPTION VALUE="LU">Luxembourg</OPTION>
								<OPTION VALUE="MO">Macao</OPTION>
								<OPTION VALUE="MK">Macedonia</OPTION>
								<OPTION VALUE="MG">Madagascar</OPTION>
								<OPTION VALUE="MW">Malawi</OPTION>
								<OPTION VALUE="MY">Malaysia</OPTION>
								<OPTION VALUE="MV">Maldives</OPTION>
								<OPTION VALUE="ML">Mali</OPTION>
								<OPTION VALUE="MT">Malta</OPTION>
								<OPTION VALUE="MH">Marshall Islands</OPTION>
								<OPTION VALUE="MQ">Martinique</OPTION>
								<OPTION VALUE="MR">Mauritania</OPTION>
								<OPTION VALUE="MU">Mauritius</OPTION>
								<OPTION VALUE="YT">Mayotte</OPTION>
								<OPTION VALUE="MX">Mexico</OPTION>
								<OPTION VALUE="FM">Micronesia</OPTION>
								<OPTION VALUE="MD">Moldova</OPTION>
								<OPTION VALUE="MC">Monaco</OPTION>
								<OPTION VALUE="MN">Mongolia</OPTION>
								<OPTION VALUE="MS">Montserrat</OPTION>
								<OPTION VALUE="MA">Morocco</OPTION>
								<OPTION VALUE="MZ">Mozambique</OPTION>
								<OPTION VALUE="MM">Myanmar</OPTION>
								<OPTION VALUE="NA">Namibia</OPTION>
								<OPTION VALUE="NR">Nauru</OPTION>
								<OPTION VALUE="NP">Nepal</OPTION>
								<OPTION VALUE="NL">Netherlands</OPTION>
								<OPTION VALUE="AN">Netherlands Antilles</OPTION>
								<OPTION VALUE="NC">New Caledonia</OPTION>
								<OPTION VALUE="NZ">New Zealand</OPTION>
								<OPTION VALUE="NI">Nicaragua</OPTION>
								<OPTION VALUE="NE">Niger</OPTION>
								<OPTION VALUE="NG">Nigeria</OPTION>
								<OPTION VALUE="NU">Niue</OPTION>
								<OPTION VALUE="NF">Norfolk Island</OPTION>
								<OPTION VALUE="KP">North Korea</OPTION>
								<OPTION VALUE="MP">Northern Mariana Islands</OPTION>
								<OPTION VALUE="NO">Norway</OPTION>
								<OPTION VALUE="OM">Oman</OPTION>
								<OPTION VALUE="PK">Pakistan</OPTION>
								<OPTION VALUE="PW">Palau</OPTION>
								<OPTION VALUE="PS">Palestine</OPTION>
								<OPTION VALUE="PA">Panama</OPTION>
								<OPTION VALUE="PG">Papua New Guinea</OPTION>
								<OPTION VALUE="PY">Paraguay</OPTION>
								<OPTION VALUE="PE">Peru</OPTION>
								<OPTION VALUE="PH">Philippines</OPTION>
								<OPTION VALUE="PN">Pitcairn</OPTION>
								<OPTION VALUE="PL">Poland</OPTION>
								<OPTION VALUE="PT">Portugal</OPTION>
								<OPTION VALUE="PR">Puerto Rico</OPTION>
								<OPTION VALUE="QA">Qatar</OPTION>
								<OPTION VALUE="RE">Reunion</OPTION>
								<OPTION VALUE="RO">Romania</OPTION>
								<OPTION VALUE="RU">Russia</OPTION>
								<OPTION VALUE="RW">Rwanda</OPTION>
								<OPTION VALUE="SH">Saint Helena</OPTION>
								<OPTION VALUE="KN">Saint Kitts And Nevis</OPTION>
								<OPTION VALUE="LC">Saint Lucia</OPTION>
								<OPTION VALUE="PM">Saint Pierre And Miquelon</OPTION>
								<OPTION VALUE="VC">Saint Vincent And The Grenadines</OPTION>
								<OPTION VALUE="WS">Samoa</OPTION>
								<OPTION VALUE="SM">San Marino</OPTION>
								<OPTION VALUE="ST">Sao Tome And Principe</OPTION>
								<OPTION VALUE="SA">Saudi Arabia</OPTION>
								<OPTION VALUE="SN">Senegal</OPTION>
								<OPTION VALUE="CS">Serbia and Montenegro</OPTION>
								<OPTION VALUE="SC">Seychelles</OPTION>
								<OPTION VALUE="SL">Sierra Leone</OPTION>
								<OPTION VALUE="SG">Singapore</OPTION>
								<OPTION VALUE="SK">Slovakia</OPTION>
								<OPTION VALUE="SI">Slovenia</OPTION>
								<OPTION VALUE="SB">Solomon Islands</OPTION>
								<OPTION VALUE="SO">Somalia</OPTION>
								<OPTION VALUE="ZA">South Africa</OPTION>
								<OPTION VALUE="GS">South Georgia And The South Sandwich Islands</OPTION>
								<OPTION VALUE="KR">South Korea</OPTION>
								<OPTION VALUE="ES">Spain</OPTION>
								<OPTION VALUE="LK">Sri Lanka</OPTION>
								<OPTION VALUE="SD">Sudan</OPTION>
								<OPTION VALUE="SR">Suriname</OPTION>
								<OPTION VALUE="SJ">Svalbard And Jan Mayen</OPTION>
								<OPTION VALUE="SZ">Swaziland</OPTION>
								<OPTION VALUE="SE">Sweden</OPTION>
								<OPTION VALUE="CH">Switzerland</OPTION>
								<OPTION VALUE="SY">Syria</OPTION>
								<OPTION VALUE="TW">Taiwan</OPTION>
								<OPTION VALUE="TJ">Tajikistan</OPTION>
								<OPTION VALUE="TZ">Tanzania</OPTION>
								<OPTION VALUE="TH">Thailand</OPTION>
								<OPTION VALUE="CD">The Democratic Republic Of Congo</OPTION>
								<OPTION VALUE="TL">Timor-Leste</OPTION>
								<OPTION VALUE="TG">Togo</OPTION>
								<OPTION VALUE="TK">Tokelau</OPTION>
								<OPTION VALUE="TO">Tonga</OPTION>
								<OPTION VALUE="TT">Trinidad and Tobago</OPTION>
								<OPTION VALUE="TN">Tunisia</OPTION>
								<OPTION VALUE="TR">Turkey</OPTION>
								<OPTION VALUE="TM">Turkmenistan</OPTION>
								<OPTION VALUE="TC">Turks And Caicos Islands</OPTION>
								<OPTION VALUE="TV">Tuvalu</OPTION>
								<OPTION VALUE="VI">U.S. Virgin Islands</OPTION>
								<OPTION VALUE="UG">Uganda</OPTION>
								<OPTION VALUE="UA">Ukraine</OPTION>
								<OPTION VALUE="AE">United Arab Emirates</OPTION>
								<OPTION VALUE="GB">United Kingdom</OPTION>
								<OPTION VALUE="US">United States</OPTION>
								<OPTION VALUE="UM">United States Minor Outlying Islands</OPTION>
								<OPTION VALUE="UY">Uruguay</OPTION>
								<OPTION VALUE="UZ">Uzbekistan</OPTION>
								<OPTION VALUE="VU">Vanuatu</OPTION>
								<OPTION VALUE="VA">Vatican</OPTION>
								<OPTION VALUE="VE">Venezuela</OPTION>
								<OPTION VALUE="VN">Vietnam</OPTION>
								<OPTION VALUE="WF">Wallis And Futuna</OPTION>
								<OPTION VALUE="EH">Western Sahara</OPTION>
								<OPTION VALUE="YE">Yemen</OPTION>
								<OPTION VALUE="ZM">Zambia</OPTION>
								<OPTION VALUE="ZW">Zimbabwe</OPTION>
								<OPTION VALUE="AX">Åland Islands</OPTION>
							</select>
						</p>
					</div>
					<h3 class="h3_checkout">NOTE</h3>
					<textarea id="note_order" name="comt_order" placeholder="Note"></textarea>	
				</div>
				<div class="leftCheck">
					<h3 class="h3_checkout">PAYMENT METHOD</h3>
					<div class="chkradio" id="radPay">
						<p class="inputRadio">
							<input type="radio" id="pay_atm" name="payment" value="atm">
							<label for="pay_atm">Secure Online Payment with Domestic ATM Cards</label>
						</p>
						<div class="atmCard boxLogoBank">
							<div class="flexBox logoBank  flexBox--wrap logoBank--4">
								<?php for($i=1;$i<28;$i++) { ?>
									<p class="bdLogo"><img src="<?php echo APP_URL; ?>img/bank/logo<?php echo $i; ?>.jpg" alt=""></p>
								<?php } ?>
							</div>	
						</div>
						<p class="inputRadio"><input type="radio" checked id="pay_visa" name="payment" value="creditcard"><label for="pay_visa" >Secure Online Payment with International Cards (Visa, Master, JCB, American Express)</label></p>
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
					<p class="messErr"><?php echo $_SESSION['err_fail']; ?></p>
					<?php } ?>
				</div>
			</div>
			<div class="boxBtn">
				<a href="<?php echo APP_URL; ?>shop/" class="btnPage"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;CONTINUE SHOPPING</a>
				<input type="hidden" value="<?php echo $_COOKIE['order_des']; ?>" name="order_des" >
				<input type="hidden" value="<?php echo virtualPaymentClientURL_visa; ?>" id="virtualPaymentClientURL" name="virtualPaymentClientURL" >
				<input type="hidden" name="Title" value="VPC 3-Party"/>
				<button class="btnPage">PAY NOW<i class="fa fa-credit-card" aria-hidden="true"></i></button>
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
			fullname: "chkrequired",
			address: "chkrequired",
			mail: "chkrequired chkemail",
			phone: "chkrequired chktel",
	    },
	    stepValidation: true,
	    scrollToErr: true,
	    errHoverHide: true
	  });
	$('.visaCard').show();
	$('.infoVisa').show();
	$('input[name="payment"]').on('change', function() {
	   var pay = $(this).val();
	   if(pay=='atm') {
			$('.visaCard').slideUp(200);
			$('.atmCard').slideDown(200);
		   $('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL; ?>');
		   $('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/local/do.php');
		   $('.infoVisa').slideUp(200);
		   $('#AVS_Country').removeClass('chkselect errPosRight err');
			$('#AVS_City').removeClass('chkrequired errPosRight');
			$('#AVS_StateProv').removeClass('chkrequired errPosRight');
			$('#AVS_PostCode').removeClass('chkrequired errPosRight');
			$('#AVS_Street01').removeClass('chkrequired errPosRight');
	   } else {
			$('.visaCard').slideDown(200);
			$('.atmCard').slideUp(200);
			$('#virtualPaymentClientURL').val('<?php echo virtualPaymentClientURL_visa; ?>');
			$('#formCheckout').attr('action','<?php echo APP_URL; ?>payment/visa/do.php');
			$('.infoVisa').slideDown(200);
			$('#AVS_Country').addClass('chkselect errPosRight err');
			$('#AVS_City').addClass('chkrequired errPosRight');
			$('#AVS_StateProv').addClass('chkrequired errPosRight');
			$('#AVS_PostCode').addClass('chkrequired errPosRight');
			$('#AVS_Street01').addClass('chkrequired errPosRight');
	   }
    });
});
</script>

</body>
</html>	