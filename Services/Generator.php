<?php

namespace CrudExtJSBundle\Services;

use CrudExtJSBundle\Template\ControllerJSTemplate;
use CrudExtJSBundle\Template\ControllerPHPTemplate;
use CrudExtJSBundle\Template\ControllerTemplate;
use CrudExtJSBundle\Template\FormTemplate;
use CrudExtJSBundle\Template\GridTemplate;
use CrudExtJSBundle\Template\StoreTemplate;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Generator functions.
 *
 * @author Frank Ricardo R <frank.ricardo@etecsa.cu>
 */
class Generator
{
    private $path;
    private $temp;
    private $bundle;
    private $appName;
    private $tableName;
    private $util;
    private $tableInformation;
    private $gridNamespace;
    private $formNamespace;

    /**
     * @param Container $container
     */
    function __construct(Container $container)
    {
        $this->util = $container->get('crud_ext_js.util');
    }

    /**
     * Generate ExtJS CRUD.
     * Create many file -> Ext.grid.Panel, Grid.js, Form.js, Store.js
     *
     * @param $tableName
     * @param $appName
     * @param $bundle
     */
    public function generateExtjsCrud($bundle, $appName, $tableName)
    {
        $this->path = $this->util->getPath();
        $this->bundle = $bundle;
        $this->appName = $appName;
        $this->tableName = $tableName;
        /* Get information from table on database */
        $this->tableInformation = $this->util->getTableInformation($tableName);
        /* Generate store js */
        $this->generateStore();
        /* Generate grid js */
        $this->generateGrid();
        /* Generate form js */
        $this->generateForm();
        /* Generate Controller JS */
        $this->generateControllerJS();
        /* Generate Controller PHP */
        $this->generateControllerPHP();
    }

    private function generateStore()
    {
        $store = new StoreTemplate();
        /* Save namespace value for use in generateGrid */
        $this->temp = $this->appName .'.store.'. $this->util->getName($this->tableName, "") .'Store';
        /* Sets */
        $store->setNamespace($this->temp);
        $store->setFields($this->tableInformation);
        $store->setSorters($this->tableInformation);
        $store->setUrl($this->util->getBundleName($this->bundle), $this->tableName);
        /* Writes content in file */
        $this->util->dumpFile(
            '/web/js/app/store/'. $this->util->getName($this->tableName, "") .'Store.js',
            $store->getStoreJs($this->util->getTemplateContent('StoreTemplate.js')));
    }

    private function generateGrid()
    {
        $grid = new GridTemplate();
        $grid->setNamespace($this->appName .'.view.'. $this->util->getBundleName($this->bundle) .'.'. $this->tableName .'.'. $this->util->getName($this->tableName, "") .'Grid');
        $grid->setXtype($this->tableName);
        $grid->setStoreNamespase($this->temp);
        $grid->setColumns($this->tableInformation);
        /* Writes content in file */
        $this->util->dumpFile(
            '/web/js/app/view/'. $this->util->getBundleName($this->bundle) .'/'. $this->tableName .'/'. $this->util->getName($this->tableName, "") . 'Grid.js',
            $grid->getGridJs($this->util->getTemplateContent('GridTemplate.js')));
    }

    private function generateForm()
    {
        $form = new FormTemplate($this->appName, $this->tableName, $this->util->getBundleName($this->bundle), $this->util);
        $form->setUrl($this->util->getBundleName($this->bundle), $this->tableName);
        $form->setNamespace($this->appName .'.view.'. $this->util->getBundleName($this->bundle) .'.'. $this->tableName .'.'. $this->util->getName($this->tableName, "") .'Form');
        $form->setXtype($this->tableName);
        /* Writes content in file */
        $this->util->dumpFile(
            '/web/js/app/view/'. $this->util->getBundleName($this->bundle) .'/'. $this->tableName .'/'. $this->util->getName($this->tableName, "") . 'Form.js',
            $form->getFormJs($this->tableInformation));
        /* Save form namespace */
        $this->formNamespace = $form->getNamespace();
    }

    private function generateControllerJS()
    {
        $controller = new ControllerJSTemplate();
        $controller->setTitle($this->util->getName($this->tableName, " "));
        $controller->setNamespace($this->appName .'.controller.'. $this->util->getBundleName($this->bundle) .'.'. $this->util->getName($this->tableName, "") .'Controller');
        $controller->setXtypeForm('form-'. $this->tableName);
        $controller->setXtypeGrid('grid-'. $this->tableName);
        $controller->setFormNamespace($this->formNamespace);
        $controller->setUrlRemove($this->util->getBundleName($this->bundle) .'/'. $this->tableName .'/remove');
        /* Writes content in file */
        $this->util->dumpFile(
            '/web/js/app/controller/'. $this->util->getBundleName($this->bundle) .'/'. $this->util->getName($this->tableName, "") .'Controller.js',
            $controller->getControllerJs($this->util->getTemplateContent('ControllerTemplate.js'))
        );
    }


    private function generateControllerPHP()
    {
        $controller = $this->util->finder($this->util->getName($this->tableName, "") .'Controller', '\\src\\');

        if (!$controller) {
            $controller = new ControllerPHPTemplate($this->tableInformation, $this->util);
            $controller->setBundle($this->bundle);
            $controller->setEntity($this->util->getName($this->tableName, ""));
            $controller->setRoute($this->util->getBundleName($this->bundle) .'/'. $this->tableName);
            /* Writes content in file */
            $this->util->dumpFile(
                '/src/'. $this->bundle .'/Controller/'. $this->util->getName($this->tableName, "") .'Controller.php',
                $controller->getControllerPHP($this->util->getTemplateContent('ControllerTemplate'))
            );
        }
    }
}
