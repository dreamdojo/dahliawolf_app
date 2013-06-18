<?
$pageTitle = "PinIt";
include "head.php";
include "header.php";
?>
<style>

.button, input[type="submit"] {
    display: block;
    background-color: #e2e8d4;
    border: 1px solid #d0d6c2;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -khtml-border-radius: 5px;
    border-radius: 5px;
    padding: 8px 15px 8px 15px;
    font-size: 18px;
    font-weight: bold;
    color: #6d8c29;
    text-align: center;
    cursor: pointer;
}

.button:hover, input[type="submit"]:hover {
    text-decoration: none;
    background-color: #d3dac2;
    border: 1px solid #9ea886;
}

.button.grey_light {
    background-color: #cccccc;
    font-size: 12px;
    color: #ffffff;
    border: 1px solid #ababab;
    cursor: pointer;
}

.button.grey_light:hover {
    background-color: #c0c0c0;
}

.button.orange {
    background-color: #000000;
    color: #ffffff;
    border: 2px solid #641f2c;
}

.button.orange:hover {
    background-color: #f6851f;
}
</style>

<div class="AboutContent">
		<h1>GET THE INSPIRE BUTTON</h1>
		        
        <h3>
            With the INSPIRE button you can effortlessly add images from any website you are surfing.</p>
        </h3>
        
        <div>
            <a title="INSPIRE" href="javascript:void((function()%7Bvar%20e=document.createElement(%27script%27);e.setAttribute(%27type%27,%27text/javascript%27);e.setAttribute(%27charset%27,%27UTF-8%27);e.setAttribute(%27src%27,%27http://www.dahliawolf.com/js/pinme.js?r=%27+Math.random()*99999999);document.body.appendChild(e)})());" class="button orange" style="cursor: move; float: left;">INSPIRE</a> 
            <div style="float: left; margin-left: 8px; margin-top: 7px; font-size:16px; color:#666">Drag this button to your Bookmarks Toolbar</div>
        </div>
        
        <div class="clear message" style="padding-top:20px;"></div>
        <h3>Adding to Firefox:</h3>

        <p>
             Display your Bookmarks Toolbar by clicking View > Toolbars > Bookmarks Toolbar. Drag the POST button to your bookmark toolbar. When you see an image you want to add to your boards, click the POST button!
        </p>
        
        <div class="clear message"></div
></div>  	

<?
include "footer.php";
?>