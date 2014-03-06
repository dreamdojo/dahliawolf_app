<?
    $pageTitle = "Careers";
    include "head.php";
    include "header.php";
?>
<style>
    .mainCol{padding-bottom: 100px; color: #797979;}
    .mainCol h1{padding: 40px 0px;text-align: center;font-size: 25px;}
    .mainCol h2{font-size: 18px; padding: 30px 0px;}
    .mainCol section{border-bottom: #797979 thin solid;padding-bottom: 40px;margin-bottom: 25px;}
</style>
<div class="mainCol careers">
    <h1>Dahliawolf Careers</h1>
    <img src="">
    <p>Working at Dahliawolf means doing what you love. We hire trendsetters, hackers, innovators. We want people who can solve today's challenging problems, make real impact and build something big. Learn more about our opportunities.</p>

    <h1>Current Openings</h1>
    <section>
        <h2>SENIOR WEB DEVEOLOPER</h2>
        <p>Dahlia Wolf is currently seeking a Senior Web Software Engineer to join our team and help lead our online development. A passion for clean fast technology and an aspiration to take on a significant leadership role, guiding the technical vision for the company is important.</p>
        <p>The right candidate will have an entrepreneurial spirit, the drive to break new ground, the vision to define new products in an emerging market, and the technical ability to be hands-on in the coding process. If you have the organizational skills to manage and grow an engineering team, that’s is a huge plus.</p>
        <p>Develop and execute on a technical vision for the company.<br>
            Work closely with product management and the business development teams on distilling functional requirements into technical designs that result in highly scalable and high-end quality products.<br>
            Build and lead a team of web developers, establishing development practices and standards as necessary.<br>
            Plan and execute project work plans across various projects / products.<br>
            Hands-on PHP development ability is a MUST (3+ years minimum)<br>
            Desire to succeed and execute needed development<br>
            Java-script<br>
            HTML and CSS<br>
            Magneto<br>
            To apply please send your resume along with a short description on why you would be the perfect fit for the position to <a href="mailto:resume@dahliawolf.com">resume@dahliawolf.com</a>.
        </p>
    </section>

    <section>
        <h2>IOS APP DEVELOPER</h2>
        <p>Dahlia Wolf is currently seeking an experienced iOS developer to help us build and launch our Apps.</p>
        <p>Are you an iOS developer with a solid grasp of client/server communications that thrives in a dynamic, startup-like environment? Do you have a passion for coming up with simple solutions to difficult problems? Do you pride yourself in writing elegant, readable and well-documented code while using your keen eye to identify/solve security issues? If this describes you, then Dahlia Wolf may be a good next step in your exciting career.</p>
        <p>2+ years of iOS experience with one or more apps that deal with server communication and/or security.
            <p>
            5+ years of general software development experience in architecting security and client/server connectivity components of large-scale production applications.<br>
            Solid experience with http, client/server communication, SSO Architectures and OAuth.<br>
            Masterful understanding of iOS application development.<br>
            Expert level knowledge of the iOS SDK, Objective C, C, C++, and Xcode IDE.<br>
            Strong understanding of MVC and other common design patterns.<br>
            Hands-on work experience developing and maintaining a large-scale multi-client production application.<br>
            Familiar with source control systems (i.e. SVN, Perforce).<br>
            Experience with both client and server development environments strongly preferred.<br>
            On server experience with Java and/or Ruby.<br>
            Familiarity with iterative software development approaches (i.e. Agile).<br>
            Experience with CoreAnimation and CoreGraphics APIs.<br>
            To apply please send your resume along with a short description on why you would be the perfect fit for the postion to <a href="mailto:resume@dahliawolf.com">resume@dahliawolf.com</a>.</p>
    </section>
    <section>
        <h2>Junior Developer (Entry Level)</h2>
        <p>To apply please send your resume along with a short description on why you would be the perfect fit for the postion to <a href="mailto:resume@dahliawolf.com">resume@dahliawolf.com</a>.</p>
    </section>
    <section style="border-bottom: none;">
        <h2>ONLINE MARKETING MANAGER</h2>
        <p>Dahlia Wolf is currently seeking an experienced Online marketing manager to help manage and improve the Online content management of Dahlia Wolf.</p>
        <p>Manage the product inventory status of our Online brands.<br>
            Develop and manage a merchandising calendar.<br>
            Monitor the product selection, pricing on and positioning of our products as well as competitors products to better improver our competitive advantage.<br>
            Minimum 3 years experience in commerce content management.<br>
            Strong written and verbal communications skills.<br>
            Strong understanding of the online fashion market.<br>
            To apply please send your resume along with a short description on why you would be the perfect fit for the potion to <a href="mailto:resume@dahliawolf.com">resume@dahliawolf.com</a>.</p>
    </section>
</div>

<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>
<script>
    console.log(<?= json_encode($_data); ?>);
    console.log(<?= json_encode($_SESSION); ?>);
</script>