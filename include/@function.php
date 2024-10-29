<?php
function getValueFromSession(string $key, mixed $defaultValue = null) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
};
?>