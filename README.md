ZendSkeletonApplication
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

Using Git submodules
--------------------
Alternatively, you can install using native git submodules:

    git clone git://github.com/zendframework/ZendSkeletonApplication.git --recursive

Creating database scheme
------------------------
If you've installed doctrine from within this composer file, you've to change "vendor/doctrine/orm/bin/doctrine.php" on line on line 28:

   $configFile = getcwd() . DIRECTORY_SEPARATOR . 'config'. DIRECTORY_SEPARATOR .'doctrine'. DIRECTORY_SEPARATOR .'cli-config.php';

After that you can create the database scheme:

    php vendor/doctrine/orm/bin/doctrine orm:schema-tool:create

Maybe vou've to change the connectionsettings in bootstrap_config.php and bootstrap_doctrine.php:

// database configuration parameters
$conn = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'zfdoctrine2',
    'user'     => 'test',
    'password' => 'test'
);


Virtual Host
------------
Afterwards, set up a virtual host to point to the public/ directory of the
project and you should be ready to go!

<VirtualHost *:80>
	ServerName skeleton.local
	DocumentRoot "/var/www/skeleton/public/"
	
	<Directory "/var/www/skeleton/public">
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

</VirtualHost>
