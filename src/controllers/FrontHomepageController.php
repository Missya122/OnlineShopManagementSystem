<?php
namespace Controllers{
    use Core\FrontController;
    use Core\Configuration;
    
    class FrontHomepageController extends FrontController
    {
        const TEMPLATE = "homepage";

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
