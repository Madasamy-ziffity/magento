<?php
declare(strict_types=1);
namespace Training\Knockout\Block;

use Magento\Framework\View\Element\Template;
use Training\DependencyExample\Model\Main;

class Index extends Template

{
    Protected Main $main;
    public function __construct(Template\Context $context,Main $main, array $data = [])
    {
        parent::__construct($context, $data);
        $this->main = $main;
    }
    public function getMain() : Main
    {
        return $this->main;
    }
}