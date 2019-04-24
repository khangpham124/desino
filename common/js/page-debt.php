<?php /* Template Name: DEBT */ ?>
<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
if(!$_COOKIE['login_cookies']) {    
	header('Location:'.APP_URL.'login');
}
if(($_COOKIE['role_cookies']=='doctor')) {
    header('Location:'.APP_URL);
}

include(APP_PATH."libs/head.php"); 
?>
</head>

<body id="surgery">

<div class="flexBox flexBox--between flexBox--wrap">
<?php include(APP_PATH."libs/sidebar.php"); ?>
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header.php"); ?>
<!--/Header-->

<div class="textBox">
<div class="blockPage blockPage--full maxW">
        <h2 class="h2_page">Danh sách khách hàng còn nợ</h2>
            <table class="tblPage">
            <thead>
                <tr>
                    <td>Trạng thái</td>
                    <td>Ca</td>
                    <td>Họ tên khách hàng</td>
                    <td>Số điện thoại</td>
                    <td>Chi tiết</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $wp_query = new WP_Query();
                    $param = array (
                        'posts_per_page' => '-1',
                        'post_type' => 'surgery',
                        'post_status' => 'publish',
                        'order' => 'DESC',
                        'meta_query'	=> array(
                            'relation'		=> 'AND',
                            array(
                                'key' => 'payment_status',
                                'value' => 'Nợ',
                                'compare' => 'LIKE'
                            ),
                        )
                        );
                        $wp_query->query($param);
                    if($wp_query->have_posts()):while($wp_query->have_posts()) : $wp_query->the_post();
                    $stt = get_field('status');
                ?>
                <tr <?php if($stt=='batdau') { ?> class="lock"<?php } ?> >
                <td>
                        <?php
                        $stt = get_field('status');
                        switch ($stt) {
                            case "tvv":
                                $stt_text = "Tư vấn viên";
                            break;
                            case "pending":
                                $stt_text = "Chờ khám";
                            break;
                            case "quay":
                                $stt_text = "Quầy";
                            break;
                            case "bsnk":
                                $stt_text = "Bác sĩ ngoại khoa";
                            break;
                            case "bsk":
                                $stt_text = "Bác sĩ Khải";
                            break;
                            case "batdau":
                                $stt_text = "Đang mổ";
                            break;
                            case "phauthuat":
                                $stt_text = "Phẫu thuật";
                            break;
                            case "hauphau":
                                $stt_text = "Hậu phẫu";
                            break;
                            case "cshp":
                                $stt_text = "CSHP";
                            break;
                            case "huy":
                                $stt_text = "Đã Huỷ";
                            break;
                        }
                        ?>
                        <?php if($stt=='batdau') { ?>
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        <?php } ?>
                        <span class="noteColor note--<?php echo $stt ?>"></span>
                        <em><?php echo $stt_text ?></em>
                        <?php if((get_field('debt')!='')||(get_field('debt')!=0)) { ?>
                        <span class="noteRemind noteRemind--1">Còn nợ</span>
                        <?php } ?>
                        
                    </td>
                    <td><?php the_title(); ?></td>
                    <td><?php the_field('fullname'); ?></td>
                    <td><?php the_field('mobile'); ?></td>
                    <?php if(($_COOKIE['role_cookies']=='counter')||($_COOKIE['role_cookies']=='manager')) { ?>
                        <td class="last">
                            <a href="<?php the_permalink(); ?>?tab=2" title="Chi tiết"><i class="fa fa-money" aria-hidden="true"></i></a></td>
                        </td>
                    <?php } ?>

                </tr>
                <?php endwhile;endif; ?>
            </tbody>
        </table>
        <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
    </div>
</div>

<!--Footer-->
<?php include(APP_PATH."libs/footer.php"); ?>
<!--/Footer-->

</div>
<!--/wrapper-->
</div>

<script>
    $(function(){
      // bind change event to select
      $('#selectBox').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>

</body>
</html>	