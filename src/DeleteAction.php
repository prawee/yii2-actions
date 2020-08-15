<?php
/**
 * @link http://www.konkeanweb.com
 * 2/4/2017 AD 6:18 PM
 * @copyright Copyright (c) 2017 served
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * @license BSD-3-Clause
 */
namespace prawee\actions;

use Yii;
use yii\base\Action;

class DeleteAction extends Action
{
    public $model;
    public $redirect = ['index'];
    public $checkPermission = false;

    public function run($id)
    {
        $className = $this->model;
        $model = $className::findOne($id);
        if ($this->checkPermission()) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Delete '.$this->controller->id.' Completed.');
        } else {
            Yii::$app->session->setFlash('error', 'Do not delete this item.');
        }
        return $this->controller->redirect($this->redirect);
    }
    public function checkPermission()
    {
        if (!$this->checkPermission) {
            return true;
        }
        $actionItem = $this->controller->id.'.'.$this->controller->action->id;
        if (Yii::$app->user->can($actionItem)) {
            return true;
        }
        return false;
    }
}