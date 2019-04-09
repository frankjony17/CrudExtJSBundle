<?php

namespace CrudExtJSBundle\Services;

use Symfony\Component\Console\Question\Question;

/**
 * Validator functions.
 *
 * @author Frank Ricardo R <frank.ricardo@etecsa.cu>
 */
class Validators
{
    private $em;

    function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Validate table name from database.
     *
     * @param $input
     * @param $output
     * @param $questionHelper
     */
    public function validateApplicationName ($input, $output, $questionHelper)
    {
        $appName = $input->getOption('name-application');

        $output->writeln(array(
            '',
            'The name of your application.',
            'This will also be the namespace for your views, controllers models and stores.',
            'Don\'t use spaces or special characters in the name. Application name is mandatory',
            '',
        ));
        $question = new Question($questionHelper->getQuestion(
            'Name of your application',
            $appName
        ), $appName);
        /* Do while the table name is not correct */
        do {
            $appName = $questionHelper->ask($input, $output, $question);
            $isValid = $this->isValidApplicationName($appName);
        } while (!$isValid);
        /* Set table-name value */
        $input->setOption('name-application', $isValid);
    }

    /**
     * Validate table name from database.
     *
     * @param $input
     * @param $output
     * @param $questionHelper
     */
    public function validateTableName ($input, $output, $questionHelper)
    {
        $tableName = $input->getOption('table-name');

        $output->writeln(array(
            '',
            'The table name is used for generate js file "grid.js, form.js, controller.js or store.js"',
            'enter a correct table name from database!',
            '',
        ));
        $question = new Question($questionHelper->getQuestion(
            'Table name from database',
            $tableName
        ), $tableName);
        /* Do while the table name is not correct */
        do {
            $tableName = $questionHelper->ask($input, $output, $question);
            $isValid = $this->isValidTableName($tableName);
        } while (!$isValid);
        /* Set table-name value */
        $input->setOption('table-name', $isValid);
    }

    /**
     * Validate Bundle.
     *
     * @param $input
     * @param $output
     * @param $questionHelper
     * @param $bundles
     */
    public function validateBundle($input, $output, $questionHelper, $bundles)
    {
        $bundle = $input->getOption('bundle');

        $output->writeln(array(
            '',
            'Bundle for save the Controller file',
            'enter a correct Bundle name!',
            '',
        ));
        $question = new Question($questionHelper->getQuestion(
            'Existent Bundle',
            $bundle
        ), $bundle);
        /* Do while the path is not correct */
        do {
            $bundle = $questionHelper->ask($input, $output, $question);
        } while (!$this->isBundle($bundle, $bundles));
        /* Set table-name value */
        $input->setOption('bundle', $bundle);
    }

    /**
     * Find table name on database.
     * @param $tableName
     * @return bool
     */
    private function isValidTableName($tableName)
    {
        if (!$tableName) {
            throw new \RuntimeException('Please enter a table name.');
        }
        $tableName = $this->em->getConnection()->fetchAll("SELECT DISTINCT table_name, column_name FROM information_schema.columns WHERE table_name = '$tableName'");

        if (count($tableName) > 0) {
            if (count($tableName) <= 21) {
                return strtolower($tableName[0]['table_name']);
            } else {
                return count($tableName);
            }
        } else {
            return false;
        }
    }

    /**
     * Exist Bundle?
     *
     * @param $name
     * @param $bundles
     * @return bool
     */
    private function isBundle($name, $bundles)
    {
        if (array_key_exists($name, $bundles)) {
            return true;
        }
        return false;
    }


    private function isValidApplicationName($appName)
    {
        $count = 0;
        $appName = strtolower($appName);
        $characters = array('q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm');
        /* Character is valid? */
        foreach (str_split($appName) as $char) {
            if (in_array($char, $characters)) {
                $count++;
            } else {
                $count--;
            }
        }
        /* Count->appName = Count->count. All character from $appName are valid */
        if ($count === count(str_split($appName))) {
            return strtoupper($appName);
        } else {
            return false;
        }
    }
}
