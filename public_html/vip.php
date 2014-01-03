<?
    $pageTitle = "VIP";
    include "head.php";
    include "header.php";
?>

<style>
    .vipHeader{background-color: #fff; text-align: center; position: relative; z-index: 3; height: 240px;}
    .vipHeader li{list-style: none; position: relative; z-index: 3;}
    .vip_overlay{position: absolute; background-color: #000; opacity: .6; left: 0px; top: 0px; width: 100%; height: 100%; z-index: 2;}
    #vipBox{width: 350px; margin: 0px auto;}
    #vipBox form{color: #fff;text-align: center;}
    #vipBox img{width: 100%;}
    .vipCode{height: 45px;width: 100%;margin-top: 45px;font-size: 30px;text-align: center;}
    .subButt{background-color: #000;border: #fff thin solid;margin-top: 40px; width: 101%; color: #fff;text-align: center;height: 50px;font-size: 12px; cursor: pointer;}
    .bg_image{position: fixed; left: 0px; top: 290px; width: 100%; height: 100%; background-position: 50%; background-repeat: no-repeat; background-size: 100% auto; background-image: url('/images/DW-slide-1.jpg');}
    .thankz{font-size: 40px;width: 100%;text-align: center;color: #F03D64;margin-top: 150px;}
    .conf{width: 100%;text-align: center;margin-top: 10px;color: #F03D64;font-size: 18px;}
</style>

<div class="transCol">
    <div class="goodieGrad"></div>
    <h1>YOU HAVE BEEN INVITED TO BECOME A VIP</h1>
    <h3>Someone must really think highly of you, VIP membership is reserved for<br>special members only. Activate yours by entering your unique vip code below</h3>
    <ul id="vipBox">
        <img src="/images/logo_600x150.jpg">
        <form id="vipForm">
            <li><input class="vipCode" placeholder="ENTER VIP CODE"></li>
            <li><input class="subButt" type="submit" value="SUBMIT"></li>
        </form>
    </ul>
</div>

<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>

<script>
    vip = new Object();
    vip.$code = $('.vipCode');
    vip.$box = $('#vipBox');
    vip.$form = $('#vipForm').on('submit', function(e) {
        e.preventDefault();
        if(dahliawolf.isLoggedIn) {
            if(vip.$code && vip.$code.val() !== '') {
                vip.submitForm();
            } else {
                alert('You must enter code');
            }
        } else {
            alert('You must be logged in to submit code');
        }
    });

    vip.submitForm = function() {
        $.ajax({
            type: "POST",
            url: "/action/viprequest.php",
            data: {user:dahliawolf.getAttribute('email_address')},
            success: function() {
                vip.$box.empty().append('<li class="thankz">THANK YOU</li><li class="conf">A confirmation email will be<br> sent to you shortly</li>');
            }
        });
        return false;
    }
    $(function() {
       var $bg = $('.bg_image');
        $bg.height(window.innerHeight - 290);
       $(window).resize(function() {
          $bg.height(window.innerHeight - 290);
       });
    });
</script>