<?php

namespace Core{
    use Core\Routing;

    class Controller
    {
        protected $twig;
        protected $theme;
        protected $template;
        protected $variables;

        protected $context;
        protected $request;

        const CONTROLLER_FRONT = "FRONT";
        const CONTROLLER_BACK = "ADMIN";

        public function __construct()
        {
            $this->request = Routing::parseCurrentRequest();
          
            $this->init();
        }

        public function init()
        {
            $context = Context::getInstance();
            $context->currentController = $this;

            $this->context = $context;

            $this->theme = Configuration::getValue("theme");
            $this->twig = new Twig($this->theme);

            $this->initVariables();
        }
        
        public function initVariables()
        {
            $this->variables = [];

            $this->variables["title"] = Configuration::getValue("shop_title");
            $this->variables["currency"] = Configuration::getValue("currency");
        }

        protected function appendVariables($variables)
        {
            $this->variables = array_merge($this->variables, $variables);
        }

        public function display()
        {
            $this->variables["pagename"] = $this->template;
            
            $this->twig->display($this->template, $this->variables);
        }
    }

}
