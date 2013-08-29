<a class="Button WhiteButton Indicator" href="#" id="ScrollToTop" style="display: none;"><img src="/skin/img/gototop.jpg" width="61" height="64"></a>
<div class="cl"></div>
<div id="theOverlay"></div>
<div id="sys-profiler"></div>
<div id="sysMessageDialog" style="display: none;" title="Message"></div>
<!--<div id="dw-footer-background"></div>
<div id="dw-footer"><img src="/images/dw-copyright.png" style="padding-top: 3px; padding-left: 6px;"><span class="dw-foot"> © Dahlia Wolf 2013</span><span class="dw-foot" style="color:red;"><a href="/help">How it Works</a></span><span class="dw-foot"><a href="/tos">Legal</a></span><span class="dw-foot" style="color:red;"><a href="/faqs">FAQs</a></span><span class="dw-foot-last" style="color:red;"><a href="/contact">Contact</a></span></div>
-->
<style>
    #dwFooter{ position: fixed; left: 0px; bottom: 0px; width: 60px; height: 60px; background-color: #F3F3F3;}
    #dwFooter img{position: relative; z-index: 12; width: 45px; margin: 6px;}
    #dwFooter:hover ul{display: block !important;}
    #dwFooter:hover p{display: block !important;}
    #dwFooter ul{position: absolute; bottom: 80%; z-index: 1000; left: 0px; display: none;}
    #dwFooter ul:first-child{padding-top: 20px;}
    #dwFooter li{ color: #A7A7A7; background-color: #F3F3F3; font-size: 12px; width: 135px; padding: 5px 0px; text-indent: 10px;font-family: futura;}
    #dwFooter li:hover{color: #F03E63;}
    #dwFooter p{position: absolute; bottom: 0px; left: 0px; width: 135px; display: none; background-color: #F3F3F3;height: 60px;padding: 0px;margin: 0px;}
</style>
<div id="dwFooter">
    <ul>
        <a href="/help"><li style="padding-top: 20px;">How it Works</li></a>
        <a href="/tos"><li>Legal</li></a>
        <a href="/faqs"><li>FAQs</li></a>
        <a href="/contact"><li>Contact</li></a>
        <li style="color: #c3c3c3;">© Dahlia Wolf 2013</li>
    </ul>
    <p></p>
    <img src="/images/logo_60x60.png">
</div>
<?
if (!empty($_GET['modal'])) {
	?>
<script>loginscreen("<?= $_GET['modal'] ?>")</script>
	<?
}
?>
<div id="sign-up-modal">
	<div class="sign-up-business">
    	<a href="/social-login.php?social_network=facebook"><img src="/skin/img/signinfacebook.png" width="244" height="49"></a>
        <a href="/signup"><div class="mailme">or sign up the old school way with email</div></a>
    </div>
</div>
<div id="fancybox-tmp"></div>
<div id="fancybox-loading"><div></div></div><div id="fancybox-overlay"></div><div id="fancybox-wrap"><div id="fancybox-outer"><div class="fancybox-bg" id="fancybox-bg-n"></div><div class="fancybox-bg" id="fancybox-bg-ne"></div><div class="fancybox-bg" id="fancybox-bg-e"></div><div class="fancybox-bg" id="fancybox-bg-se"></div><div class="fancybox-bg" id="fancybox-bg-s"></div><div class="fancybox-bg" id="fancybox-bg-sw"></div><div class="fancybox-bg" id="fancybox-bg-w"></div><div class="fancybox-bg" id="fancybox-bg-nw"></div><div id="fancybox-content"></div><a id="fancybox-close"></a><div id="fancybox-title"></div><a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a><a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a></div></div><div id="tiptip_holder" style="max-width:200px;"><div id="tiptip_arrow"><div id="tiptip_arrow_inner"></div></div><div id="tiptip_content"></div></div>

</body>
</html>
