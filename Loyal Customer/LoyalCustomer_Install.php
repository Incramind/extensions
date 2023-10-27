<?php

/* This is an extension for loyal customers.
   When a certain amount of orders is reached a customer will automatically be placed into another customer group.
   In this way, he can enjoy some extra discount or other things. 
*/   


setFunctionOverride("SaveLoyalCustomerConfigData", "MvcAdmin", "OnSaveAdditionalConfiguration", 0);
setFunctionOverride("CheckLoyalCustomerChanges", "MvcCron", "OnHourlyCron", 0);

// create the Loyal customer group if it did not yet exist

$defGroup = $website->FindCustomerGroup("IsDefault", true);
$group = $website->FindCustomerGroup("code", "Loyal Customers");
if ($group==null)
{
    $group = new CustomerGroup();
    $group->Code = "Loyal Customers";
    // find the default customer group, to copy the tax class
    if ($defGroup!=null)
    	$group->TaxClass = $defGroup->TaxClass;
    $website->AddCustomerGroup($group);
}

// expand the database
customTableAddField("Configuration", "LoyalCustomerEnabled",  ReplacerType_Boolean, "A boolean flag describing if the loyal customer functionality is enabled, if not checked no emails are sent, and no customers are changed.");
customTableAddField("Configuration", "LoyalDestinationGroup",  ReplacerType_Integer, "The group to with the customer is changed if loyal.");
customTableAddField("Configuration", "LoyalOriginGroup",  ReplacerType_Integer, "The group from with the customer can be moved to loyal.");
customTableAddField("Configuration", "LoyalMinNrOrders",  ReplacerType_Integer, "The minimum number of orders to become a loyal customer.");
customTableAddField("Configuration", "LoyalMinNrItems",  ReplacerType_Integer, "The minimum number of otems (products bought) to become a loyal customer.");
customTableAddField("Configuration", "LoyalMinAmount",  ReplacerType_Numeric, "The minimum total amount in the orders to become a loyal customer.");
customTableAddField("Configuration", "LoyalDays",  ReplacerType_Integer, "The number of days to get the amount and number of orders.");
customTableAddField("Configuration", "LoyalCanFallBack",  ReplacerType_Boolean, "If it is possible to fall back from Loyal Cyustomer to regular customer.");
customTableAddField("Configuration", "LoyalFallBackDays",  ReplacerType_Integer, "The number of days to fall back to the default customer group, when no longer criteria are met.");
customTableAddField("Configuration", "LoyalEmail",  ReplacerType_String, "The email that is sent when the customer becomes a loyal customer.");
customTableAddField("Configuration", "LoyalFallBackEmail",  ReplacerType_String, "The email that is sent when the customer falls back to a regular customer.");
customTableAddField("Configuration", "LoyalWarningDays",  ReplacerType_Integer, "The number of days before a warning is sent that the customer is abpout to fall back.");
customTableAddField("Configuration", "LoyalWarningEmail",  ReplacerType_String, "The email that is sent when the customer is about to fall back to regular customer.");

// fill with some values
$configuration->LoyalDestinationGroup = $group->Id;
if ($defGroup!=null)
   $configuration->LoyalOriginGroup = $defGroup->Id;
$configuration->LoyalMinNrOrders = 2;
$configuration->LoyalMinNrItems = 3;
$configuration->LoyalMinAmount = 100;
$configuration->LoyalDays = 60;
$configuration->LoyalCanFallBack = true;
$configuration->LoyalFallBackDays = 30;
$configuration->LoyalEmail = "LoyalCustomerNow";
$configuration->LoyalFallBackEmail = "NoLongerLoyalCustomer";
$configuration->LoyalWarningDays = 7;
$configuration->LoyalWarningEmail = "AboutToLoseLoyalCustomerPrivileges";

// create some email templates if not exist yet
$loyalEMailTemplate = $website->FindEMailConfiguration("Name", "LoyalCustomerNow");
if ($loyalEMailTemplate==null)
{
   $loyalEMailTemplate = new EMailConfig();
   $loyalEMailTemplate->Type = EMailType_Custom;
   $loyalEMailTemplate->Name = "LoyalCustomerNow";
   $loyalEMailTemplate->Subject = "Congratulations, You are a loyal customer now.";
   $loyalEMailTemplate->SendTo = "[customer.email]";
   $loyalEMailTemplate->BodyBlock = "Dear [Customer.FullName],<br/><br/>We have upgraded you as a loyal customer, because of the recent purchases.<br/>You can now enjoy special discounts and Privileges.<br><br/>With kind regard the [Website.Name] team.<br/>";
   $loyalEMailTemplate->Enabled = true;
   $loyalEMailTemplate->OriginatorAddress = "[Configuration.StoreInfoMainSender]";
   $website->AddEMailConfiguration($loyalEMailTemplate);
}

$loyalEMailTemplate = $website->FindEMailConfiguration("Name", "NoLongerLoyalCustomer");
if ($loyalEMailTemplate==null)
{
   $loyalEMailTemplate = new EMailConfig();
   $loyalEMailTemplate->Type = EMailType_Custom;
   $loyalEMailTemplate->Name = "NoLongerLoyalCustomer";
   $loyalEMailTemplate->Subject = "You are no longer a loyal customer.";
   $loyalEMailTemplate->SendTo = "[customer.email]";
   $loyalEMailTemplate->BodyBlock = "Dear [Customer.FullName],<br/><br/>Due to lack of usage of our website, you are no longer a loyal customer, and have lost special priveledges.<br><br/>Shop in out store to restore your special privileges.<br/>";
   $loyalEMailTemplate->Enabled = true;
   $loyalEMailTemplate->OriginatorAddress = "[Configuration.StoreInfoMainSender]";
   $website->AddEMailConfiguration($loyalEMailTemplate);
}

$loyalEMailTemplate = $website->FindEMailConfiguration("Name", "AboutToLoseLoyalCustomerPrivileges");
if ($loyalEMailTemplate==null)
{
   $loyalEMailTemplate = new EMailConfig();
   $loyalEMailTemplate->Type = EMailType_Custom;
   $loyalEMailTemplate->Name = "AboutToLoseLoyalCustomerPrivileges";
   $loyalEMailTemplate->Subject = "About to lose special privileges.";
   $loyalEMailTemplate->SendTo = "[customer.email]";
   $loyalEMailTemplate->BodyBlock = "Dear [Customer.FullName],<br/><br/>You are about o lose your special privileges on our website, because of a lack of recent purchases. If you wish to continue to have these priviledges make a purchase soon.<br/>The coming days you can still enjoy our special discounts and priveleges.<br><br/>With kind regard the [Website.Name] team.<br/>";
   $loyalEMailTemplate->Enabled = true;
   $loyalEMailTemplate->OriginatorAddress = "[Configuration.StoreInfoMainSender]";
   $website->AddEMailConfiguration($loyalEMailTemplate);
}


echo "Loyal customer extension installed.";
?>
