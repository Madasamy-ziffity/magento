<?php
declare(strict_types=1);
namespace Training\DependencyExample\Model;

Class NonInjectable
{
    public function getId():string
    {
        return 'Class Non Injectable';
    }
}
