<?php

declare(strict_types=1);

namespace Training\ImportCustomers\Console\Command;

use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Console\Cli;
use Magento\Framework\Filesystem;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Training\ImportCustomers\Model\CustomerCsv;
use Training\ImportCustomers\Model\CustomerJson;

Class Import extends Command
{
    private $filesystem;
    private $customer;
    private $customerjson;
    private $state;
    protected $dir;

    const INPUT_FILE = 'file';
    
    public function __construct(
        Filesystem $filesystem,
        CustomerCsv $custCsv,
        CustomerJson $custJson,
        State $state,
        \Magento\Framework\Filesystem\Io\File $filesystemIo,
        \Magento\Framework\Filesystem\DirectoryList $dir
    ) {
    parent::__construct();
        $this->filesystem = $filesystem;
        $this->custCsv = $custCsv;
        $this->custJson = $custJson;
        $this->state = $state;
        $this->filesystemIo = $filesystemIo;
        $this->dir = $dir;
    }

    protected function configure(){
        parent::configure();
        
        $this->setName('customer:importer');
        $this->setDescription('Customer Import Example');
        $this->addOption(
            'profile',
            null,
            InputOption::VALUE_REQUIRED,
            'PROFILE'
        );
        $this->addArgument(
            self::INPUT_FILE,
            InputArgument::REQUIRED,
            'description'
        );
    }
    protected function execute(InputInterface $input, OutputInterface $output){
        try {
            $filename = $input->getArgument(self::INPUT_FILE); // source file
            $format = $input->getOption('profile');
            $pathParts = pathinfo($filename);
                if(($format !== 'csv' && $format !=='json' ) || $pathParts['extension'] !== $format){
                    $output->writeln('<info>Provide Valid format.</info>'); exit;
                }
            $copyFileFullPath = $this->dir->getPath('var'). '/fixtures/customers.'. $format; // destination file
            $this->filesystemIo->cp($filename, $copyFileFullPath);
            $this->state->setAreaCode(Area::AREA_GLOBAL);
                if($format === 'json'){
                    $this->custJson->install($copyFileFullPath);
                }
                if($format === 'csv'){
                    $this->custCsv->install($copyFileFullPath);
                }
            $output->writeln('<info>Customers Data Created Successfully</info>');
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $output->writeln("<error>$msg</error>", OutputInterface::OUTPUT_NORMAL);
            return Cli::RETURN_FAILURE;
        }
    }
    
}
