<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Product Details - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
	echo '<div style="margin-top: 60px"></div>';  
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>
<script type="text/javascript" src="/mobile/js/jquery.min.js"></script>
<script type="text/javascript" src="/mobile/js/ddaccordion.js"></script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "expandable",
	contentclass: "categoryitems",
	revealtype: "click", 
	mouseoverdelay: 200,
	collapseprev: true, 
	defaultexpanded: [0], 
	onemustopen: false,
	animatedefault: false,
	persiststate: true, 
	toggleclass: ["", "openheader"],
	togglehtml: ["prefix", "", ""], 
	animatespeed: "fast", 
	oninit:function(headers, expandedindices){ 
		
	},
	onopenclose:function(header, index, state, isuseractivated){ 
		
	}
})


</script>

<style>
.detail-con{ margin:0; padding:0; width:100% }
.black-con{ margin:0; padding:0;float:left; background:url("/mobile/images/product-image.png") no-repeat 150px center ; height:758px; width:500px; text-align:center;}
.text-con{  margin:72px 0 0 0; padding:0; float:left; width:430px}
.text-con h2{ margin:0; padding:0;}
.text-con h2 img{ margin:0 0 20px 0; padding:0; width:300px;}
.mart{ margin:0; padding:0; float:left; width:430px;}
.mart img{ margin:0 10px 20px 0; padding:0; width:80px; height:80px; float:left;}
.mart-k{ margin:16px 0 0 0; padding:0; width:210px; float:left;}
.mart-k h2{ margin:0; padding:0; font-family:Arial; font-size:36px; line-height:40px; color:#000;}
ul.follow{ margin:0; padding:0;}
ul.follow li{ margin:0 0 0 6px; padding:0; float:left;}
ul.follow li:first-child{ margin:0;}
ul.follow li a{  background-color: rgb(0, 0, 0); text-decoration:none;  color: rgb(255, 255, 255);  font-family: Arial,Helvetica,sans-serif;   font-size:19px;   margin: 0;
    padding: 2px 5px;   text-align: center;   width: 70px;}
ul.follow li a.mess{ background-color:#868686;}
.detail-con h3{ margin:0; padding:0; color:#101207; font-family:Arial, Helvetica, sans-serif; font-size:12px;}
.price-con{ margin:0; padding:0;}
.price-con h1{ margin:0 16px 0 0; padding:0; float:left; color:#101207;  font-family:Arial, Helvetica, sans-serif; font-size:12px; text-decoration:line-through;}
.price-con span a{ margin:0; padding:0;color:#ca0a19;  font-family:Arial, Helvetica, sans-serif; font-size:12px; text-decoration:none; line-height:16px;}
.add-sec{padding:0; margin:10px 0 0 0; float:left;}
.add-sec h4{ margin:0; padding:0;font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#7a736b; line-height:20px; }
ul.add-sec-list{ margin:0; padding:0; float:left; width:430px;}
ul.add-sec-list li{ float:left;}
ul.add-sec-list li span{ margin:0; padding:5px 28px;  color:#000; font-family:Arial, Helvetica, sans-serif; font-size:8px;width:80px; text-align:center; border:1px solid #c3c3c3; }
ul.add-sec-list li h6{ margin:0; padding:5px 0;  color:#000; font-family:Arial, Helvetica, sans-serif; font-size:8px;width:65px; text-align:center; border:1px solid #c3c3c3; }
ul.add-sec-list li h6 .s { border:none; color:#7a736b; width:60px; font-family:Arial; line-height:15px; text-align:center;font-family:Arial, Helvetica, sans-serif; font-size:8px; }
.add-to-wish{ margin:0; padding:0; float:left;}
.add-to-wish h6{ margin:0; padding:0;font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#7a736b; line-height:50px;}
.add-button{ margin:0; padding:0; float:left;}
.add-button a{ margin:0; padding:7px 94px; text-align:center; background-color:#c96162; color:#fff; text-decoration:none;;font-family:Arial, Helvetica, sans-serif; font-size:12px;}
.description{ margin:20px 0 0 0; padding:0; float:left; width:261px;}
.description .arrowlistmenu{ border-top:1px solid #505050;}
.description .arrowlistmenu .menuheader{background: url("/mobile/images/result-up-1.png") no-repeat 96% 11px;}
.description .arrowlistmenu .openheader{ background-image: url("images/result-down-1.png");}
.arrowlistmenu .menuheader{background: url(../images/result-up.png) no-repeat 99% 25px;margin:0px;padding:10px 20px 0 0;cursor: pointer;  height:21px; color:#7a736b; font-size:10px; font-family:arial;  font-weight:normal;}
.arrowlistmenu .openheader{ background-image: url(../images/result-down.png);}
.arrowlistmenu ul{list-style-type: none;margin: 0;padding:0;}
.arrowlistmenu ul li{padding:15px 0 15px 25px; border-bottom:1px solid #737373;  border-top:1px solid #737373;}
.arrowlistmenu ul li .cont-sec{ font-family:Arial, Helvetica, sans-serif; font-size:17px; line-height:16px; margin:0; padding:0; }
.arrowlistmenu ul li .cont-sec a{color:#969696;display: block;padding:0;text-decoration: none;font-size: 13px;  font-family:FUTURASTD-HEAVY;  font-weight:normal;}

</style>

<div class="container">
	<div class="content">
		<div class="detail-con">
			<div class="black-con">&nbsp;</div>
			<div class="text-con">
				<h2><img src="/mobile/images/wild-img.png" /></h2>
				<div class="mart">
					<img src="/mobile/images/profile-pic.png" />
					<div class="mart-k">
						<h2>MARTINA K.</h2>
						<ul class="follow">
							<li><a href="#">FOLLOW</a></li>
							<li><a href="#" class="mess">MESSAGE</a></li>
						</ul>
					</div>
				</div>


				<h3>GREAT WOVEN BLOUSE</h3>
				<div class="price-con">
					<h1>$48.00</h1> 
					<span><a href="#">50%OFF</a></span>
				</div>
				<div class="add-sec">
					<h4>QUANTITY</h4>
					<ul class="add-sec-list">
						<li><h6><input type="text" name="name" value="1" onfocus="javascript:if(this.value=='1'){this.value='';}" onblur="javascript:if(this.value==''){ this.value='1'; }" class="s" /></h6></li>
					</ul>
				</div>

				<div class="add-sec">
					<h4>SELECT SIZE</h4>
					<ul class="add-sec-list">
						<li><span class="blue">XS</span></li>
						<li><span>S</span></li>
						<li><span>M</span></li>
						<li><span>L</span></li>
					</ul>
				</div>

				<div class="add-to-wish">
					<h6>Add to Whishlist</h6>
					<div class="add-button"><a href="#">PRE-ORDER</a></div>
				</div>

				<div class="description">
					<div class="arrowlistmenu">
						<h3 class="menuheader expandable">DESCRIPTION</h3>
						<ul class="categoryitems">
							<p>&nbsp;</p>
						</ul>
					</div>

					<div class="arrowlistmenu">
						<h3 class="menuheader expandable">SIZE & FIT</h3>
						<ul class="categoryitems">
							<li><div class="cont-sec"><a href="#">XS</a></div></li>
							<li><div class="cont-sec"><a href="#">S</a></div></li>
							<li><div class="cont-sec"><a href="#">M</a></div></li>
							<li><div class="cont-sec"><a href="#">l</a></div></li>
						</ul>
					</div>
		
					<div class="arrowlistmenu">
						<h3 class="menuheader expandable">SHIPPING & RETURNS</h3>
						<ul class="categoryitems">
							<p>&nbsp;</p>
						</ul>
					</div>

					<div class="arrowlistmenu">
						<h3 class="menuheader expandable">FABRIC</h3>
						<ul class="categoryitems">
							<p>&nbsp;</p>
						</ul>
					</div>
					
					<div class="arrowlistmenu">
						<h3 class="menuheader expandable">SHARE</h3>
						<ul class="categoryitems">
							<p>&nbsp;</p>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<? 
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>

