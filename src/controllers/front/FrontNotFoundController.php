<?php
namespace Controllers{

    use Core\Controller;
    use Core\Configuration;

    class FrontNotFoundController extends Controller
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
