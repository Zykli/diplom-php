<?php
class Base
{
    public $model;

    function __construct($model)
    {
        $this->model = $model;
    }

    public function render($template, $params = [])
    {
        require __DIR__.'/../vendor/autoload.php';
        $loader = new Twig_Loader_Filesystem('./template');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => './tmpphp',
            'auto_reload' => true
        ));
        $template = $this->twig->LoadTemplate($template);
        $template->display($params);
    }
}

