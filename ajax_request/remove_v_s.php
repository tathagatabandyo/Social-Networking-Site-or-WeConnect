<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION["user_verify_status"] = false;
?>