<?
header("Content-type: text/css");
?>
/*<style>*/
.spine cf:before,
.spine .cf:after {
    content: " ";
    display: table;
}
.spine .cf:after {
    clear: both;
}
.spine .cf {
    *zoom: 1;
}

.spine {
	margin: 15px auto;
	
	text-align: center;
	padding-bottom: 50px;
	width: 0;
}
.header + .spine,
#postitdiv + .spine {
	margin-top: 100px;
}
.spine > p {
	white-space: nowrap;
}
.spine a {
	cursor: pointer;
	color:white;
}
.spine a:hover {
	cursor: pointer;
	color:black;
}

.spine ul {
	margin: 0;
	padding: 0;
	list-style: none;
}
.spine img {
	display: block;
}
.spine ul.images {
	/*white-space: nowrap;*/
	position: relative;
}
.spine ul.images > li {
	/*display: inline-block;
	vertical-align: top;*/
	/*float: left;*/
	position: absolute;
	
	/*background: rgb(173, 173, 173);*/
	
	/*position: relative;*/
	
	border-color: rgb(173, 173, 173);
	border-style: solid;
	background-color: #fff;
	margin: 2px;
	border-width: 20px 20px 25px;
}
.spine ul.images .image {
	display: block;
	overflow: hidden;
	background-color: #fff;
}
.spine ul.images p {
	position: absolute;
margin: 0;
bottom: -20px;
font: 14px/100% Helvetica, sans-serif;
text-transform: uppercase;
}
ul.share {
	position: absolute;
	top: 0;
	background: #373737;
	display:none;
	margin-top: 46px;
	color:#fff !important;
}
ul.share li {
	/*float: left;*/
	display: block;
	width: 120px;
	height: 25px;
	padding-left: 17px;
}
ul.share a {
	display: block;
	text-indent: 26%;
	white-space: nowrap;
	width: 20px;
	height: 20px;
	background-repeat: no-repeat;
	background-position: center center;
	background-size: 20px 20px;
	color: #fff !important;
	font-weight: normal;
	line-height: 19px;
	font-size: 14px;
}
ul.share .facebook a {
	background-image: url("../skin/img/btn/facebook-dahlia-share.png");
}
ul.share .facebook a:hover {
	background-image: url("../skin/img/btn/facebook-dahlia-share-color.png");
}
ul.share .pinterest a {
	background-image: url("../skin/img/btn/pinterest-dahlia-share.png");
}
ul.share .pinterest a:hover {
	background-image: url("../skin/img/btn/pinterest-dahlia-share-color.png");
}
ul.share .twitter a {
	background-size: 20px 14px;
	background-image: url("../skin/img/btn/twitter-dahlia-share.png");
}
ul.share .twitter a:hover {
	background-image: url("../skin/img/btn/twitter-dahlia-share-color.png");
}
ul.images .username {
	font-weight: bold;
}
ul.images .like {
	left: auto;
	/*bottom: -2px;*/
	bottom: -26px;
	right: 0;
}
.spine ul.images .like span,
.spine ul.images .like a {
	vertical-align: top;
}
.spine ul.images .like a {
	display: inline-block;
	background: url("../images/broken.png") no-repeat 0 0;
	width: 26px;
	height: 26px;
	text-indent: 100%;
	white-space: nowrap;
	overflow: hidden;
	position: relative;
	top: -4px;
	
	width: 20px;
	height: 20px;
	background-size: 20px 20px;
}
.spine ul.images .liked .like a {
	background-image: url("../images/heart.png");
}
.spine ul.images .like a:hover {
	opacity: 0.9;
}
.spine ul.images .image:hover img {
	opacity: 1;
}
.spine ul.images .liked .like span {
	color: rgb(186, 85, 85);
}

.spine .wild-4 {
	z-index: -1;
}
.spine .image:hover .wild-4 {
	z-index: 0;
}
.spine ul.images p.wild-4,
.spine .wild-4 a {
	width: 154px;
	height: 150px;
}
.spine ul.images p.wild-4 {
	margin: 0;
	top: 50%;
	left: 50%;
	margin-top: -70px;
	margin-left: -74px;
}
.spine .wild-4 a {
	display: block;
	text-indent: 100%;
	white-space: nowrap;
	overflow: hidden;
	background: url("../images/like.png") no-repeat center center;
	background-size: 154px 150px;
}
.spine .wild-4 a:hover {
	background-image: url("../images/wild_hover.png");
}
.spine .liked .wild-4 a {
	background-image: url("../images/wild_like.png");
}
.spine-alien{background-image: url(/images/alien-bg.png);background-size: cover;width: 36px;height: 100%;bottom: auto; float: left; position:static !important;}
.spine-social-box{position: absolute;left: 0px;top: 0px;height: 36px;width: 76px;display: none;}
.image:hover .spine-social-box{display:block;}
.spine-comment{ background-image:url(/images/spine-comment-bg.png); background-size:cover; width:36px; height:100%; bottom:auto;float: left; position:static !important;line-height: 35px !important;font-size: 11px !important;}
.spine-social-box:hover .share{display:block;}
.divot{background-image:url(/images/divot.png); background-size:cover; position:absolute; width: 10px;height: 9px;left: 13px;top: -9px;}
.bridge{position: absolute;height: 20px;width: 100%;margin-top: -10px;}
<?
require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/classes/Spine-1.1.php';
$Spine = new Spine();
$Spine->output_css();
?>

#modal {
	position: fixed;
	z-index: 103;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: rgba(255, 255, 255, 0.75);
	display: none;
	
	position: absolute;
}
#modal-content {
	position: absolute;
	left: 50%;
	top: 0;
	padding: 25px;
	
}
.modal .close {
	width: 22px;
	height: 24px;
	text-indent: 0;
	background: none;
	border: none;
	top: 0;
}
.modal .close:active,
.modal .close:hover {
	background: none;
	border: none;
}

/* Explore */
.explore {
	margin: 50px auto;
	width: 600px;
	font: 14px Helvetica, sans-serif;
}
.explore > p {
	text-align: center;
}
.header + .explore {
	margin-top: 100px;
}
.explore .posts > li {
	background: #ebebeb;
	padding: 15px 15px 60px;
}
.explore .posts > li + li {
	margin-top: 50px;
}
.explore .posts .user {
	padding-left: 65px;
	color: rgb(160, 160, 160);
	height: 65px;
	font-size: 16px;
}
.explore .posts .user a {
	color: #3d3d3d;
}
.explore .posts .user a:hover {
	color: #cf1f40;
}
.explore .posts .user .avatar {
	float: left;
	margin-left: -65px;
}
.explore .posts .user .location {
	color: #000;
	height: auto;
	font-size: inherit;
	margin: 0;
}
.explore .posts .user .owner-actions {
	overflow: hidden;
}
.explore .posts .user .owner-actions li {
	float: left;
}
.explore .posts .user .owner-actions li + li {
	border-left: 1px solid rgb(160, 160, 160);
	margin-left: 5px;
	padding-left: 5px;
}
.explore .posts .user .owner-actions a {
	font-weight: normal;
	font-size: 14px;
	line-height: 100%;
}
.explore .posts .image {
	position: relative;
	width: 420px;
	margin: 0 auto;
	background: #000;
	border: 10px solid #adadad;	
}
.explore .posts .image img {
	display: block;
	margin: 0 auto;
	width: 420px;
    min-height: 400px;
}
.explore .posts .image:hover img {
}
.explore .posts .image p {
	margin: 0;
}
.explore .posts .image p {
	display: none;
    float:left;
}
.explore .posts li .image:hover p {
	display: block;
}
.explore .posts .image .wild-4 a {
	text-indent: 100%;
	white-space: nowrap;
	overflow: hidden;
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -66px 0 0 -68px;
	width: 136px;
	height: 125px;
	background: url("../images/like.png") no-repeat 0 0;
	background-size: 135px 125px;
}
.explore .posts .image .wild-4 a:hover {
	background-image: url("../images/wild_hover.png");
}
.explore .posts .voted .image .wild-4 a {
	background-image: url("../images/wild_like.png");
}
.explore .posts .image .buy {
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -103px 0 0 -156px;
	width: 280px;
	height: 206px;
	background: url("../images/vote-hover.png") no-repeat 0 0;
	color: #fff;
	text-transform: uppercase;
	text-align: center;
	font-size: 21px;
	padding-top: 24px;
}
.explore .posts .image .buy a {
	position: absolute;
	top: 0;
	margin: 102px 0 0 32px;
	color: #fff;
	display: block;
	width: 280px;
	height: 103px;
	background: url("../images/vote-hover-red.png") no-repeat 0 0;
	line-height: 103px;
}
.explore .posts .info {
	position: relative;
	margin: 0 auto;
	width: 420px;
	background: #adadad;
	border: 10px solid #adadad;
	border-width: 0 10px;
	height: 30px;
}
.explore .posts .info p {
	margin: 0;
}
.explore .posts .info .votes {
	font-size: 22px;
	position: absolute;
	right: 0;
	top: -5px;
}
.explore .posts .voted .info .votes {
	color: rgb(186, 85, 85);
}
.explore .posts .info .votes a {
	display: inline-block;
	background: url("../images/broken.png") no-repeat 0 0;
	text-indent: 100%;
	white-space: nowrap;
	overflow: hidden;
	position: relative;
	top: -2px;
	vertical-align: middle;
	width: 26px;
	height: 26px;
	background-size: 26px 26px;
}
.explore .posts .info .votes a:hover {
	opacity: 0.8;
}
.explore .posts .voted .info .votes a {
	background-image: url("../images/heart.png");
}
.color-0{background-color:#313131 !important;}
.color-1{background-color:#821026 !important;}
.color-2{background-color:#f8cecf !important;}
.color-3{background-color:#040404 !important;}
.color-4{background-color:#c96160 !important;}
.color-5{background-color:#000000 !important;}