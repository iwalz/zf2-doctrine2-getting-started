<?php
// bootstrap.php
require_once "doctrinecomponents/entities/User.php";
require_once "doctrinecomponents/entities/Product.php";
require_once "doctrinecomponents/entities/Bug.php";

if (!class_exists("Doctrine\Common\Version", false)) {
    require_once "bootstrap_doctrine.php";
}

require_once "doctrinecomponents/repositories/BugRepository.php";
