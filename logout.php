<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
setcookie('login_cookies','', time() + 86400, "/");
setcookie('role_cookies','', time() + 86400, "/");
setcookie('name_cookies','', time() + 86400, "/");
header('Location:'.APP_URL.'login');
?>