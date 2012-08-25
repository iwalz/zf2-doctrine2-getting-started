<?php
// bootstrap.php
require_once __DIR__."/../../module/Application/Entity/User.php";
require_once __DIR__."/../../module/Application/Entity/Product.php";
require_once __DIR__."/../../module/Application/Entity/Bug.php";

if (!class_exists("Doctrine\Common\Version", false)) {
    require_once "bootstrap_doctrine.php";
}

require_once "doctrinecomponents/repositories/BugRepository.php";
