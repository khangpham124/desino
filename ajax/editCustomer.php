<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH_WP."/wp-load.php");
$reg_fullname = $_POST['fullname'];
$reg_mobile = $_POST['mobile'];
$reg_address = $_POST['address'];
$reg_pass = md5($_POST['password']);
$reg_oldpass = md5($_POST['old_password']);


$reg_url = $_POST['url'];

update_post_meta($_SESSION['idcustomer'],'fullname',$reg_fullname);
update_post_meta($_SESSION['idcustomer'],'mobile',$reg_mobile);
update_post_meta($_SESSION['idcustomer'],'address',$reg_address);

header('Location:'.$reg_url);


$wp_query = new WP_Query();
$param = array (
'p' => $_SESSION['idcustomer'],	
'posts_per_page' => '-1',
'post_type' => 'customer',
'post_status' => 'publish',
);
$wp_query->query($param);
while($wp_query->have_posts()) :$wp_query->the_post();
    $pass_real = get_field('password');
    if($pass_real==$reg_oldpass) {
        update_post_meta($_SESSION['idcustomer'],'password',$reg_pass);
        setcookie('err_change','', time() + 86400, "/");
    }
    else {
        setcookie('err_change', 'Old password is not correct. Please try again', time() + (86400 * 30), "/");
        header('Location:'.$reg_url);
    }
endwhile;

?>