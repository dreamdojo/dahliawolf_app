<a class="Button WhiteButton Indicator" href="#" id="ScrollToTop" style="display: none;"><img src="/skin/img/gototop.jpg" width="61" height="64"></a>
<div class="cl"></div>
<div id="theOverlay"></div>
<div id="sys-profiler"></div>
<div id="sysMessageDialog" style="display: none;" title="Message"></div>

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
