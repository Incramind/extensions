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

$name = $order->ShipToName;                // short name (shipping)
$externalId = "12345";
$profileId = $name . " profile";
$message = "cash payment by". $name;
$issuer = $name;
$now = new DateTime();
$actualAmount = $order->GetTotalPrice();    // total price including tax
$securityCode = $mutation->SecurityCode;    // the security code is used to match transactions with the order

// create the transaction. The implementation payment processor is responsible to making the transaction. This is checked in the success url after redirection.
$transaction = new Transaction();
$transaction->SetExternalTransactionId($externalId);
$transaction->SetPaymentMethodName($paymentMethod->Code);
$transaction->SetTransactionType(TransactionType_Order);
$transaction->SetCreatedAt($now);
$transaction->SetAmount($actualAmount);
$transaction->SetPaymentDetails("");
$transaction->SetExtraInfo($profileId);
$transaction->SetMessage($message);
$transaction->SetStatus(TransactionStatusType_Success);
$transaction->SetStatusText("success");
$transaction->SetSecurityCode($securityCode);
$transaction->SetIssuer($issuer);
$transaction->SetConfiguration("");
$history = "full payment made (test, no actual payment)";
$transaction->SetHistory($history);
$order->AddTransaction($transaction);


// redirect immediately to the success page
$redirect = "success";

?>

