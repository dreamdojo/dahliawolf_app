<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Review - Dahlia\Wolf</title>
<link href="/mobile/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/mobile/js/jquery_004.js"></script>
<script src="/mobile/js/custom.js" async="" type="text/javascript"></script>
<script type="text/javascript">
function showContent(id) {
	var divId="content";
	var actId="active";
	for (var i=1; i<=8; i++)
	{
		var currentDivId=divId+i;
		var activeClsId=actId+i;
		if(i==id)
		{
		document.getElementById(currentDivId).style.display="block";
		document.getElementById(activeClsId).className="active";
		}
		else
		{
		document.getElementById(currentDivId).style.display="none";
		document.getElementById(activeClsId).className="";
		}
	}
	return false;
}

</script>
</head>

<body>
<div class="container">
	<div class="content">
		<div class="section1">
			<div class="btm-nav">
          		<ul class="nav">
            		<li><a href="javascript:void('0')" onclick="javascript:return showContent('1');" id="active1" class="active" >BILLING</a></li>
            		<li><a href="javascript:void('0')" onclick="javascript:return showContent('2');" id="active2">SHIPPING</a></li>
            		<li><a href="javascript:void('0')" onclick="javascript:return showContent('3');" id="active3">PAY</a></li>
            		<li><a href="javascript:void('0')" onclick="javascript:return showContent('4');" id="active4">REVIEW</a></li>
          		</ul>
      		</div>
  			
  			<div class="artical1" id="content1" style="display:block">
      			<div class="bill">
					<h2>BILLING ADDRESS</h2>
					<p>Please enter your details below to complete your purchase.<br />Already resistered <a href="#">Click here to login</a></p>
					<ul class="bil-add">
						<li class="name">
							<label>First Name*</label>
							<input id="name" class="required" type="text" name="name">
						</li>
			
						<li class="last">
							<label>Last Name*</label>
							<input id="name" class="required" type="text" name="name">
						</li>
	
						<li class="name">
							<label>Email Address*</label>
							<input id="name" class="required" type="text" name="name">
						</li> 
	
						<li class="last">
							<label>Telephone*</label>
							<input id="name" class="required" type="text" name="name">
						</li>

						<li>
							<label>Address*</label>
							<input id="name" class="required" type="text" name="name">
							<input id="name" class="required" type="text" name="name">
						</li>
			
						<li class="con">
							<label>Country*</label>
							<select>
								<option value="Please select">Please select</option>
								<option value="US">USA</option>
							</select>
						</li>

						<li class="city">
							<label>City*</label>
							<input id="name" class="required" type="text" name="name">
						</li>

						<li class="name">
							<label>Zip Code*</label>
							<input id="name" class="required" type="text" name="name">
						</li>

						<li class="state">
							<label>State*</label>
							<select>
								<option value="Please select">Please select</option>
								<option value="CA">California</option>
							</select>
						</li>
					</ul>
				</div>

				<div class="con-button"><input class="button" type="button" value="continue" /></div>
      		</div>    
  			
  			<div class="artical1" id="content2" style="display:none">
      			<div class="bill">
					<h2>SHIPPING ADDRESS</h2>
					<ul class="bil-add">
						<li class="name">
							<label>First Name*</label>
							<input id="name" class="required" type="text" name="name">
						</li>
	
						<li class="last">
							<label>Last Name*</label>
							<input id="name" class="required" type="text" name="name">
						</li>

						<li>
							<label>Address*</label>
							<input id="name" class="required" type="text" name="name">
							<input id="name" class="required" type="text" name="name">
						</li>

						<li class="con">
							<label>Country*</label>
							<select>
								<option value="Please Select">Please Select</option>
								<option value="US">USA</option>
							</select>
						</li>

						<li class="city">
							<label>City*</label>
							<input id="name" class="required" type="text" name="name">
						</li>

						<li class="name">
							<label>Zip Code*</label>
							<input id="name" class="required" type="text" name="name">
						</li>

						<li class="state">
							<label>State*</label>
							<select>
								<option value="Please Select">Please Select</option>
							</select>
						</li>

						<li class="name">
							<label>Company</label>
							<input id="name" class="required" type="text" name="name">
						</li>

						<li class="name">
							<label>Fax</label>
							<input id="name" class="required" type="text" name="name">
						</li>
					</ul>
				</div>
      		</div>    
  
  			<div class="artical1" id="content3" style="display:none">
       			<div class="bill">
					<h2>PAYMENT METHOD</h2>
					<ul class="bil-add">
						<li class="con">
							<label>Payment method*</label>
							<select>
								<option value="Please select">Please select</option>
								<option value="volvo">Credit Card</option>
								<option value="saab">PayPal</option>
							</select>
						</li>
						
						<li class="con">
							<label>Name on card*</label>
							<input id="name" class="required" type="text" name="name">
						</li>
						
						<li class="con">
							<label>Credit card type*</label>
							<select>
								<option value="Please select">Please select</option>
								<option value="volvo">American Express</option>
								<option value="saab">Visa</option>
							</select>
						</li>

						<li class="con">
							<label>Credit card number*</label>
							<input id="name" class="required" type="text" name="name">
						</li>

						<li class="exp">
							<label>Experation date*</label>
							<input id="name" class="required" type="text" name="name">
						</li>

						<li class="mt">
							<label>&nbsp;</label>
							<select>
								<option value="Please select"></option>
								<option value="volvo">October</option>
							</select>
						</li>

						<li class="exp">
							<label>Card verification number*</label>
							<input id="name" class="required" type="text" name="name">
						</li>
				
						<li class="mt">
							<label>&nbsp;</label>
							<a href="#"><h5>What is this?</h5></a>
						</li>
					</ul>
				</div>
      		</div>     
   
   			<div class="artical1" id="content4" style="display:none">
       			<div class="bill">
					<h2>REVIEW YOUR ORDER</h2>
						<ul class="bil-add">
							<li class="bil-add">
								<label>Billing Address</label>
								<input class="button" type="button" value="EDIT">
								<p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br />
								xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br />
								xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
							</li>
		
							<li class="bil-add">
								<label>Shipping Address</label>
								<input class="button" type="button" value="EDIT">
								<p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br />
								xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br />
								xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
							</li>

							<li class="bil-add">
								<label>Payment</label>
								<input class="button" type="button" value="EDIT">
								<p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br />
								xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br />
								xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
							</li> 
						</ul>
				
					<div class="place"><input class="button" type="button" value="PLACE ORDER"></div>
				</div>
      		</div>    
     	</div>
    </div>
</div>

</body>
</html>
