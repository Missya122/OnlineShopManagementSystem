<?php

namespace Core
{
    class Settings
    {
        const DB_CONNECTION = "database_connection";

        private $settings;

        public function __construct()
        {
            $this->settings = parse_ini_file("config/settings.ini", true);
        }

        public function get($section)
        {
            return isset($this->settings[$section]) ? $this->settings[$section] : null;
        }
    }
}
