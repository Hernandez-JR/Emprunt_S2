<?php
session_start();
session_unset();
session_destroy();
header('Location: ../pages/page_sites/login.php');
exit();
