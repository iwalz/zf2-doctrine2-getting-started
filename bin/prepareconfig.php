<?php
#setup doctrine cli
$doctrineBinDir = realpath('vendor/doctrine/orm/bin/');
$doctrineBin = $doctrineBinDir . '/doctrine.php';
$doctrineBinString = "\$configFile = getcwd() . DIRECTORY_SEPARATOR . 'config/doctrine/cli-config.php';" . PHP_EOL;

if(is_writable($doctrineBin))
{
    $content = file_get_contents($doctrineBin);
    $newContent = preg_replace('/\$configFile\s+=\s+.*?;/', $doctrineBinString, $content);
    file_put_contents($doctrineBin, $newContent);
    
    echo $doctrineBin . " reconfigured for CLI usage" . PHP_EOL;
} else {
    die($doctrineBin . " is not writeable - exit");
}

#setup doctrine initialization
$doctrineOrmConfigDir = realpath('vendor/doctrine/doctrine-orm-module/config/');
$doctrineOrmTemplate = realpath('config/doctrine/module.config.php.dist');
if(is_writable($doctrineOrmConfigDir))
{
    if(copy($doctrineOrmTemplate, $doctrineOrmConfigDir . '/module.config.php'))
        echo "Configured doctrine module" . PHP_EOL;
} else {
    die($doctrineOrmConfigDir . " is not writeable - exit");
}

#setup ZendDeveloperTools
$zdevtoolsTemplateDir = realpath('vendor/zendframework/zend-developer-tools/config/');
$zdevtoolsTemplate = $zdevtoolsTemplateDir . '/zenddevelopertools.local.php.dist';

if(copy($zdevtoolsTemplate, 'config/autoload/zenddevelopertools.local.php'))
    echo "ZendDeveloperTools configured" . PHP_EOL;