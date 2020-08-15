<?php
/**
 * @link http://www.konkeanweb.com
 * 2/4/2017 AD 6:13 PM
 * @copyright Copyright (c) 2017 served
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * @license BSD-3-Clause
 */
namespace prawee\actions;

use Yii;
use yii\base\Action;

class ViewAction extends Action
{
    public $view = 'view';
    public $model;

    public function run($id)
    {
        $className = $this->model;
        $model = $className::findOne($id);
        return Yii::$app->getRequest()->isAjax ?
            $this->controller->renderAjax($this->view, ['model' => $model]) :
            $this->controller->render($this->view, ['model' => $model]);
    }
}