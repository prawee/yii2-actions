<?php
/**
 * @link http://www.konkeanweb.com
 * 12/12/2017 AD 11:14 PM
 * @copyright Copyright (c) 2017 served
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * @license MIT
 */
namespace prawee\actions;

use Yii;
use yii\base\Action;

class PasswordAction extends Action
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

            $password = Yii::$app->request->post()['User']['password'];
            if (!empty($password)) {
                $model->setPassword($password);
            }

            if ($model->id !== 1  && $model->save()) {
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