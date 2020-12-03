<?php

namespace app\controllers;

use app\models\Tasks;
use app\base\App;

class SiteController extends Controller
{
    public $content;

    public function __construct()
    {
        $this->content = new Tasks();
    }

    public function actionIndex()
    {
        $form = ucfirst( App::call() -> request -> post('post'));

        if (count($_POST) > 0) {
            $this->content->getNewTask();
        }

        $this->content->getStep( ucfirst( App::call() -> request -> get('step') ) );
        echo $this->defineRenderer("pages/beeJee", [ 'content' => $this->content->splitTasks [ $this->content->pageStep ] ], [ 'title' => 'BeeJee' ]);
    }

/*

    public function actionPagination(){
        var_dump($this->content);
        echo $this->defineRenderer("pages/beeJee", [ 'content' => [] ], [ 'title' => 'BeeJee' ]);
    }*/

    public function actionCatalog()
    {
/*        $this->layout = 'catalog';

        $category = ucfirst(App::call()->request->get('category'));
        $type = ucfirst(App::call()->request->get('type'));

        $title = $type;
        if ($title === '') {
            $title = $category;
        }
        $goods = $this->goodsData->getSortedGoods($category, $type);

        echo $this->defineRenderer("pages/catalog", ['goods' => $goods], ['title' => $title]);*/
    }


    public function actionSingleGood()
    {
/*        $this->layout = 'main';

        $id = App::call()->request->get('id');
        $good = $this->goodsData->getOneGood($id);
        $title = $good[0]['title'];

        echo $this->defineRenderer("pages/singleGood", ['good' => $good[0]], ['title' => $title]);*/
    }


}