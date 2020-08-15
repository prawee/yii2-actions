<?php
/**
 * @link http://www.konkeanweb.com
 * 2/25/2017 AD 11:27 AM
 * @copyright Copyright (c) 2017 served
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * @license BSD-3-Clause
 */
namespace prawee\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidParamException;

class HierarchyAction extends Action
{
    public $view = 'index';
    public $reference = 'parent';
    public $model;
    public $rootAttribute = 'id';
    public $rootReference;
    public $rootRedirect = ['parent/index'];
    public $rootModel;
    public function init()
    {
        parent::init();
        if (empty($this->model))
            throw new InvalidParamException(Yii::t('app', 'invalid {model} on Hierarchy action.'));
        if (empty($this->rootReference))
            throw new InvalidParamException(Yii::t('app', 'invalid {rootReference} on Hierarchy action.'));
        if (empty($this->rootModel))
            throw new InvalidParamException(Yii::t('app', 'invalid {rootModel} on Hierarchy action.'));
    }

    public function run()
    {
        $rootInfo = null;
        $parentInfo = null;

        $rootId = Yii::$app->request->get($this->rootAttribute);
        if (empty($rootId)) {
            return $this->controller->redirect($this->rootRedirect);
        }
        $parentId = Yii::$app->request->get($this->reference);

        $rootClass = $this->rootModel;
        $rootInfo = $rootClass::findOne($rootId);

        $searchModel = new $this->model;
        $params = Yii::$app->request->queryParams;
        if(isset($rootId)){
            $params[$this->classModel()][$this->rootReference] = $rootId;
        }
        if(isset($parentId)){
            $params[$this->classModel()][$this->reference] = $parentId;
            $className = $this->model;
            $parentInfo = $className::findOne($parentId);
        }

        $dataProvider = $searchModel->search($params);
        return $this->controller->render($this->view,[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'rootInfo' => $rootInfo,
            'parentInfo' => $parentInfo
        ]);
    }
    public function classModel()
    {
        $elementClass = explode('\\', $this->model);
        return end($elementClass);
    }
}