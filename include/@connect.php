<?php
    require_once "@function.php";

    $env = parse_ini_file(".env");
    $db = new mysqli($env["DB_HOST"], $env["DB_USER"], $env["DB_PASSWORD"], $env["DB_NAME"], null, $env["DB_SOCKET"]);

    session_set_cookie_params(3600 * 24 * 7);
    session_start();
    $user_id = getValueFromSession("user_id");
    $name = getValueFromSession("name");
    $password = getValueFromSession("password");
    $logged_in = isset($user_id, $name, $password)
?>