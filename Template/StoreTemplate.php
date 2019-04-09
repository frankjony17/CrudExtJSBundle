<?php
/**
 * Created by PhpStorm.
 * User: frank.ricardo
 * Date: 24/02/2016
 * Time: 17:12
 */

namespace CrudExtJSBundle\Template;


class StoreTemplate
{
    private $namespace;
    private $fields;
    private $sorters;
    private $url;

    /**
     * StoreTemplate constructor.
     */
    public function __construct()
    {
        $this->fields = array();
    }

    /**
     * Set Namespace.
     *
     * @param $namespace
     * @return StoreTemplate
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Set Fields.
     *
     * @param $tableInformation
     * @return StoreTemplate
     */
    public function setFields($tableInformation)
    {
        foreach ($tableInformation as $information) {
            $this->fields[] = $information['column_name'];
        }
        return $this;
    }

    /**
     * Set Sorters.
     *
     * @param $tableInformation
     *
     * @return StoreTemplate
     */
    public function setSorters($tableInformation)
    {
        if (count($tableInformation) >= 2) {
            $this->sorters = $tableInformation[1]['column_name'];
        } else {
            $this->sorters = $tableInformation[0]['column_name'];
        }

        return $this;
    }

    /**
     * Set Url.
     *
     * @param $bundle
     * @param $tableName
     * @return StoreTemplate
     */
    public function setUrl($bundle, $tableName)
    {
        $this->url = '../'. $bundle .'/'. $tableName .'/list';

        return $this;
    }

    /**
     * Get store code for writing js file.
     *
     * @param $templateContent
     *
     * @return string
     */
    public function getStoreJs($templateContent)
    {
        $templateContent = str_replace('NAMESPACE', $this->namespace, $templateContent);
        $templateContent = str_replace('FIELDS', json_encode($this->fields), $templateContent);
        $templateContent = str_replace('SORTERS', $this->sorters, $templateContent);
        $templateContent = str_replace('URL', $this->url, $templateContent);

        return $templateContent;
    }
}