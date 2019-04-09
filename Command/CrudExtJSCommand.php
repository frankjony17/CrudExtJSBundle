<?php

namespace CrudExtJSBundle\Command;

use CrudExtJSBundle\Services\Generator;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrudExtJSCommand extends GeneratorCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('generate:extjs:crud')
            ->setDescription('Generate CRUD with ExtJS library. frank.ricardo@etecsa.cu')
            ->setDefinition(array(
                new InputOption('table-name', '', InputOption::VALUE_REQUIRED, 'Name from Table on database'),
                new InputOption('name-application', '', InputOption::VALUE_REQUIRED, 'The name of your application.'),
                new InputOption('bundle', '', InputOption::VALUE_REQUIRED, 'Bundle to generate the Controller')
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tableName = $input->getOption('table-name');
        $appName = $input->getOption('name-application');
        $bundle = $input->getOption('bundle');

        if (is_numeric($tableName)) {
            $output->write('The generator fail because the table have more 20 columns.');
            $output->write('This generator only can .');
        }
        /* Get service Generator */
        $generator = $this->getContainer()->get('crud_ext_js.generator');
        /* Generate CRUD */
        $generator->generateExtjsCrud($bundle, $appName, $tableName);
    }

    /**
     * Validate console input parameters.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $validator = $this->getContainer()->get('crud_ext_js.validator');
        $questionHelper = $this->getQuestionHelper();
        $questionHelper->writeSection($output, 'Welcome to the ExtJS CRUD generator!');
        /* table-name option */
        $validator->validateTableName($input, $output, $questionHelper);
        /* name-application option */
        $validator->validateApplicationName($input, $output, $questionHelper);
        /* bundle option */
        $validator->validateBundle($input, $output, $questionHelper, $this->getContainer()->getParameter('kernel.bundles'));
    }

    protected function createGenerator()
    {
        // TODO: Implement createGenerator() method.
    }
}
