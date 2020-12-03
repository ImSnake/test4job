<?php


namespace app\controllers;

use app\base\App;

abstract class Controller
{
    protected $layout = 'beejee';
    protected $useLayout = true;  // если false -  выводит данные без layout

    private $action;
    private $defaultAction = 'index';

// если вызванный метод существует - запускает
    public function run($action = null)
    {
        $this->action = $action ?: $this->defaultAction;  // если $action пустой, добавить action по дефолту
        $method = "action" . ucfirst($this->action);

        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            echo '404';
        }

    }

// определяет и вызывает метод вывода шаблона (c layout или без)
    public function defineRenderer($template, $params = [], $title = [])
    {
        if ($this->useLayout) {
            $contentPHP = $this->renderTemplate($template, $params);
            return $this->renderTemplate("layouts/{$this->layout}", ['contentPHP' => $contentPHP], $title);
        }
        return $this->renderTemplate($template, $params, $title);
    }

// передает задачу на вывод в servises/renderers
    public function renderTemplate($template, $params = [], $title = [])
    {
        return App::call()->renderer->render($template, $params, $title);
    }
}