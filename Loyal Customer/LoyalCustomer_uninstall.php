<?php

/* This is the uninstall script for the Loyal customer extension
*/   

// remove the function overrides
RemoveFunctionOverride("SaveLoyalCustomerConfigData", "MvcAdmin", "OnSaveAdditionalConfiguration");
RemoveFunctionOverride("CheckLoyalCustomerChanges", "MvcCron", "OnHourlyCron");

customTableDeleteField("Configuration", "LoyalDestinationGroup", true);
customTableDeleteField("Configuration", "LoyalOriginGroup", true);
customTableDeleteField("Configuration", "LoyalMinNrOrders", true);
customTableDeleteField("Configuration", "LoyalMinNrItems", true);
customTableDeleteField("Configuration", "LoyalMinAmount", true);
customTableDeleteField("Configuration", "LoyalDays", true);
customTableDeleteField("Configuration", "LoyalCanFallBack", true);
customTableDeleteField("Configuration", "LoyalFallBackDays", true);
customTableDeleteField("Configuration", "LoyalEmail", true);
customTableDeleteField("Configuration", "LoyalFallBackEmail", true);
customTableDeleteField("Configuration", "LoyalWarningDays", true);
customTableDeleteField("Configuration", "LoyalWarningEmail", true);

$loyalEMailTemplate = $website->FindEMailConfiguration("Name", "LoyalCustomerNow");
if ($loyalEMailTemplate!=null)
	$website->DeleteEMailConfiguration($loyalEMailTemplate->Id);

$loyalEMailTemplate = $website->FindEMailConfiguration("Name", "NoLongerLoyalCustomer");
if ($loyalEMailTemplate!=null)
	$website->DeleteEMailConfiguration($loyalEMailTemplate->Id);

$loyalEMailTemplate = $website->FindEMailConfiguration("Name", "AboutToLoseLoyalCustomerPrivileges");
if ($loyalEMailTemplate!=null)
	$website->DeleteEMailConfiguration($loyalEMailTemplate->Id);

echo "Extension 'Loyal customers' is not uninstalled. The settings and email templates are removed. The customer group 'Loyal customers' is not removed.";

?>
