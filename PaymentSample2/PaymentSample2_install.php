<?php

/* This is a sample payment method.
   It can be used to implement any payment provider that gives a direct result.
   There is also a sample that shows how to implement a payment provider that uses a webhook
*/   

$customProcessor = $main->FindPaymentProcessor("code", "Custom");
if ($customProcessor==null)
{
	echo "No custom payment processor found, could not install payment method";
}
else
{
	$methodFound = $website->FindPaymentMethod("code", "Sample2");
	if ($methodFound==null)
	{
		$method = new PaymentMethod();
		$method->Code = "Sample2";
		$method->Name = "Sample payment provider direct approve";
		$method->PaymentInformation = "A test implementation that directly approves each order (like cash payments)";
		$method->NoteToCustomer = "No actual payment will be made!";
		$method->Enabled = true;
		$method->PaymentProcessor = $customProcessor;

		$website->AddPaymentMethod($method);
		$methodFound = $method;
	}

    // override the specific functions for our customer behaviour
	setFunctionOverride("PaymentSample2_SendData", "PaymentImplementationCustom", "SendData", $methodFound->Id);
}

echo "Sample payment 2 is now installed";
?>
