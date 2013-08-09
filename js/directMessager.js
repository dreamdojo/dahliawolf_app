function directMessage() {
    this.apiUrl = '/api/1-0/message.json?function=';
}

directMessage.prototype.createBox = function(username) {
    this.$container = $('<div id="messengerBox"></div>').appendTo('body').append('<div class="titleBar">New Message</div>');
    this.$addressBar = $('<input type="text" id="addressBar" value="'+username+'">').appendTo( this.$container );
    this.$contents = $('<textarea id="messageContents" placeholder="Enter message here..."></textarea>').appendTo( this.$container );
    $('<div class="submitMessage">SEND</div>').appendTo(this.$container).on('click', $.proxy(this.submitMessage, this) );
    this.$container.fadeIn(500);
}

directMessage.prototype.submitMessage = function() {
    var theMsg = this.$contents.val().trim();
    var recipients = this.$addressBar.val().trim();

    if( theMsg === '' ) {
        this.error('Missing Body');
        return 0;
    } else {
        theMsg = encodeURI(theMsg);
    }

    if(!this.getRecipients(recipients)) {
        this.error('No recipients');
        return 0;
    } else {
        recipients = this.getRecipients(recipients);
    }

    this.apiCall( 'send_message', {to_user_name : recipients, from_user_id: theUser.id, header : 'Personal Message from '+theUser.username, body : theMsg, use_hmac_check : 0}, function(data) {
        alert('Message Sent');
    });
}

directMessage.prototype.getRecipients = function(str) {
    if(str !== '') {
        str = str.replace(/ /g,"");
        return str;
    } else {
        return false;
    }
}

directMessage.prototype.error = function(msg) {
    alert(msg);
}

directMessage.prototype.newMessage = function(username) {
    this.createBox(username);
}

directMessage.prototype.apiCall = function(funct, data, callback) {
    var cURL = this.apiUrl += funct;

    $.each(data, function(key, param) {
        cURL += '&'+key+'='+param;
    });

    console.log(cURL);
    $.getJSON(cURL, function(data) {
        callback(data);
    });
}

$(function() {
    dahliaMessenger = new directMessage();
});