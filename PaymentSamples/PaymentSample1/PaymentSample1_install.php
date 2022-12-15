<?php

/* This is a sample payment method.
   It can be used to implement any payment provider that does something and then resurns the result.
   There is also a sample that shows how to implement a payment provider that uses a webhook
*/   

$customProcessor = $main->FindPaymentProcessor("code", "Custom");
if ($customProcessor==null)
{
	echo "No custom payment processor found, could not install payment method";
}
else
{
	$methodFound = $website->FindPaymentMethod("code", "Sample1");
	if ($methodFound==null)
	{
		$method = new PaymentMethod();
		$method->Code = "Sample1";
		$method->Name = "Sample payment provider with selection page";
		$method->PaymentInformation = "A test implementation that shows a screen for selecting if a payment failes, succeeds or still processing";
		$method->NoteToCustomer = "No actual payment will be made!";
		$method->Enabled = true;
		$method->PaymentProcessor = $customProcessor;

		$website->AddPaymentMethod($method);
		$methodFound = $method;
	}

    // override two pages that we need to show the selection, and a ajax page to create a transaction on the server	
	SetMvcEvent("PaymentSample1_Show", "PaymentSample1", "Show");
	SetMvcEvent("PaymentSample1_MakeTransaction", "PaymentSample1", "makeTransaction");

    // override the specific functions for our customer behaviour
	setFunctionOverride("PaymentSample1_SendData", "PaymentImplementationCustom", "SendData", $methodFound->Id);
	setFunctionOverride("PaymentSample1_UpdateOnSuccess", "PaymentImplementationCustom", "UpdateStatusOnSuccess", $methodFound->Id);
	setFunctionOverride("PaymentSample1_UpdateOnFailed", "PaymentImplementationCustom", "UpdateStatusOnFailed", $methodFound->Id);
	setFunctionOverride("PaymentSample1_UpdateOnProcessing", "PaymentImplementationCustom", "UpdateStatusOnProcessing", $methodFound->Id);
	setFunctionOverride("PaymentSample1_GetStatusUpdate", "PaymentImplementationCustom", "GetStatusUpdate", $methodFound->Id);
}

echo "Sample payment 1 is now installed";
?>
