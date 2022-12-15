<?php

/* 
  In this override you can change the status on processing. But if you already made a transaction and placed that on the processing status no action is required here.
  
  The following object are available:
  
  $pm      (Object PaymentMethod)   The selected payment method.
  $website (Object Website)	        The current website
  $order   (Object Order)           The order that was created for this checkout.
  $mutation  (Object OrderMutation)   The order mutation that was crated
  $message   (return string)          A message that can be passed to the program
  $transaction (Object Transaction)   The created Transaction, the one you crated earlier if any.
  
  return    nothing or default (when not implemted) action is based on the status of the transaction
            "PaymentImplementationStatus_Unknown"       default return see above. if an transaction is found, it is placed in the processing state.
            "PaymentImplementationStatus_Failed"        check out will fail
			"PaymentImplementationStatus_Pending"		check out will be pending, waiting for payment
			"PaymentImplementationStatus_Success"       check out is successful
			"PaymentImplementationStatus_Refunded"		not an allowed return here, a serious log will be created, and default action is done
			"PaymentImplementationStatus_ChargedBack"   not an allowed return here, a serious log will be created, and default action is done
			"PaymentImplementationStatus_Ignore"        default behavious, no status is changed

*/  

?>