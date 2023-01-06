<?php

/* In this override you have the following variables available:

$successPage       (string)                  Page to redirect to when the payment succeeds.
$failPage          (string)                  Page to redirect to when the payment fails
$processingPage    (string)                  Page to redirect to when the payment s still processing 
$webHookPage       (string)                  Page to call for the webhook 
$finishedPage      (string)                  Finish page that will get the status from the transaction
$order             (Object: Order)           The current Order
$mutation          (Object: OrderMutation)   The current mutation  
$pm                (Object: PaymentMethod)   The current payment method class 
$redirect          (return string)           The redirection return to go to the payment method url.  (we can directly return "fail", "Success" or "Processing" if there s no interface or a direct result is known)
$checkout          (Object: ShoppingCart)    The shopping cart with its content. Normally it is better to use the $order and $mutation as this contains the same information as the cart, and is already processed. A shopping cart may contain items that are not checked-out.
*/


class TestObject
{
};

// here we just create a little json object
$myObj = new TestObject;
$myObj->webhookPage = $webhookPage;  
$myObj->finishedPage = $finishedPage; 
$myObj->orderId = $order->Id;
$myObj->securityCode = $mutation->SecurityCode;

// create the json string from the object
$myJSON = json_encode($myObj);
// make it base64, so it does not contain strange characters
$myBase64 = base64_encode($myJSON);

// and redirect to the payment processor page
// normally this is an external URL, but we use a internal URL for this sample.
// and yes, we just add the json as a GET, this of course is just a sample, a real payment implementation has more requrements
$redirect = "/PaymentSample3/Show?val=$myBase64";
$_HANDLED = true;
$_RETURN = true;

?>

