<?php

namespace Core{

    class FrontController
    {
        protected $twig;
        protected $theme;
        protected $template;
        protected $variables;

        public function __construct()
        {
            $this->init();
        }

        public function init()
        {
            $this->theme = Configuration::getValue("theme");
            $this->twig = new Twig($this->theme);

            $this->initVariables();
        }
        

        public function initVariables()
        {
            $this->variables = [];

            $this->variables["title"] = Configuration::getValue("shop_title");
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
