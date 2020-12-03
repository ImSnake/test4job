<?php
/**
 * Created by PhpStorm.
 * User: pulik
 * Date: 23.10.2018
 * Time: 12:12
 */

namespace app\services\renderers;


interface IRenderer
{
    public function render($template, $params = [], $title = []);

}