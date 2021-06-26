<?php

namespace Utils;

class Tools {
    public static function getValue($key) {
        return isset($_GET[$key]) ? $_GET[$key] : (isset($_POST[$key]) ? $_POST[$key] : false);
    }

    public static function isSubmit($key) {
        return isset($_GET[$key]) || isset($_POST[$key]);
    }

    public static function redirect($location)
    {
        header("Location: {$location}");
        exit();
    }

    public static function redirectAdmin() {
        self::redirect("/panel/");
    }

    public static function redirectAdminLogin() {
        self::redirect("/panel/login/");
    }
}