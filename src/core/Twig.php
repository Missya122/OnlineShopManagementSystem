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

            $theme_name = $this->theme;
            $loader = new Twig_Loader_Filesystem("src/view/themes/{$theme_name}/templates");
            
            $this->twig = new Twig_Environment($loader);
        }

        public function display($template, $variables)
        {
            echo $this->twig->render("{$template}.twig", $variables);
        }
    }
}
