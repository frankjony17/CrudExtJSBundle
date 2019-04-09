<?php

namespace CrudExtJSBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Util functions.
 *
 * @author Frank Ricardo R <frank.ricardo@etecsa.cu>
 */
class Util
{
    private $em, $container;

    /**
     * @param Container $container
     * @param $em
     */
    function __construct(Container $container, $em)
    {
        $this->em = $em;
        $this->container = $container;
    }
    
    /**
     * Get content from existent template file.
     *
     * @param $fileName
     * @return string
     */
    public function getTemplateContent($fileName)
    {
        $templatePath = realpath($this->container->get('kernel')->locateResource('@CrudExtJSBundle') .'\\Resources\\template\\'. $fileName);
        /* Exception if not exist the file */
        if (!$templatePath) {
            throw new \RuntimeException('No found file: '. $templatePath);
        }
        /* Get content from file */
        return file_get_contents($templatePath);
    }

    /**
     * Get content from existent file.
     *
     * @param $file
     * @return string
     */
    public function getFileContent($file)
    {
        $filePath = realpath($this->getPath() . $file);
        /* Exception if not exist the file */
        if (!$filePath) {
            throw new \RuntimeException('No found file: '. $filePath);
        }
        /* Get content from file */
        return file_get_contents($filePath);
    }

    /**
     * Get Name.
     *
     * @param $columnName
     * @param $delimiter
     *
     * @return string
     */
    public function getName($columnName, $delimiter)
    {
        $columnText = "";
        $arrayColumnName = explode('_', $columnName);
        /* get text */
        foreach ($arrayColumnName as $value) {
            $columnText .= ucwords($value) .$delimiter;
        }
        return trim($columnText, $delimiter);
    }

    /**
     * Writes content in file.
     *
     * @param $filePath
     * @param $content
     */
    public function dumpFile($filePath, $content)
    {
        $fs = new Filesystem();

        try {
            $fs->dumpFile($this->getPath() . $filePath, $content);
        }
        catch (IOException $err) {
            throw new \RuntimeException("Error on the file creation: ".$err->getPath());
        }
    }

    /**
     * Get information from table on database
     *
     * @param $tableName
     * @return mixed
     */
    public function getTableInformation ($tableName)
    {
        $query  = "SELECT column_name, data_type, udt_name, character_maximum_length, is_nullable ";
        $query .= "FROM information_schema.columns ";
        $query .= "WHERE table_name = '". $tableName ."';";
        /* return query result */
        return $this->em->getConnection()->fetchAll($query);
    }

    /**
     * Get real Path from proyect.
     *
     * @return string
     */
    public function getPath()
    {
        return realpath(dirname($this->container->getParameter('kernel.root_dir')));
    }

    /**
     * Get first part name from bundle.
     *
     * @param $bundle
     * @return string
     */
    public function getBundleName($bundle)
    {
        return strtolower(substr($bundle, 0, -6));
    }

    /**
     * Is foreign key the column name.
     *
     * @param $columnName
     * @return bool
     */
    public function isForeignKey($columnName)
    {
        if (substr($columnName, -3) === '_id') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get entity name by foreign key => person_id.
     *
     * @param $columnName
     * @return bool
     */
    public function getEntityName($columnName)
    {
        if (substr($columnName, -3) === '_id') {
            return $this->getName(substr($columnName, 0, -3), "");
        } else {
            return $this->getName($columnName, "");
        }
    }

    /**
     * Finder file in some directory.
     *
     * @param $fileName
     * @param $path
     *
     * @return bool|string
     */
    public function finder($fileName, $path)
    {
        $finder = new Finder();

        $finder->name('*'. $fileName .'*');
        $finder->files()->in(realpath($this->getPath() . $path));

        foreach ($finder as $file)
        {
            return $file->getRelativePathname();
        }

        return false;
    }

    /**
     * Get the bundle name by some file.
     *
     * @param $fileName
     * @param $path
     *
     * @return bool|string
     */
    public function getBundleByFileName($fileName, $path)
    {
        $explode = explode('\\', $this->finder($fileName, $path));

        foreach ($explode as $dir) {
            if (substr($dir, -6) === 'Bundle') {
                return $dir;
            }
        }
        return false;
    }
}