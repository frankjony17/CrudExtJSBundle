<?php
/**
 * Created by PhpStorm.
 * User: frank.ricardo
 * Date: 24/02/2016
 * Time: 17:12
 */

namespace CrudExtJSBundle\Template;


class ControllerJSTemplate
{
    private $title;
    private $urlRemove;
    private $namespace;
    private $xtypeGrid;
    private $xtypeForm;
    private $formNamespace;

    /**
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param $namespace
     *
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @param $formNamespace
     *
     * @return $this
     *
     */
    public function setFormNamespace($formNamespace)
    {
        $this->formNamespace = $formNamespace;

        return $this;
    }

    /**
     * @param $xtypeGrid
     *
     * @return $this
     */
    public function setXtypeGrid($xtypeGrid)
    {
        $this->xtypeGrid = $xtypeGrid;

        return $this;
    }

    /**
     * @param $xtypeForm
     *
     * @return $this
     */
    public function setXtypeForm($xtypeForm)
    {
        $this->xtypeForm = $xtypeForm;

        return $this;
    }

    /**
     * @param $urlRemove
     *
     * @return $this
     */
    public function setUrlRemove($urlRemove)
    {
        $this->urlRemove = '\'../'. $urlRemove .'\'';

        return $this;
    }

    /**
     * Get grid code for writing js file.
     *
     * @param $templateContent
     *
     * @return string
     */
    public function getControllerJs($templateContent)
    {
        $templateContent = str_replace('NAMESPACE', $this->namespace, $templateContent);
        $templateContent = str_replace('XTYPEGRID', $this->xtypeGrid, $templateContent);
        $templateContent = str_replace('XTYPEFORM', $this->xtypeForm, $templateContent);
        $templateContent = str_replace('FORM', $this->formNamespace, $templateContent);
        $templateContent = str_replace('TITLE', $this->title, $templateContent);
        $templateContent = str_replace('URL_REMOVE', $this->urlRemove, $templateContent);

        return $templateContent;
    }
}