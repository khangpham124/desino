<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php");
setcookie('incart','', time() + 86400, "/");
setcookie('order_cookies','', time() + 86400, "/");
setcookie('order_des','', time() + 86400, "/");
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
        <p>
        You will receive an order confirmation with the details of your order in your email.<br>
        This page auto redirect to homepage in 5s.
        </p>
        <?php
            $reg_fullname = $_SESSION['fullname'];
            $reg_address = $_SESSION['address'];
            $reg_phone = $_SESSION['phone'];
            $reg_mail = $_SESSION['mail'];
            $reg_order = $_SESSION['order_des'];
            $cf_total = $_SESSION['amount'];
            $cf_note = $_SESSION['note'];
            $idcustomer = $_SESSION['idcustomer'];
            echo $transactionNo = $_SESSION['transactionNo'];

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
            add_post_meta($pid, 'transactionNo', $transactionNo);
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
        //}
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