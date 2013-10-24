<a class="Button WhiteButton Indicator" href="#" id="ScrollToTop" style="display: none;"><img src="/skin/img/gototop.jpg" width="61" height="64"></a>
<div class="cl"></div>
<div id="theOverlay"></div>
<div id="sys-profiler"></div>
<div id="sysMessageDialog" style="display: none;" title="Message"></div>
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
