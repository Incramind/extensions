<?php

/* This is a sample payment method.
   It can be used to implement any payment provider that uses a webbhook to come up with the result.
   There are other samples for simpler payment methods.	
*/   

$customProcessor = $main->FindPaymentProcessor("code", "Custom");
if ($customProcessor==null)
{
	echo "No custom payment processor found, could not install payment method";
}
else
{
	$methodFound = $website->FindPaymentMethod("code", "Sample3");
	if ($methodFound==null)
	{
		$method = new PaymentMethod();
		$method->Code = "Sample3";
		$method->Name = "Sample payment provider with webhook and selection";
		$method->PaymentInformation = "A test implementation that shows a screen for selecting if a payment failes, succeeds or still processing";
		$method->NoteToCustomer = "No actual payment will be made!";
		$method->Enabled = true;
		$method->PaymentProcessor = $customProcessor;

		$website->AddPaymentMethod($method);
		$methodFound = $method;
	}

    // override two pages that we need to show the selection, and a ajax page to create a transaction on the server	
	SetMvcEvent("PaymentSample3_Show", "PaymentSample3", "Show");
	SetMvcEvent("PaymentSample3_MakeTransaction", "PaymentSample3", "makeTransaction");
	SetMvcEvent("PaymentSample3_Actions", "PaymentSample3", "actions");
	

    // override the specific functions for our customer behaviour
	setFunctionOverride("PaymentSample3_SendData", "PaymentImplementationCustom", "SendData", $methodFound->Id);
	setFunctionOverride("PaymentSample3_UpdateOnSuccess", "PaymentImplementationCustom", "UpdateStatusOnSuccess", $methodFound->Id);
	setFunctionOverride("PaymentSample3_UpdateOnFailed", "PaymentImplementationCustom", "UpdateStatusOnFailed", $methodFound->Id);
	setFunctionOverride("PaymentSample3_UpdateOnProcessing", "PaymentImplementationCustom", "UpdateStatusOnProcessing", $methodFound->Id);
	setFunctionOverride("PaymentSample3_GetStatusUpdate", "PaymentImplementationCustom", "GetStatusUpdate", $methodFound->Id);
	setFunctionOverride("PaymentSample3_GetWebhookReturn", "PaymentImplementationCustom", "GetWebhookReturn", $methodFound->Id);
}

echo "Sample payment 3 is now installed";
?>
