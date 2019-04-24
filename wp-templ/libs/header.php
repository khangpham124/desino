<?php echo('<?xml version="1.0" encoding="UTF-8"?>'); ?>
<?php $lang_web = "";
if($_COOKIE['lang_web']) {
$lang_web = $_COOKIE['lang_web'];
} else {
$lang_web = 'vn';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!--responsive or smartphone-->
<meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0">
<meta name="format-detection" content="telephone=no">
<!--responsive or smartphone-->
<?php include(TEMPLATEPATH."/libs/argument.php"); ?>
<title><?php echo $titlepage; ?></title>
<meta name="description" content="<?php echo $desPage; ?>">
<meta name="keywords" content="<?php echo $keyPage; ?>">

<!--facebook-->
<meta property="og:title" content="<?php echo $titlepage; ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>">
<?php if($thumb_share_fb) { ?>
<meta property="og:image" content="<?php echo $thumb_share_fb; ?>">
<?php } else {?>    
<meta property="og:image" content="<?php echo APP_URL; ?>common/img/other/fb_image.jpg">
<?php } ?>
<meta property="og:site_name" content="desino Premium Leather Handbags and Accessories">
<meta property="og:description" content="<?php echo $desPage; ?>">
<meta property="fb:app_id" content="309153426215050">
<!--/facebook-->

<!--css-->
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/base.css" media="all">
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/style.css" media="all">
<!--/css-->

<!--favicons-->
<link rel="icon" href="<?php echo APP_URL; ?>common/img/icon/favicon.ico" type="image/vnd.microsoft.icon">
<link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900&amp;subset=vietnamese" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
@font-face{font-family:'futura';src:url('/admin/wp-content/themes/wp-templ/font/VNF-Futura Regular.ttf');}
@font-face{font-family:'futura_bold';src:url('/admin/wp-content/themes/wp-templ/font/VNF-Futura-bold.ttf');}
</style>