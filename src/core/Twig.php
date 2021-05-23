<?php

namespace Core
{
    use Twig_Loader_Filesystem;
    use Twig_Environment;

    class Twig
    {
        protected $theme;
        protected $twig;

        public function __construct($theme)
        {
            $this->theme = $theme;

            $templates_path = $this->getTemplatesPath();
            $loader = new Twig_Loader_Filesystem($templates_path);
            
            $this->twig = new Twig_Environment($loader);
        }

        private function getTemplatesPath()
        {
            $theme = $this->theme;
            $context = Context::getInstance();
            if ($context->controllerType === Controller::CONTROLLER_BACK) {
                return BASE_DIR."/admin/";
            } else {
                return BASE_DIR."/view/themes/{$theme}/templates";
            }
        }

        public function display($template, $variables)
        {
            echo $this->twig->render("{$template}.twig", $variables);
        }
    }
}
