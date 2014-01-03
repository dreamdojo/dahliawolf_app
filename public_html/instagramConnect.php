<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
</head>

<body>
</body>
</html>
<script>
var _token = location.hash.split('=')[1];

opener.userConfig.instagramToken = _token;
opener.postBank.getImagesFromInstagram();

$.post('/action/setInstagramToken.php', {token: _token}).done(function(){
    close();
});
</script>
