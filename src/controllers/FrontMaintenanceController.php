<?php
namespace Controllers{
    use Core\FrontController;
    use Core\Configuration;
    
    class FrontMaintenanceController extends FrontController
    {
        const TEMPLATE = "maintenance";

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

            $header = Configuration::getValue("maintenance_header");
            $content = Configuration::getValue("maintenance_text");

            $this->appendVariables(["header" => $header, "content" => $content]) ;
        }
    }
}
