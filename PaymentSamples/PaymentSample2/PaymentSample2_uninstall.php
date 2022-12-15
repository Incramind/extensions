<?php

/* de-installs the payment sample 2 extension */

// remove the specific override
removeFunctionOverride("PaymentSample1_SendData", "PaymentImplementationCustom", "SendData");

// remove the payment method
$methodFound = $website->FindPaymentMethod("code", "Sample2");
if ($methodFound!=null)
{
	$website->DeletePaymentMethod($methodFound->Id);
}

?>