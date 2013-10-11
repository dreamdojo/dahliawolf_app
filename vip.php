<?
    $pageTitle = "VIP";
    include "head.php";
    include "header.php";
?>

<style>
    .vipHeader{background-color: #fff; text-align: center; position: relative; z-index: 3; height: 240px;}
    .vipHeader li{list-style: none; position: relative; z-index: 3;}
    .vip_overlay{position: absolute; background-color: #000; opacity: .6; left: 0px; top: 0px; width: 100%; height: 100%; z-index: 2;}
    #vipBox{border: #fff 5px solid; background-color: #000; height: 300px; width: 500px; position: fixed; left: 50%; top: 50%; margin-left: -250px; margin-top: -150px; z-index: 3;}
    #vipBox form{color: #fff;text-align: center;margin-top: 50px;}
    .vipCode{height: 45px;width: 230px;margin-top: 45px;font-size: 30px;text-align: center;}
    .subButt{background-color: #000;border: #fff thin solid;margin-top: 20px;width: 122px; color: #fff;text-align: center;height: 26px;font-size: 12px; cursor: pointer;}
    .bg_image{position: fixed; left: 0px; top: 290px; width: 100%; height: 100%; background-position: 50%; background-repeat: no-repeat; background-size: 100% auto; background-image: url('/images/DW-slide-1.jpg');}
</style>

<div class="bg_image"></div>
<div class="vip_overlay"></div>
<ul class="vipHeader">
    <li style="padding-top: 30px;font-size: 16px;">SOMEBODY MUST LIKE YOU...</li>
    <li style="padding-top: 10px;font-size: 27px;">YOU HAVE BEEN INVITED TO BECOME A <span class="pinkMe">VIP</span> MEMBER OF</li>
    <li><img src="/images/logo_600x150.png" style="width: 750px;margin-top: 8px;"></li>
</ul>
<ul id="vipBox">
    <form id="vipForm">
        <li style="font-size: 30px;font-weight: 100;">ENTER VIP INVITE CODE</li>
        <li><input class="vipCode" placeholder="ENTER CODE"></li>
        <li><input class="subButt" type="submit" value="SUBMIT"></li>
    </form>
</ul>

<script>
    vip = new Object();
    vip.$code = $('.vipCode');
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
               vip.$code.val('');
               alert('THANK YOU! YOUR ACCOUNT IS BEING PROCESSED');
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