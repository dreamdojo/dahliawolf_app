<style>
    .overlay{position: fixed; width: 100%; height: 100%; top: 0px; left: 0px; background-color:#fff; opacity: .89;z-index:10000; }
    #fashioOverlay{ }
    #fashiolistaPop{background-color: #000; width: 550px; height: 560px; position: fixed; margin-top: -280px; margin-left: -275px; top: 50%; left: 50%; z-index: 100000;text-align: center;color: #fff;}
    #fashiolistaPop .logo{margin-top: 50px;margin-bottom: 10px;width: 300px;}
    #fashiolistaPop .enter{background-color: #252525; width: 350px; margin: 0px auto;font-size: 15px; margin-bottom: 30px;}
    #fashiolistaPop .enter li:first-child{height: 35px; line-height: 35px;}
    #fashiolistaPop .enter li:last-child{padding-bottom: 15px;}
    #fashiolistaPop .members{margin-bottom: 35px;font-size: 13px;}
    #fashiolistaPop .avatar{width: 100px;height: 100px;background-color: #fff;border-radius: 50px;margin: 10px auto;}
    #fashiolistaPop #getStarted{width: 200px;height: 35px;color: #000;background-color: #fff;margin: 0px auto;line-height: 35px;font-size: 17px;margin-top: 40px; cursor: pointer;}
</style>
<div id="fashioOverlay" class="overlay"></div>
<div id="fashiolistaPop">
    <img class="logo" src="/images/fashiolist_welcome.jpg">
    <div class="members">MEMBERS</div>
    <ul class="enter">
        <li>TO ENTER THE CONTEST</li>
        <li>POST AT LEAST 1 INSPIRATION IMAGE</li>
    </ul>
    <ul>
        <li>YOUR DAHLIAWOLF USERNAME IS</li>
        <li class="avatar">avatar</li>
        <li>@USERNAME</li>
    </ul>
    <div id="getStarted">GET STARTED</div>
</div>
<script>
    $(function() {
        $('#getStarted').on('click', function() {
            $('#fashiolistaPop').fadeOut(100);
            $('#fashioOverlay').fadeOut(200);
        });
        $(document).one('click', '.postButton', function() {
            console.log('success');
        });
    });
</script>