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

//$successPage = $jsonStruct->successPage;
//$failPage = $jsonStruct->failPage;
//$processingPage = $jsonStruct->processingPage;
$webhookPage = $jsonStruct->webhookPage;
$finishedPage = $jsonStruct->finishedPage;
//$price = $jsonStruct->total;
//$summary = $jsonStruct->summary;
$orderId = $jsonStruct->orderId;
//$paymentMethodId = $jsonStruct->paymentMethodId;
//$customerName = $jsonStruct->customerName;
$securityCode = $jsonStruct->securityCode;


//echo "JSONSTR $jsonstr<br/>";
//echo "WEBHOOKPAGE $webhookPage<br/>";
//echo "FINISHEDPAGE $finishedPage<br/>";



?>

  <head>
    [:MetaData, [Website.Name] | [_Customer Account Create] ]
    [:Head]
  </head>

	<body>
		[:HeaderBlock]
		<div class="container mt-5">
			<div class="main-content">
				<h1 class="text-danger"> [_Payment Information]</h1>
				<div id="weebhook-info"></div>	
				<form method="post" action="" >
				    <label for="amount">[_Enter the amount.]</label>
					<input type="text" id="amount" name="amount" title="amount" class="input-text form-control"></br>
					<!-- <button type="button" title="make a payment" class="btn btn-default float-right" onclick=""> -->
					<div style="text-align:right;padding-top: 20px;padding-right:20px;">
						<button type="button" onclick="successPayment()" name="success">Success</button>
						<button type="button" onclick="cancelTransaction()" name="cancel">Fail</button>
						<button type="button" onclick="processingPayment()" name="processing">Processing</button>
					</div>
					<!-- <span><span>Submit</span></span> -->
				</button>
				</form>	
				
			</div>
		</div>
		[:FooterBlock]
	</body>

<script type="text/javascript">
	//var _data_return = {"total":16.9,"totalTax":2.93,"totalExTax":13.969999999999999,"totalShipping":6.55,"summary":"2 * Badge BB U64 Black","orderId":9003004576,"orderNumber":"221236","orderDate":{"date":"2022-11-22 05:56:39.000000","timezone_type":3,"timezone":"UTC"},"paymentMethodId":9000000140,"customerName":"D.N. Zweijtzer","securityCode":"78639564936","billToName":"D.N. Zweijtzer","billToAddressLine1":"Elpermeer 253 A ","billToAddressLine2":"1025AG Amsterdam ","items":\[{"name":"Badge BB U64 Black","sku":"BBU64B","shortDescription":"Badge Breadbin U64 Black","priceEach":3.71,"quantity":2,"price":7.42}\]};
    var _data_return; 
	var html = '';

	function fillMyForm(_data_return){
		  console.log("In data return: " + _data_return);
		  html += '<table class="table">';
			  html += '<tr ><td><strong>Name:<strong/></td><td>'+_data_return.customerName+'</td></tr>';
			  html += '<tr ><td><strong>Security Code:<strong/></td><td>'+_data_return.securityCode+'</td></tr>';
			  html += '<tr ><td><strong>Billing Name:<strong/></td><td>'+_data_return.billToName+'</td></tr>';
			  html += '<tr><td><strong>Billing Address:<strong/></td><td>'+_data_return.billToAddressLine1+'</td></tr>';
			  html += '<tr ><td><strong>Total:<strong></td><td>'+_data_return.total+'</td></tr>';
	          html += '<tr ><td><strong>Total:</strong></td><td>'+_data_return.total+'</td></tr>';
	          html += '<tr ><td><strong>Total Tax:</strong></td><td>'+_data_return.totalTax+'</td></tr>';
	          html += '<tr ><td><strong>Total Exclusive Tax:</strong></td><td>'+_data_return.totalExTax+'</td></tr>';
	          html += '<tr ><td><strong>Total Shipping:</strong></td><td>'+_data_return.totalShipping+'</td></tr>';
	          html += '<tr ><td><strong>Summary:</strong></td><td>'+_data_return.summary+'</td></tr>';
	          html += '<tr ><td><strong>Order Id:</strong></td><td>'+_data_return.orderId+'</td></tr>';
	          html += '<tr ><td><strong>Order Number:</strong></td><td>'+_data_return.orderNumber+'</td></tr>';
	          html += '<tr ><td><strong>Order Date:</strong></td><td>'+_data_return.orderDate.date+':</td></tr>';
	          html += '<tr ><td><strong>Order Payment Method Id:</strong></td><td>'+_data_return.paymentMethodId+'</td></tr>';
          html += '</table>';
       
		 let items = "";
		 items += '<table class="table">';
		 items += '<thead><tr><th>Name</th><th>SKU</th><th>Description</th><th>Quantity</th><th>Price Each</th><th>Price</th></tr></thead>';
		  items += '<tbody class="text-center"><tr>';
			_data_return.items.forEach(function(item){
				items += '<td>'+item.name+'</td>';
				items += '<td>'+item.sku+'</td>';
				items += '<td>'+item.shortDescription+'</td>';
				items += '<td>'+item.priceEach+'</td>';
				items += '<td>'+item.quantity+'</td>';
				items += '<td><strong>'+item.price+'</strong></td>';
			})
		  items += '</tr><tbody></table>';
		   html += items;
           document.getElementById("weebhook-info").innerHTML = html;
	}

    //calling function to update the form base from the return
	//console.log("Call data return with hard coded context");
	//fillMyForm(_data_return);

</script>


<!--- we add the standard shop header blocks --->
<!---
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
								</div>
							</fieldset>
						</div>
					</div>
				</form>
				<div class="footer">
					<p align="center">Demo payment processor using PHP with WEBHOOK</p>
				</div>
			</div>
		</div>
		
			
	</div>
</div>
-->

<script>

//callWebhook();
callGetOrderInfo();

// we create a failed transaction in the ajax call then redirect
function callGetOrderInfo(){
	console.log("Calling webhook");
	var url_update = "url/{show}";
	jQuery.ajax({
			url	:	"/paymentSample3/GetOrderInfo?orderId=" + <?php echo "\"$orderId\""; ?> + "&securityCode=" + <?php echo "\"$securityCode\""; ?>,
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("sucess");
							_data_return = JSON.parse(responseText);
							console.log("Call data return with return of webhook");
							fillMyForm(_data_return);
						}
	   });
}

// we create a failed transaction in the ajax call then redirect
function callWebhook(){
	console.log("Calling webhook");
	var url_update = "url/{show}";
	jQuery.ajax({
			url	:	<?php echo "\"$webhookPage"; ?> ",
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("sucess webhook");
						}
	   });
}

// we create a failed transaction in the ajax call then redirect
function cancelTransaction(){
	var url_update = "url/{show}";
	console.log("Calling CANCEL");
	jQuery.ajax({
			url	:	"/paymentSample3/MakeTransaction/cancel?orderId="+_data_return.orderId+"&paymentMethodId="+_data_return.paymentMethodId+"&actualAmount="+_data_return.total+"&securityCode="+_data_return.securityCode+"&name="+_data_return.customerName,
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("success cancel");
							callWebhook();							
						}
	   });
	
	window.location.href = <?php echo "\"$finishedPage\""; ?>
}

// we create an open Transaction in the ajax call the redirect.
function processingPayment(){
	var url_update = "url/{show}";
	console.log("Calling PROSESSING");
	jQuery.ajax({
			url	:	"/paymentSample3/MakeTransaction/processing?orderId="+_data_return.orderId+"&paymentMethodId="+_data_return.paymentMethodId+"&actualAmount="+_data_return.total+"&securityCode="+_data_return.securityCode+"&name="+_data_return.customerName,
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("success processing")								  
							callWebhook();							
						}
	   });
	
	window.location.href = <?php echo "\"$finishedPage\""; ?>
}

// There is an ajax call to create an Transaction. 
// The payment processor implementation has to create the transaction object for the order.
// This is because only here we have certain information, like payment references
// If we create a good transaction object, and rediect to the success url, there is nothing else to do, thr payment is approved.
function successPayment(){
	
	var amount = jQuery("#amount").val();
	console.log("Calling SUCCESS");
	var url_update = "url/{show}";
	jQuery.ajax({
			url	:	"/paymentSample3/MakeTransaction/success?enteredAmount="+amount+"&orderId="+_data_return.orderId+"&paymentMethodId="+_data_return.paymentMethodId+"&actualAmount="+_data_return.total+"&securityCode="+_data_return.securityCode+"&name="+_data_return.customerName,
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("sucess success")								  
							callWebhook();							
						}
	   });
	
	window.location.href = <?php echo "\"$finishedPage\""; ?>
}


//function fillMyForm(responseJson)
//{
//		console.log("again");
//		console.log(responseJson);
//	
//};


</script>