<?php
/**
 * @link http://www.konkeanweb.com
 * 2020-08-15 18:38
 * @copyright Copyright (c) 2020 served
 * @author Prawee Wongsa <prawee@hotmail.com>
 * @license MIT
 */
namespace prawee\actions;

use Yii;
use yii\base\Action;

class ToggleAction extends Action
{
    public $model;
    public $redirect = ['index'];
    public $attribute = 'status';
    public $checkPermission = false;

    public function run($id)
    {
        $className = $this->model;
        $model = $className::findOne($id);
        if ($this->checkPermission()) {
            $model->{$this->attribute} = !$model->{$this->attribute};
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Change '.$this->controller->id.' Completed.');
            } else {
                Yii::$app->session->setFlash('Error', 'Do not change fail.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Do not change this item.');
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