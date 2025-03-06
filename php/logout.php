<?php
session_start();
print_r($_SESSION);
$_SESSION = array();
print_r($_SESSION);
session_destroy();
?>