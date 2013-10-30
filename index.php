<?

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
include 'config/mobile-detect.php';
if(isset($_COOKIE["dahliaUser"]) && isset($_COOKIE["token"])){
    $_SESSION['user'] = unserialize($_COOKIE["dahliaUser"]);
    $_SESSION['token'] = $_COOKIE["token"];
    //header( 'Location: spine' );
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name = "viewport" content = "width = 1100, initial-scale=.7, maximum-scale=.7">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <title>Dahlia\Wolf - Landing Page</title>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/homes.js"></script>
    <script src="/js/functions.js" type="text/javascript"></script>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-34564940-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        <!-- Start of Woopra Code -->
        function woopraReady(tracker) {
            tracker.setDomain('dahliawolf.com');
            tracker.setIdleTimeout(1800000);
            tracker.trackPageview({type:'pageview',url:window.location.pathname+window.location.search,title:document.title});
            return false;
        }
        (function() {
            var wsc = document.createElement('script');
            wsc.src = document.location.protocol+'//static.woopra.com/js/woopra.js';
            wsc.type = 'text/javascript';
            wsc.async = true;
            var ssc = document.getElementsByTagName('script')[0];
            ssc.parentNode.insertBefore(wsc, ssc);
        })();
        <!-- End of Woopra Code -->

    </script>

</head>

<style>
    html{background: #fff;}
    body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin: 0;padding: 0;}
    table{border-collapse:collapse;border-spacing: 0;}
    img{border: 0;}
    address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal;}
    li{list-style:none;}
    q:before,q:after{content:'';}
    abbr,acronym {border: 0;font-variant:normal;}
    sup{vertical-align:text-top;}
    sub{vertical-align:text-bottom;overflow:hidden;}
    input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit; resize: none;outline:none;}
    legend{color:#000;}
    body {font-family:Tahoma,arial,sans-serif;font-size:10px;color:#211922;min-width: 980px; margin-top: 90px;}
    table{font-size:inherit;}
    pre,code,kbd,samp,tt{font-family:monospace;line-height:100%;}
    .zoom-in{cursor: -webkit-zoom-in;cursor: -moz-zoom-in;cursor: zoom-in;}
    .zoom-out{cursor: -webkit-zoom-out;cursor: -moz-zoom-out;cursor: zoom-out;}
    a{color: #fff; text-decoration: none;}
    a:hover{color: #c2c2c2;}

    .slide{ height:100%; width:100%; position:absolute; left:0px; top:0px;background-size: auto 100%;background-repeat: no-repeat;background-position: center; background-size: cover;}
    .slide img{min-width:100%; min-height:100%; }
    .theBox{height: auto;position: fixed;top: 20px;z-index: 1;font-size: 13px;text-align: center;left: 35px;}
    .theBox .header{position: relative;z-index: 1;}
    .strange-clouds{opacity: 0.5;background-color: #000; position:absolute; height:100%; width:100%; top:0px; left:0px;z-index: -1;}

    #slideshow-frame{width: 100%;height: 100%;position: fixed;left: 0px;top: 0px;overflow: hidden; font-family: Futura, Arial, sans-serif}
    #slideshow-frame video{position: relative;  }
    .boxCTA{width: 100%; text-align: center;font-size: 24px;padding-bottom: 6%;padding-top: 6%;}
    .nativeBox{width: 93%;display: inline-block;}
    .nativeBox li{width: 45%;text-align: center;float: left;}
    .nativeBox li img{width: 66%;}
    .lbeezy{width: 80%; border-top:#474747 thin solid; padding-bottom: 15%; margin: 0px auto;}
    .enterTheDragon{position: fixed; right: 35px; top: 35px; color: #fff;font-size: 18px;font-family: futura;}
</style>

<body>

<div id="slideshow-frame">
    <video id="dwvideo" controls id="theVideo" style="min-width: 100%; min-height: 100%;" autoplay>
        <source src="http://dev.dahliawolf.com/images/video/story.mp4" type="video/mp4">
        <source src="http://dev.dahliawolf.com/images/video/story.ogv" type="video/ogg">
    </video>
</div>
<div class="enterTheDragon"><a href="/home">ENTER SITE</a></div>

<div class="theBox">
    <a href="/home"><img class="header loggle-toggle" src="/images/homeTitle.png" /></a>
</div>

</body>
</html>
<script>
    $(function(){
        centerVideo();

        $('#slideshow-frame video').on('play', centerVideo);
        $(window).resize(centerVideo);

        $('#theVideo').bind('ended', function() {
            document.location = '/home';
        });
    });


    function centerVideo($this) {
        var $video = $('#slideshow-frame video');



        if($video.height() > window.innerHeight){
            $video.css('top', '-'+(($video.height() - window.innerHeight)/2)+'px');
        }

        if($video.width() > window.innerWidth) {
            $video.css('left', '-'+(($video.width() - window.innerWidth)/2)+'px');
        }

        $video.volume = .25;

        var vid  = document.getElementById("dwvideo");
        vid.addEventListener('progress', function(evt)   { onVideoProgress(evt) }, false);
        vid.addEventListener('timeupdate', function(evt) { onVideoProgress(evt) }, false);
        vid.addEventListener('ratechange', function(evt) { resetTickers(evt) }, false);

        //addVideoListeners(vid);

        var font_size = $video.width()*$video.height()/20000;
        $('#slideshow-frame').css({'font-size': font_size+'px'})

    }


    var __video_queue = [];

    /*
    __video_queue.push({  triggertime: 9,  ttl: 5, subheader: "YOU", header: "INSPIRE" });
    __video_queue.push({  triggertime: 18, ttl: 7, subheader: "MEMBERS", header: "VOTE" });
    __video_queue.push({  triggertime: 27, ttl: 5, subheader: "WE", header: "DESIGN" });
    __video_queue.push({  triggertime: 34, ttl: 4, subheader: "YOU", header: "EARN" });
    */

    __video_queue.push({  triggertime: 9,  ttl: 3, subheader: "YOU", header: "INSPIRE" });
    __video_queue.push({  triggertime: 18, ttl: 5, subheader: "MEMBERS", header: "VOTE" });
    __video_queue.push({  triggertime: 25.5, ttl: 3, subheader: "WE", header: "DESIGN" });
    __video_queue.push({  triggertime: 34, ttl: 2, subheader: "YOU", header: "EARN" });


    var __is_ticker_active = false;


    function onVideoProgress(evt) {
        var curr_time = evt.target.currentTime;
        console.log("progress progress progress..... " + curr_time);

        var index = getTickerIndex(curr_time);
        if(index){ triggerTicker(index); }
        else {
            if (__is_ticker_active === false) {
                $('.videoticker').fadeOut(250, function() { $(this).remove()  } );
            }
        }

    };



    function resetTickers(_event){
        $('.videoticker').remove();
        __is_ticker_active =false;
        onVideoProgress(_event);
    }

    function triggerTicker(_index)
    {
        if(__is_ticker_active) return;



        __is_ticker_active = true;
        var current_tick = __video_queue[_index];

        console.log("triggerTicker..... " + current_tick.header);

        $('.videoticker').fadeOut(250, function(){ $(this).remove();} );

        var ticker_wrapper  = $('<div class="videoticker" style="position: absolute; top: 50%; z-index: 999; margin-left: 40px; display: none"  />');

        var subheader       = $('<p style="font-size: 75%; color: #fff; line-height: 100%" >').text(current_tick.subheader);
        var header          = $('<p style="font-size: 200%; color: #fff; line-height: 100%; margin-top: -5px" >').text( current_tick.header);

        ticker_wrapper
            .append(subheader)
            .append(header)

        $('#slideshow-frame').append(ticker_wrapper);

        ticker_wrapper.show();
        ticker_wrapper
            .fadeIn(500)
            .delay(current_tick.ttl*1000)
            .fadeOut(500, function(){ $(this).remove(); __is_ticker_active = false; console.log('IM OUT!') })


    }


    function getTickerIndex(_time)
    {
        var index = false;
        for(var t in __video_queue)
        {
            var ticker = __video_queue[t];
            if( _time >= ticker.triggertime && Math.abs(_time-ticker.triggertime) < .5){
                index = t;
                break
            }
        }

        console.log("ticker index.. " + index);

        return index;
    }

    function addVideoListeners(vid)
    {
        /* add all event listeners for HTML5 media element events */

        vid.addEventListener('loadstart', function(evt) { logEvent(evt,'#000099'); }, false);
        vid.addEventListener('canplaythrough',function(evt) {  logEvent(evt,'#66CC33'); }, false);
        vid.addEventListener('canplay', function(evt) { logEvent(evt,'#66CC33'); }, false);
        vid.addEventListener('loadeddata', function(evt) { logEvent(evt,'#00CCCC'); }, false);
        vid.addEventListener('loadedmetadata', function(evt) { logEvent(evt,'#00CCCC'); }, false);


        vid.addEventListener('abort', function(evt) { logEvent(evt,'red'); }, false);
        vid.addEventListener('emptied', function(evt) { logEvent(evt,'red'); }, false);
        vid.addEventListener('error', function(evt) { logEvent(evt,'red'); }, false);
        vid.addEventListener('stalled', function(evt) { logEvent(evt,'red'); }, false);
        vid.addEventListener('suspend', function(evt) { logEvent(evt,'red'); }, false);
        vid.addEventListener('waiting', function(evt) { logEvent(evt,'red'); }, false);


        vid.addEventListener('pause', function(evt) { logEvent(evt,'orange'); }, false);
        vid.addEventListener('play', function(evt) { logEvent(evt,'orange'); }, false);
        vid.addEventListener('volumechange', function(evt) { logEvent(evt,'orange'); }, false);


        vid.addEventListener('playing', function(evt) { logEvent(evt,'purple'); }, false);
        vid.addEventListener('seeked', function(evt) { logEvent(evt,'teal'); }, false);
        vid.addEventListener('seeking', function(evt) { logEvent(evt,'teal'); }, false);


        vid.addEventListener('durationchange', function(evt) { logEvent(evt,'#cc0066'); }, false);
        vid.addEventListener('progress', function(evt) { logEvent(evt,'#cc0066'); onVideoProgress(evt) }, false);


        vid.addEventListener('ratechange', function(evt) { logEvent(evt,'#cc0066'); }, false);


        vid.addEventListener('timeupdate', function(evt) { logEvent(evt,'gray'); }, false);
        vid.addEventListener('ended', function(evt) { logEvent(evt,'#000099'); }, false);

        vid.addEventListener('webkitbeginfullscreen', function(evt) { logEvent(evt,'#FF6666'); }, false);
        vid.addEventListener('webkitendfullscreen', function(evt) { logEvent(evt,'#FF6666'); }, false);

    }

    function logEvent(event, color)
    {
        console.log(event.type)
    };

</script>

<?php
/*
$buffer = ob_get_contents();
ob_end_clean();
$memcache_obj = memcache_connect("localhost", 11211);
//memcache_add($memcache_obj, "{$_SERVER['SERVER_NAME']}_{$_SERVER['REQUEST_URI']}" , $buffer, 0);

$memcache = new Memcache();
$memcache->connect('127.0.0.1', 11211);
$memcache->add("{$_SERVER['SERVER_NAME']}_{$_SERVER['REQUEST_URI']}", $buffer, false, 60*60);


echo $buffer;
*/

?>
