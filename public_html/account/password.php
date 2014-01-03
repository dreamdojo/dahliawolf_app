<?
$pageTitle = "Change Password";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
?>
<div class="FixedContainer">
    <form id="profileEdit" class="Form StaticForm" action="/public_html/action/password.php" method="POST" style="padding-top:20px;">
        <h3>Change Password</h3>
        <ul>
            
            <li>
                <label for="id_link">Current Password</label>
                <div class="Right">
                	<input type="password" name="password_old" value="" id="password" />
                </div>
            </li>
            
            <li>
                <label for="id_link">New Password</label>
                <div class="Right">
                	<input type="password" name="password" value="" id="npassword" />
                </div>
            </li>
            
            <li>
                <label for="id_link">Confirm New Password</label>
                <div class="Right">
                	<input type="password" name="password_confirm" value="" id="cpassword" />
                </div>
            </li>
        </ul>
        
        <div class="Submit">
            <p>
                <a href="#" class="Button OrangeButton Button24" onclick="$(this).closest('form').submit()">
                	<strong>Submit</strong>
                	<span></span>
                </a>
            </p>
        </div>
    </form>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>