function directMessage() {
    this.apiUrl = '/api/1-0/message.json?function=';

    this.$overlay = $('#theOverlay');
}

directMessage.prototype.close = function() {
    this.$container.remove();
    this.$overlay.fadeOut(200);
}

directMessage.prototype.createBox = function(username) {
    this.$container = $('<div id="messengerBox"></div>').appendTo('body').append('<div class="titleBar">New Message</div>');
    this.$titleBar = $('<div id="closeUpload">X</div>').appendTo('#messengerBox .titleBar').on('click', $.proxy(this.cancel, this) );
    this.$addressBar = $('<input type="text" class="socialize" id="addressBar" value="'+username+'">').appendTo( this.$container );
    this.$contents = $('<textarea id="messageContents" maxlength="250" placeholder="Enter message here..."></textarea>').appendTo( this.$container );
    $('<div class="submitMessage">SEND</div>').appendTo(this.$container).on('click', $.proxy(this.submitMessage, this) );
    this.$container.fadeIn(500);
}

directMessage.prototype.cancel = function() {
    this.close();
}

directMessage.prototype.submitMessage = function() {
    var theMsg = this.$contents.val().trim();
    var recipients = this.$addressBar.val().trim();
    var msgHead = encodeURI('Personal Message from '+theUser.username);

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

    this.apiCall( 'send_message', {to_user_name : recipients, from_user_id: theUser.id, header : msgHead, body : theMsg, use_hmac_check : 0}, function(data) {
        alert('Message Sent');
    });

    this.close();
}

directMessage.prototype.getRecipients = function(str) {
    if(str !== '') {
        str = str.replace(/ /g,",");
        var user_array = str.split(',');
        $.each(user_array, function(index, user) {
            if(user.length < 2) {
                user_array.remove(index);
            }
        });
        str = user_array.toString();
        return str;
    } else {
        return false;
    }
}

directMessage.prototype.error = function(msg) {
    alert(msg);
}

directMessage.prototype.newMessage = function(username) {
    if(theUser.id) {
        var _this = this;
        this.$overlay.fadeIn(300, function() {
            _this.createBox(username);
        });
    } else {
        new_loginscreen();
    }
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