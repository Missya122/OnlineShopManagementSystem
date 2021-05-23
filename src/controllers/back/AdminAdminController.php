<?php
namespace Controllers{
    use Core\Configuration;
    use Core\Controller;

    class AdminAdminController extends Controller
    {
        const TEMPLATE = "admin";

        public function __construct()
        {
            parent::__construct();
        }

        public function init()
        {
            parent::init();

            $this->template = self::TEMPLATE;
        }

        public function initVariables()
        {
            parent::initVariables();
        }
    }
}
