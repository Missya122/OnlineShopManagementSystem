<?php
namespace Controllers{

    use Core\FrontController;
    use Core\Configuration;

    class FrontNotFoundController extends FrontController
    {
        const TEMPLATE = "not-found";

        public function __construct()
        {
            parent::__construct();
        }

        public function init()
        {
            parent::init();

            $this->template = self::TEMPLATE;
        }
    }
}
