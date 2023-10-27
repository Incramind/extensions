<?php
/* 
  This function is called every hour for each order that is in the processing status.
  Here you can check if the payment is already received or the payment has failed and then return the status.
  
  The following object are available:
  
  $pm          (Object PaymentMethod)   The selected payment method.
  $website     (Object Website)	        The current website
  $order       (Object Order)           The order that was created for this checkout.
  $mutation    (Object OrderMutation)   The order mutation that was crated
  $message     (return string)          A message that can be passed to the program
  $transaction (Object Transaction)     The created Transaction, the one you crated earlier if any.
  
  return    nothing or default 				            nothing is changed, next hour it will be checked again
            "PaymentImplementationStatus_Unknown"       nothing is changed, next hour it will be checked again
            "PaymentImplementationStatus_Failed"        The order will be placed in the fail state, and possible stock is restored (depending on the settings)
			"PaymentImplementationStatus_Pending"		The order is still processing, nothing changes
			"PaymentImplementationStatus_Success"       The order will be successfully paid and placed in the paid status
			"PaymentImplementationStatus_Refunded"		The order will be refunded
			"PaymentImplementationStatus_ChargedBack"   the order is changed back
			"PaymentImplementationStatus_Ignore"        nothing is done
			"PaymentImplementationStatus_Disputed"      The order is placed in the "NeedsAttention" status, the webshop owner should check out what is wrong with this payment.

*/  


// in our implementation we will alwaus make the procesing payment succeed the first time we have a chance.
// when implenting a real payment processor this is the time to ask to the server the status of the payment and translate this status to the right return

echo "Trabnsaction status = $transaction->status";

if ($transaction->status == TransactionStatusType_Success)
	$_RETURN = PaymentImplementationStatus_Success;
else if ($transaction->status == TransactionStatusType_Failed)
	$_RETURN = PaymentImplementationStatus_Failed;
else if ($transaction->status == TransactionStatusType_Open)
	$_RETURN = PaymentImplementationStatus_Pending;
else if ($transaction->status == TransactionStatusType_Refunded)
	$_RETURN = PaymentImplementationStatus_Refunded;
else if ($transaction->status == TransactionStatusType_Disputed)
	$_RETURN = PaymentImplementationStatus_Disputed;
else
	$_RETURN = PaymentImplementationStatus_Ignore;

// return ignore, the order is not yet paid directly, but it is done later
//$_RETURN = PaymentImplementationStatus_Ignore;
// we are all done, do not do the default
$_HANDLED = true;

?>