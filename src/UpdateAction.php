<?php
/**
 * @link http://www.konkeanweb.com
 * 2/4/2017 AD 6:17 PM
 * @copyright Copyright (c) 2017 served
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * @license BSD-3-Clause
 */
namespace prawee\actions;

use Yii;
use yii\base\Action;

class UpdateAction extends Action
{
    public $view = 'update';
    public $model;
    public $redirect = ['index'];

    public function run($id)
    {
        $className = $this->model;
        $model = $className::findOne($id);
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            if ($model->errors) {
                return null;
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Update '.$this->controller->id.' Completed.');
            }
            return $this->controller->redirect($this->redirect);
        } else {
            return Yii::$app->getRequest()->isAjax ?
                $this->controller->renderAjax($this->view, ['model' => $model]) :
                $this->controller->render($this->view, ['model' => $model]);
        }
    }
}