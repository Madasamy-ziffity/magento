<?php
namespace Training\ImportCustomers\Console\Command\Import;

/**
 * Interceptor class for @see \Training\ImportCustomers\Console\Command\Import
 */
class Interceptor extends \Training\ImportCustomers\Console\Command\Import implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Filesystem $filesystem, \Training\ImportCustomers\Model\CustomerCsv $custCsv, \Training\ImportCustomers\Model\CustomerJson $custJson, \Magento\Framework\App\State $state, \Magento\Framework\Filesystem\Io\File $filesystemIo)
    {
        $this->___init();
        parent::__construct($filesystem, $custCsv, $custJson, $state, $filesystemIo);
    }

    /**
     * {@inheritdoc}
     */
    public function run(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'run');
        return $pluginInfo ? $this->___callPlugins('run', func_get_args(), $pluginInfo) : parent::run($input, $output);
    }
}
