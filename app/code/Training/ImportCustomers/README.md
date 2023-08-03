## Synopsis

This module is to help to import the customer data into the Magento application using CLI command. We can  handle import CSV or JSON format data.
This module to support importing from other sources in the future.


## Motivation

The intent is to save time from manual customer creation process.

## Installation

"repositories": [
        {
            "type": "clone",
            "url": "https://github.com/Madasamy-ziffity/magento/tree/assessment/app/code/Training/ImportCustomers"
        }
    ]

The above can also be added using the git clone line with the command: 

git clone https://github.com/Madasamy-ziffity/magento/tree/assessment/app/code/Training/ImportCustomers


### Registration

New in Magento 2 is the ability to *register* modules to install anywhere under the Magento root directory;


All sample modules have a `registration.php` in their root directory with contents similar to the following:


<?php
\Magento\Framework\Component\ComponentRegistrar::register(
\Magento\Framework\Component\ComponentRegistrar::MODULE,
'Training_ImportCustomers',
__DIR__
);


In addition, each module's `composer.json` references `registration.php` in its `autoload` section as follows:


{
    "name": "training/importcustomers",
    "description": "A module that creates a customers data either csv or json format",
    "type": "magento2-module",
    "version": "1.0.0",
    "license": [
      "OSL-3.0",
      "AFL-3.0"
    ],
    "require": {
      "php": "~7.2.0||~7.4.3"
    },
    "autoload": {
      "files": [ "registration.php" ],
      "psr-4": {
        "Training\\ImportCustomers\\": ""
      }
    }
  }


### PSR-4 section


Each module's `composer.json` has a [`psr-4`](https://getcomposer.org/doc/04-schema.md#psr-4) section *except* for `sample-module-theme`. Themes don't require it because they do not reference

### Tests

Test command in the following

sudo bin/magento customer:importer --profile='csv' /home/z0411@ad.ziffity.com/Downloads/sample.csv

sudo bin/magento customer:importer --profile='json' /home/z0411@ad.ziffity.com/Downloads/sample.json





