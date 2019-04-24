<?php
$pagename = str_replace(array('/', '.php', '?s='), '', $_SERVER['REQUEST_URI']);
$pagename = str_replace("wp", '', $_SERVER['REQUEST_URI']);
$pagename = $pagename ? $pagename : 'default';

switch ($pagename) {
    case "aboutus":
		$titlepage = "About us title";
		$desPage = "";
		$keyPage = "";
		$txtH1 = "H1 content for about us";
	break;
	 
    default:
		if($titlepage=='') {$titlepage = "desino | Premium Leather Handbags and Accessories";}			
		if($desPage=='') { $desPage = "Vietnam's Premium Leather Handbags and Accessories - Nhãn Hiệu Túi Xách và Phụ Kiện Da Cao Cấp";}
		$keyPage = "tui xach da nhan hieu vietnam, tui xach desino, tui xach da cao cap, phu kien da cao cap, Nhan Hieu Tui Xach, Phu Kien Da Cao Cap, tui xach viet nam";
		$txtH1 = "Vietnam's Premium Leather Handbags and Accessories - Nhãn Hiệu Túi Xách và Phụ Kiện Da Cao Cấp";
}
?>