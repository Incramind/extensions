<?php

/* This page simulates the payment processor
   When entered with some data, it will show the information of the order and 3 buttons.
   Here you can select if you like the order to succeed, fail or processing.
   A order that is processing means the payment takes longer, and follow up checks need to be made after a certain amount of time
*/   

// we receive the information as a base64 json via a post. Decode the base64, and make from the json an object.
$val = $_GET["val"];
$jsonstr = base64_decode($val);
$jsonStruct = json_decode($jsonstr);

$successPage = $jsonStruct->successPage;
$failPage = $jsonStruct->failPage;
$processingPage = $jsonStruct->processingPage;
//$webHookPage = $jsonStruct->webHookPage;
//$finishedPage = $jsonStruct->finishedPage;
$price = $jsonStruct->total;
$summary = $jsonStruct->summary;
$orderId = $jsonStruct->orderId;
$paymentMethodId = $jsonStruct->paymentMethodId;
$customerName = $jsonStruct->customerName;
$securityCode = $jsonStruct->securityCode;

/*
echo "$successPage<br/>";
echo "$failPage<br/>";
echo "$processingPage<br/>";
echo "$webHookPage<br/>";
echo "$finishedPage<br/>";
echo "$price<br/>";
echo "$summary<br/>";
echo "$orderId<br/>";
echo "$paymentMethodId<br/>";
echo "$customerName<br/>";
*/


?>

<!--- we add the standard shop header blocks --->
[:head]
[:headerblock]
<div class="container one-column">
	<div class="main-content">
		
		
		<div id="container">
			<div class="header">
				<p>Sample payment provider</p>
			</div>
			<div class="main_content_wrapper">
				<form id="paySample_form" method="post" action="PaymentSample/Confirm">
					<div class="main_content">
						<div class="details1_wrapper">
							<fieldset>
								<ul class="details1">
									<li><label for="transaction_title"></label><span><?php echo $summary; ?></span></li>
									<li><h3><label for="transaction_title">Price:</label><span><?php echo $price; ?></span><h3></li>
								</ul>
							</fieldset>
						</div>
						<div class="details2_wrapper">
							<fieldset>
								<ul class="details2">
								</ul>
								<div style="text-align:right;padding-top: 20px;padding-right:20px;">
									<button type="button" onclick="successPayment()" name="success">Success</button>
									<button type="button" onclick="canceTransaction()" name="cancel">Fail</button>
									<button type="button" onclick="processingPayment()" name="processing">Processing</button>
								</div>
							</fieldset>
						</div>
					</div>
				</form>
				<div class="footer">
					<p align="center">Demo payment processor using PHP</p>
				</div>
			</div>
		</div>
		
			
	</div>
</div>
[:footerblock]

<script>

// we create a failed transaction in the ajax call then redirect
function canceTransaction(){
	var url_update = "url/{show}";
	jQuery.ajax({
			url	:	"/paymentSample/success?<?php echo "orderId=$orderId&paymentMethodId=$paymentMethodId&actualAmount=$price&securityCode=$securityCode&name=$customerName"; ?> ",
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("sucess")								  
						}
	   });
	
	window.location.href = <?php echo "\"$failPage\""; ?>
}

// we create an open Transaction in the ajax call the redirect.
function processingPayment(){
	var url_update = "url/{show}";
	jQuery.ajax({
			url	:	"/paymentSample/success?<?php echo "orderId=$orderId&paymentMethodId=$paymentMethodId&actualAmount=$price&securityCode=$securityCode&name=$customerName"; ?> ",
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("sucess")								  
						}
	   });
	
	window.location.href = <?php echo "\"$processingPage\""; ?>
}

// There is an ajax call to create an Transaction. 
// The payment processor implementation has to create the transaction object for the order.
// This is because only here we have certain information, like payment references
// If we create a good transaction object, and rediect to the success url, there is nothing else to do, thr payment is approved.
function successPayment(){
	
	var url_update = "url/{show}";
	jQuery.ajax({
			url	:	"/paymentSample/success?<?php echo "orderId=$orderId&paymentMethodId=$paymentMethodId&actualAmount=$price&securityCode=$securityCode&name=$customerName"; ?> ",
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("sucess")								  
						}
	   });
	
	window.location.href = <?php echo "\"$successPage\""; ?>
}

</script>