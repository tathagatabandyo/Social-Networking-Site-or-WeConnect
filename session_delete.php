<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(!isset($_SESSION)) {
            session_start();
        }
        session_unset();
        session_destroy();
    }

?>