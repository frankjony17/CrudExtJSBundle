<?php
/**
 * Created by PhpStorm.
 * User: frank.ricardo
 * Date: 24/02/2016
 * Time: 17:12
 */

namespace CrudExtJSBundle\Template;


class GridTemplate
{
    private $namespace;
    private $xtype;
    private $width;
    private $border;
    private $selType;
    private $autoScroll;
    private $scrollable;
    private $storeNamespase;
    private $columns;

    /**
     * GridTemplate constructor.
     */
    public function __construct()
    {
        $this->width = '100%';
        $this->border = true;
        $this->selType = 'checkboxmodel';
        $this->autoScroll = true;
        $this->scrollable = 'vertical';
        $this->columns = array();
    }

    /**
     * Set Namespase.
     *
     * @param $namespace
     *
     * @return GridTemplate
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Set Xtype.
     *
     * @param mixed $tableName
     * @return GridTemplate
     */
    public function setXtype($tableName)
    {
        $this->xtype = $tableName;

        return $this;
    }

    /**
     * Set Information Schema.
     *
     * @param array $tableInformation
     * @return GridTemplate
     */
    public function setColumns($tableInformation)
    {
        /* Firs column rownumberer */
        $this->columns[] = array(
            'xtype' => 'rownumberer',
            'text' => 'No',
            'width' => 45,
            'align' => 'center',
        );
        /* Other columns */
        foreach ($tableInformation as $information) {
            $dataType = $information['data_type'];
            $columnName = $information['column_name'];
            $character_length = $information['character_maximum_length'];
            /* Add columns */
            $this->columns[] = $this->getColumn($dataType, $columnName, $character_length);
        }
        return $this;
    }

    /**
     * Set Store.

     * @param $storeNamespase
     *
     * @return GridTemplate
     */
    public function setStoreNamespase($storeNamespase)
    {
        $this->storeNamespase = $storeNamespase;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get grid code for writing js file.
     *
     * @param $templateContent
     *
     * @return string
     */
    public function getGridJs($templateContent)
    {
        $templateContent = str_replace('NAMESPACE', $this->namespace, $templateContent);
        $templateContent = str_replace('XTYPE', 'grid-'. $this->xtype, $templateContent);
        $templateContent = str_replace('WIDTH', $this->width, $templateContent);
        $templateContent = str_replace('BORDER', $this->border, $templateContent);
        $templateContent = str_replace('SELTYPE', $this->selType, $templateContent);
        $templateContent = str_replace('AUTOSCROLL', $this->autoScroll, $templateContent);
        $templateContent = str_replace('SCROLLABLE', $this->scrollable, $templateContent);
        $templateContent = str_replace('STORE', 'Ext.create(\''. $this->storeNamespase .'\')', $templateContent);
        $templateContent = str_replace('COLUMNS', json_encode($this->columns), $templateContent);
        $templateContent = str_replace('TOOLBAR', $this->xtype, $templateContent);

        return $templateContent;
    }

    /**
     * Get column.
     *
     * @param $dataType
     * @param $columnName
     * @param $character_length
     * @return array
     */
    private function getColumn($dataType, $columnName, $character_length)
    {
        $hidden = false;
        /* get flex */
        switch ($dataType) {
            case "date":
            case "real":
            case "integer":
            case "boolean":
                $flex = 2;
                break;
            case "text":
                $flex = 7;
                break;
            case "character varying":
                if ($character_length <= 15) {
                    $flex = 1;
                } else if ($character_length <= 30) {
                    $flex = 2;
                } else if ($character_length <= 60) {
                    $flex = 3;
                } else if ($character_length <= 90) {
                    $flex = 4;
                } else if ($character_length <= 120) {
                    $flex = 5;
                } else {
                    $flex = 7;
                }
                break;
            default:
                $flex = 3;
                break;
        }
        /* get hidden */
        if (stristr($columnName, '_id') !== false) {
            $hidden = true;
        }
        /* return column */
        return array(
            'text' => $this->getColumnName($columnName, " "),
            'dataIndex' => $columnName,
            'flex' => $flex,
            'hidden' => $hidden
        );
    }

    /**
     * Get Column Name.
     *
     * @param $columnName
     * @param $delimiter
     *
     * @return string
     */
    private function getColumnName($columnName, $delimiter)
    {
        $columnText = "";
        $arrayColumnName = explode('_', $columnName);
        /* get text */
        foreach ($arrayColumnName as $value) {
            $columnText .= ucwords($value) .$delimiter;
        }
        return trim($columnText, $delimiter);
    }
}