<?php
namespace Utils;

class Tools {
    public static function getValue($key) {
        return isset($_GET[$key]) ? $_GET[$key] : (isset($_POST[$key]) ? $_POST[$key] : false);
    }

    public static function isSubmit($key) {
        return isset($_GET[$key]) || isset($_POST[$key]);
    }

    public static function redirectAdmin() {
        header("Location: /panel/");
        exit();
    }

    public static function redirectAdminLogin() {
        header("Location: /panel/login/");
        exit();
    }
}