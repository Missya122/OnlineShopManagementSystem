<?php
namespace Controllers{
    use Core\Context;
    use Core\Controller;

    class AdminPanelController extends Controller
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
