ZF2 Skeleton & Doctrine2 Getting Started
=======================

Introduction
------------
This is a fork of the ZF2 Skeleton application.
It combines this project with the getting started tutorial of doctrine2, available under http://docs.doctrine-project.org/projects/doctrine-orm/en/2.1/tutorials/getting-started-xml-edition.html .



Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use composer to install dependencies:

    cd my/project/dir
    git clone git://github.com/zendframework/ZendSkeletonApplication.git
    cd ZendSkeletonApplication
    php composer.phar install

Creating database scheme
------------------------
If you've installed doctrine from within this composer file, you've to change "vendor/bin/doctrine.php" on line on line 28:
```php
   $configFile = getcwd() . DIRECTORY_SEPARATOR . 
   		'config'. DIRECTORY_SEPARATOR .
   		'doctrine'. DIRECTORY_SEPARATOR .'cli-config.php';
```
After that you can create the database scheme:

    php vendor/bin/doctrine orm:schema-tool:create

Maybe vou've to change the connectionsettings in bootstrap_config.php and bootstrap_doctrine.php:
```php
// database configuration parameters
$conn = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'zfdoctrine2',
    'user'     => 'test',
    'password' => 'test'
);
```

Generating Proxy files
----------------------
To re-generate the proxy files based on the module configuration, you've to run:

    php vendor/bin/doctrine orm:generate-proxies data/DoctrineORMModule/Proxy

Configuring the doctrine module
-------------------------------
For the current project, the module.config.php from "vendor/doctrine/doctrine-orm-module/config/module.config.php" has to look like this:

```php
<?php
return array(
    'doctrine' => array(
        'orm_autoload_annotations' => true,

        'connection' => array(
            'orm_default' => array(
                'configuration' => 'orm_default',
                'eventmanager'  => 'orm_default',

                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'test',
                    'password' => 'test',
                    'dbname'   => 'zfdoctrine2',
                )
            ),
        ),

        'configuration' => array(
            'orm_default' => array(
                'metadata_cache'    => 'array',
                'query_cache'       => 'array',
                'result_cache'      => 'array',

                'driver'            => 'orm_default',

                'generate_proxies'  => false,
                'proxy_dir'         => realpath(__DIR__.'/../../../../data/DoctrineORMModule/Proxy'),
                'proxy_namespace'   => 'DoctrineProxies'
            )
        ),

        'driver' => array(
            'orm_default' => array(
                'class'   => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => array(__DIR__.'/../../../../config/doctrine/xml')
            )
        ),

        'entitymanager' => array(
            'orm_default' => array(
                'connection'    => 'orm_default',
                'configuration' => 'orm_default'
            )
        ),

        'eventmanager' => array(
            'orm_default' => array()
        ),

        'sql_logger_collector' => array(
            'orm_default' => array(),
        ),

        'entity_resolver' => array(
            'orm_default' => array()
        )
    ),

    // zendframework/zend-developer-tools specific settings

    'view_manager' => array(
        'template_map' => array(
            'zend-developer-tools/toolbar/doctrine-orm' => __DIR__ . '/../view/zend-developer-tools/toolbar/doctrine-orm.phtml',
        ),
    ),

    'zenddevelopertools' => array(
        'profiler' => array(
            'collectors' => array(
                'orm_default' => 'doctrine.sql_logger_collector.orm_default',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'orm_default' => 'zend-developer-tools/toolbar/doctrine-orm',
            ),
        ),
    ),
);

```

Initialize ZendDeveloperTools Toolbar
-------------------------------------
Copy "vendor/zendframework/zend-developer-tools/config/zenddevelopertools.local.php.dist" to "config/autoload/" directory

Virtual Host
------------
Afterwards, set up a virtual host to point to the public/ directory of the
project and you should be ready to go!
```xml
<VirtualHost *:80>
	ServerName skeleton.local
	DocumentRoot "/var/www/skeleton/public/"
	
	<Directory "/var/www/skeleton/public">
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

</VirtualHost>
```
