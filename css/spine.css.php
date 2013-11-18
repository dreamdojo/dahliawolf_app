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
	margin: 50px auto;
	
	width: 1000px;
	text-align: center;
	
	padding-left: 400px;
}
.ColumnContainer .spine {
	padding-left: 200px;
}
.header + .spine,
#postitdiv + .spine {
	margin-top: 100px;
}
.spine a {
	cursor: pointer;
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
	background: #000;
	
	margin: 2px;
	border-width: 20px 20px 25px;
}
.spine ul.images .image {
	display: block;
	overflow: hidden;
}
.spine ul.images p {
	position: absolute;
	margin: 0;
	/*bottom: 7px;*/
	bottom: -17px;
	font: 11px/100% Tahoma, Arial, Helvetica, sans-serif;
	text-transform: uppercase;
	
	left: 0;
}
.spine ul.share {
	position: absolute;
	/*bottom: -26px;
	right: 35px;*/
	overflow: hidden;
	right: -20px;
	top: 0;
}
.spine ul.share li {
	/*float: left;*/
	display: block;
}
.spine ul.share a {
	display: block;
	text-indent: 100%;
	white-space: nowrap;
	overflow: hidden;
	/*width: 26px;
	height: 26px;*/
	width: 20px;
	height: 20px;
	background-repeat: no-repeat;
	background-position: center center;
	
	background-size: 20px 20px;
}
.spine ul.share .facebook a {
	background-image: url("../skin/img/btn/facebook-dahlia-share.png");
}
.spine ul.share .facebook a:hover {
	background-image: url("../skin/img/btn/facebook-dahlia-share-color.png");
}
.spine ul.share .pinterest a {
	background-image: url("../skin/img/btn/pinterest-dahlia-share.png");
}
.spine ul.share .pinterest a:hover {
	background-image: url("../skin/img/btn/pinterest-dahlia-share-color.png");
}
.spine ul.share .twitter a {
	background-size: 20px 14px;
	background-image: url("../skin/img/btn/twitter-dahlia-share.png");
}
.spine ul.share .twitter a:hover {
	background-image: url("../skin/img/btn/twitter-dahlia-share-color.png");
}
.spine ul.images .username {
	font-weight: bold;
}
.spine ul.images .like {
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
	opacity: 0.67;
}
.spine ul.images .image:hover img {
	opacity: 0.33;
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
	width: 136px;
	height: 64px;
}
.spine ul.images p.wild-4 {
	margin: 0;
	top: 50%;
	left: 50%;
	margin-top: -23px;
	margin-left: -68px;
}
.spine .wild-4 a {
	display: block;
	text-indent: 100%;
	white-space: nowrap;
	overflow: hidden;
	background: url("../images/like.png") no-repeat center center;
	background-size: 136px 64px;
}
.spine .wild-4 a:hover {
	background-image: url("../images/wild_hover.png");
}
.spine .liked .wild-4 a {
	background-image: url("../images/wild_like.png");
}

<?
require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/classes/Spine.php';
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
    z-index: 10000000;
}
#modal-content {
	position: absolute;
	left: 50%;
	top: 0;
	background: #fff;
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
	font: 14px Tahoma, Arial, Helvetica, sans-serif;
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
}
.explore .posts .image img {
	display: block;
	margin: 0 auto;
	width: 420px;
	border: 10px solid #adadad;	
}
.explore .posts .image a {
	display: none;
	text-indent: 100%;
	white-space: nowrap;
	overflow: hidden;
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -65px 0 0 -65px;
	width: 131px;
	height: 131px;
	background: url("../skin/img/exp_w4.png") no-repeat 0 0;
}
.explore .posts .image a:hover {
	opacity: 0.8;
}
.explore .posts li:hover .image a {
	display: block;
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
	opacity: 0.67;
}
.explore .posts .voted .info .votes a {
	background-image: url("../images/heart.png");
}