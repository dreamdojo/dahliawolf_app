<?
    $pageTitle = "Report Copyright";
    include $_SERVER['DOCUMENT_ROOT']."/head.php";
    include $_SERVER['DOCUMENT_ROOT']."/header.php";
?>
<div class="mainCol">
    <form id="reportForm" class="copyrightForm" method="POST">
    <h2>Copyright Infringement Notification</h2>

    <ul id="copyright" class="ControlGroups">
    <li>
        <div>
            <label for="id_identify">Please insert a url referencing where the work appears on <strong>your own website</strong>. e.g. http://yoursite.com/art/1</label>
            <input class="identify new" type="text" name="prior_work_links" id="id_identify" value="">
        </div>
    </li>

    <li class="DoubleBorder">
        <label for="id_infringed">Identify the infringed work on Dahliawolf</label>
        <p>Provide the full URL to <strong>each individual pin</strong>. e.g. http://dahliawolf.com/post/54321. Please limit to 100 per request.</p>
        <input class="infringed new" type="text" name="infringing_pin_ids">
    </li>
    <li>
        <h4>Removal</h4>
        <p>You can request the removal of only this specific pin, or all pins that contain the same image file. Please note that only identical copies of the image file can be removed by this function. If an image file has been re-sized or altered in any other way, then it cannot be detected or removed through this function.</p><br>
        <p>By clicking yes, you are asking Dahliawolf to remove all pins containing the same image file.</p>
        <label>Remove all:</label>
         <input type="radio" name="infringing_pin_ids_remove_all0" id="ipiray0" value="yes">
         <label for="ipiray0">Yes</label>
         <input type="radio" name="infringing_pin_ids_remove_all0" id="ipiran0" value="no">
         <label for="ipiran0">No</label>
    </li>
    <li>
        <p>Dahliawolf enforces a repeat infringer policy that may result in the termination of users who acquire multiple strikes as a result of copyright complaints. Dahliwolf recognizes that some copyright owners may not want their takedown notices to result in the assignment of a strike.</p><br>
        <p>By clicking yes, you are asking Dahliawolf to assign a strike against the user who posted the image you identified in the URL above.</p>
        <input type="radio" name="infringing_pin_ids_strike0" id="ipisy0" value="yes">
        <label for="ipisn0">Yes</label>
        <input type="radio" name="infringing_pin_ids_strike0" id="ipisn0" value="no">
        <label for="ipisn0">No</label>
    </li>

    <li class="DoubleBorder">
        <div class="Left">
            <label for="id_name">Your Full Name</label>
        </div>
        <div class="Right">
            <input type="text" name="owner_name" id="id_name" value="">
        </div>
    </li>

    <li>
        <div class="Left">
            <label for="id_address">Street Address</label>
        </div>
        <div class="Right">
            <input type="text" name="owner_street_address" id="id_address" value="">
        </div>
    </li>

    <li>
        <div class="Left">
            <label for="id_city">City</label>
        </div>
        <div class="Right">
            <input type="text" name="owner_city" id="id_city" value="">
        </div>
    </li>

    <li>
        <div class="Left">
            <label for="id_state">State/Province</label>
        </div>
        <div class="Right">
            <input type="text" name="owner_state" id="id_state" value="">
        </div>
    </li>

    <li>
        <div class="Left">
            <label for="id_code">ZIP/Postal Code</label>
        </div>
        <div class="Right">
            <input type="text" name="owner_postalcode" id="id_code" value="">
        </div>
    </li>

    <li class="DoubleBorder">
    <div class="Left">
        <label for="id_code">Country</label>
    </div>
    <div class="Right">
    <select id="countries" name="owner_country" style="width: 375px"></select>
    </div>
    </li>

    <li>
        <div class="Left">
            <label for="id_phone">Phone Number</label>
        </div>
        <div class="Right">
            <input type="text" name="owner_phone" id="id_phone" value="">
        </div>
    </li>

    <li class="DoubleBorder">
        <div class="Left">
            <label for="id_email">Email Address</label>
        </div>
        <div class="Right">
            <input type="text" name="owner_email" id="id_email" value="">
        </div>
    </li>

    <li>
        <p style="border-bottom: 1px solid rgba(34, 25, 25, 0.1); padding-bottom: 20px;">
            By checking the following boxes, I confirm:
        </p>
        <div class="Left Wide">
            <label for="id_checkbox3">The information in this notice is accurate.</label>
        </div>
        <div class="Right">
            <input id="id_checkbox3" type="checkbox" name="stated_accurate" style="margin-top: 12px">
        </div>
    </li>

    <li>
        <div class="Left Wide">
            <label for="id_checkbox1">
                I have a good faith belief that the disputed use of the copyrighted material is not authorized by the copyright owner, its agent, or the law (e.g., as a fair use).                    </label>
        </div>
        <div class="Right">
            <input id="id_checkbox1" name="stated_unauthorized" type="checkbox" style="margin-top: 38px">
        </div>
    </li>

    <li>
        <div class="Left Wide">
            <label for="id_checkbox2">
                I state under penalty of perjury that I am the owner, or authorized to act on behalf of the owner, of the copyright or of an exclusive right under the copyright that is allegedly infringed.                    </label>
        </div>
        <div class="Right">
            <input id="id_checkbox2" type="checkbox" name="stated_owners_behalf" style="margin-top: 38px">
        </div>
    </li>

    <li style="padding-top: 10px;">
        <div class="Left">
            <label for="id_name">
                Typing your full name in this box acts as your electronic signature
            </label>
        </div>
        <div class="Right">
            <input type="text" name="owner_signature" id="id_name" style="margin-top: 25px">
        </div>
    </li>
    </ul>
    <div class="Submit Copyright">
        <button class="Button RedButton Button24" type="submit">
            Submit Notification
        </button>
    </div>
   </form>
</div>