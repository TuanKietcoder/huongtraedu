<?php
function getValueFromSession(string $key, mixed $defaultValue = null) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
};

function unique_id() {
    $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $rand = array();
    $length = strlen($str) - 1;
    for ($i = 0; $i < 20; $i++) {
        $n = mt_rand(0, $length);
        $rand[] = $str[$n];
    }
    return implode($rand);
}
?>