<?php

$configuration->LoyalDestinationGroup = $_POST["LoyalDestinationGroup"];
$configuration->LoyalOriginGroup = $_POST["LoyalOriginGroup"];
$configuration->LoyalMinNrOrders = $_POST["LoyalMinNrOrders"];
$configuration->LoyalMinNrItems = $_POST["LoyalMinNrItems"];
$configuration->LoyalMinAmount = $_POST["LoyalMinAmount"];
$configuration->LoyalDays = $_POST["LoyalDays"];
$configuration->LoyalCanFallBack = $_POST["LoyalCanFallBack"];
$configuration->LoyalFallBackDays = $_POST["LoyalFallBackDays"];
$configuration->LoyalEmail = $_POST["LoyalEmail"];
$configuration->LoyalFallBackEmail = $_POST["LoyalFallBackEmail"];
$configuration->LoyalWarningDays = $_POST["LoyalWarningDays"];
$configuration->LoyalWarningEmail = $_POST["LoyalWarningEmail"];

?>