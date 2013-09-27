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

</body>
</html>
