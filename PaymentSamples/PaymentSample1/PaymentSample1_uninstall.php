<?php

/* This is a sample payment method.
   uninstall
*/   

// remove the fucntion overrides
RemoveFunctionOverride("PaymentSample1_SendData", "PaymentImplementationCustom", "SendData");
RemoveFunctionOverride("PaymentSample1_UpdateOnSuccess", "PaymentImplementationCustom", "UpdateStatusOnSuccess");
RemoveFunctionOverride("PaymentSample1_UpdateOnFailed", "PaymentImplementationCustom", "UpdateStatusOnFailed");
RemoveFunctionOverride("PaymentSample1_UpdateOnProcessing", "PaymentImplementationCustom", "UpdateStatusOnProcessing");
// remove the display overrides
RemoveMvcEvent("PaymentSample1_Show", "PaymentSample1", "Show");
RemoveMvcEvent("PaymentSample1_MakeTransaction", "PaymentSample1", "Success");

// remove the payment method
$methodFound = $website->FindPaymentMethod("code", "Sample1");
if ($methodFound!=null)
{
	$website->DeletePaymentMethod($methodFound->Id);
}



?>