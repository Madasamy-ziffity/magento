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
use Training\ImportCustomers\Model\Customer;
use Training\ImportCustomers\Model\CustomerJson;
Class Import extends Command
{
    private $filesystem;
    private $customer;
    private $customerjson;
    private $state;

    const INPUT_FILE = 'file';
    
    public function __construct(
        Filesystem $filesystem,
        Customer $customer,
        CustomerJson $customerjson,
        State $state,
        \Magento\Framework\Filesystem\Io\File $filesystemIo
    ) {
    parent::__construct();
        $this->filesystem = $filesystem;
        $this->customer = $customer;
        $this->customerjson = $customerjson;
        $this->state = $state;
        $this->filesystemIo = $filesystemIo;
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

            $filename = $input->getArgument(self::INPUT_FILE);

            $format = $input->getOption('profile');

            $path_parts = pathinfo($filename);

            // validate the option
            if(($format != 'csv' && $format !='json' ) || $path_parts['extension'] != $format){
                $output->writeln('<info>Provide Valid format.</info>'); exit;
            }

            $filePath  = $filename;//source file

            $mediaDir = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);

            $copyFileFullPath = $mediaDir->getAbsolutePath() . 'fixtures/customers.'. $format; // destination file

            $fileLoca = $this->filesystemIo->cp($filePath, $copyFileFullPath);  // copy the file into temporary path

            $this->state->setAreaCode(Area::AREA_GLOBAL);

            if($format == 'json'){   // json format imported
                       
                $this->customerjson->install($copyFileFullPath, $output);
            }
            
           if($format == 'csv'){  // csv format imported
                
                $this->customer->install($copyFileFullPath, $output);
            }
            
            $output->writeln('<info>Customers Data Created Successfully</info>');
            return Cli::RETURN_SUCCESS;

        } catch (Exception $e) {
            $msg = $e->getMessage();
            $output->writeln("<error>$msg</error>", OutputInterface::OUTPUT_NORMAL);
            return Cli::RETURN_FAILURE;
        }
    }
    
}
