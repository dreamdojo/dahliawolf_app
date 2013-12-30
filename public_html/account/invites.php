<?
$pageTitle = "Invite Friends";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
?>
<div class="AboutContent">
	<div class="title-section">
		<div class='section-title'>INVITE YOUR FRIENDS</div>
	</div>
	<div class="AboutRight">
		
                
        <form id="inviteforms" method="post" action="/public_html/action/invite.php">
        <div id="EmailAddresses" class="Form FancyForm floatLeft" style="width: 62%; margin-left:-42px;">
            <ul>
                <li>
                    <input type="text" class="email" tabindex="1" name="emails[]" />
                    <label>Email Address 1</label>
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
                <li>
                    <input type="text" class="email" tabindex="2" name="emails[]" />
                    <label>Email Address 2</label>
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
                <li>
                    <input type="text" class="email" tabindex="3" name="emails[]" />
                    <label>Email Address 3</label>
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
                <li>
                    <input type="text" class="email" tabindex="4" name="emails[]" />
                    <label>Email Address 4</label>
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
                <li>
                    <textarea name="message" style="min-height: 6.85em;" tabindex="5"></textarea>
                    <label>Add a personal note (optional):</label>
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
            </ul>
        </div>
        
        <div class="clear message"></div>
        
        <div class="clear">
            <a id="SendInvites" class="Button OrangeButton Button18" tabindex="6" onclick="$(this).closest('form').submit()"><strong>Send Invites</strong><span></span></a>
        </div>
        <input type="hidden" name="fpsub" value="1" />
		</form>


	</div>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>