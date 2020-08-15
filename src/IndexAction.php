<?php
/**
 * @link http://www.konkeanweb.com
 * 9/22/2016 AD 3:13 AM
 * @copyright Copyright (c) 2016 served
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * @license BSD-3-Clause
 */
namespace prawee\actions;

use Yii;
use yii\base\Action;

class IndexAction extends Action
{
    public $view='index';
    public $model;
    public function run()
    {
        $searchModel = new $this->model;
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
        return $this->controller->render($this->view,[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }
}