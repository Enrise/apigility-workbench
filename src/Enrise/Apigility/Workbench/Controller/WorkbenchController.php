<?php

namespace Enrise\Apigility\Workbench\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Enrise\Apigility\Workbench\Model\ModuleModel;


class WorkbenchController extends AbstractActionController
{
    protected $moduleModel;

    public function __construct(ModuleModel $moduleModel)
    {
        $this->moduleModel = $moduleModel;
    }

    public function indexAction()
    {
        var_dump($this->moduleModel->getModules());
    }
}
