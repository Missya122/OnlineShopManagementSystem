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

        public function display()
        {
            $this->twig->display($this->template, $this->variables);
        }
    }

}
