function SEND_COM(id)
{
	var comment = $("#add_comment"+id).val();

		var form = $('#scform'+id);
		$.ajax({
			url: base_url+'/com_sub.php?compid='+id+'&thecomment='+comment,
			type: 'post',
			beforeSend: function()
			{
				$('#scerr'+id).html('');
				form.find('input[type=submit]').attr('disabled', 'disabled');
			},
			success: function(r)
			{
				if (r.success == true) 
				{
					$('#hide_new_com_'+id).hide();
					$('#atcom'+id).html(r.m1);
					$('#show_new_com_'+id).show();
				} 
				else 
				{
					if (r.msg) 
					{
						$('#scerr'+id).html(r.msg);
					}
				}
				form.find('input[type=submit]').removeAttr('disabled');
			},
			cache: false,
			data: form.serializeArray(),
			dataType: 'json'
		});
	
		return false;

}
function ADD_LIKE(id,nhide,nshow) {
	$('#'+nhide).addClass('hidden');
	$.post(base_url+"/like.php",{"id":id},function(html) {
		$('#'+nshow).removeClass('hidden');
		var lcnt = $("#chglikes"+id).html();
		lcnt++;
		$('#chglikes'+id).html(lcnt);
		userPoints(1);
	});
}
function REM_LIKE(id,nhide,nshow) {
	$('#'+nhide).addClass('hidden');
	$.post(base_url+"/like2.php",{"id":id},function(html) {
		$('#'+nshow).removeClass('hidden');
		var lcnt = $("#chglikes"+id).html();
		if(lcnt > 0)
		{
			lcnt--;
			$('#chglikes'+id).html(lcnt);
		}
	});
}

function postToFacebook(){
FB.ui(
  {
   method: 'feed',
   name: 'The Facebook SDK for Javascript',
   caption: 'Bringing Facebook to the desktop and mobile web',
   description: (
      'A small JavaScript library that allows you to harness ' +
      'the power of Facebook, bringing the user\'s identity, ' +
      'social graph and distribution power to your site.'
   ),
   link: 'https://developers.facebook.com/docs/reference/javascript/',
   picture: 'http://www.fbrell.com/public/f8.jpg'
  },
  function(response) {
    if (response && response.post_id) {
      alert('Post was published.');
    } else {
      alert('Post was not published.');
    }
  }
);
}