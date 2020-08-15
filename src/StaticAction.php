<?php
/**
 * @link http://www.konkeanweb.com
 * 9/22/2016 AD 4:54 AM
 * @copyright Copyright (c) 2016 served
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * @license BSD-3-Clause
 */
namespace prawee\actions;

use yii\base\Action;

class StaticAction extends Action
{
    public $view='index';
    public function run(){
        return $this->controller->render($this->view);
    }
}