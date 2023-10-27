<?php
/* 
  Finalize Payment
  
  This function is called after the webhook is done
  The transaction should be done, and depending on the transaction you can set the order
  Here you can also indicate to the payment processor that the transaction is done
  
  The following object are available:
  
  $pm          (Object PaymentMethod)   The selected payment method.
  $website     (Object Website)	        The current website
  $order       (Object Order)           The order that was created for this checkout.
  $mutation    (Object OrderMutation)   The order mutation that was crated
  $message     (return string)          A message that can be passed to the program
  $transaction (Object Transaction)     The created Transaction, the one you crated earlier if any.
  
  return    true or false

*/  


// in our implementation we will just set the status of the order depending on the transaction status

// when implementing a real payment processor this is the time to ask to the server the status of the payment and translate this status to the right return
// we base the return now on the transaction that we have set before when we pressed a button
/*
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
*/

$_RETURN = PaymentImplementationStatus_Ignore;
// we are all done, do not do the default
$_HANDLED = true;

?>