<?php
namespace Controllers{
    use Core\Controller;
    use Core\Routing;
    
    class FrontStaticController extends Controller
    {
        const TEMPLATE = "static";

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

            $pageContent = $this->getPageContent();
            $this->appendVariables(['page_content' => $pageContent]);
        }

        protected function getPageContent()
        {
            $request = Routing::parseCurrentRequest();
            return $request[0];
        }
    }
}
