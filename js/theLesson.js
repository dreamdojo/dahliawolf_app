/*
 rousted by:
 _______  _______  _______  _______  _______  _______  _______          
(  ____ \(  ____ \(  ___  )(  ____ \(  ____ \(  ____ )(  ____ \|\     /|
| (    \/| (    \/| (   ) || (    \/| (    \/| (    )|| (    \/( \   / )
| |      | (__    | |   | || (__    | (__    | (____)|| (__     \ (_) / 
| | ____ |  __)   | |   | ||  __)   |  __)   |     __)|  __)     \   /  
| | \_  )| (      | |   | || (      | (      | (\ (   | (         ) (   
| (___) || (____/\| (___) || )      | )      | ) \ \__| (____/\   | |   
(_______)(_______/(_______)|/       |/       |/   \__/(_______/   \_/   
                                                                        
																		*/

var theLesson = new Object();
theLesson.title = {		'/index.php' : 'WELCOME TO DAHLIAWOLF',
                        '/spine.php' : 'DISCOVER AND VOTE',
						'/grid.php' : 'DISCOVER AND VOTE', 
						'/post.php' : 'POST FASHION INSPIRATIONS', 
						'/explore.php': 'MEMBER INSPIRED SHOP',
						'/profile.php': 'PUBLIC PROFILE',
						'/account/invites.php': 'INVITES FRIENDS',
						'/account/posts.php' : 'THINGS YOU POSTED',
						'/account/wild-4s.php' : 'THINGS YOU LOVE',
						'/shop/my-wishlist.php' : 'YOUR WISHLIST',
						'/pinit.php' : 'THE INSPIRE BUTTON',
						'/wolf-pack.php' : 'THE WOLFPACK',
						'/account/settings.php' : 'SETTINGS',
						'/my-runway.php' : 'YOUR RUNWAY',
						'/activity.php' : 'YOUR ACTIVITY',
                        '/inspire.php' : 'INPSIRE NEW FASHION',
                        '/invite.php' : 'FIND FRIENDS',
                        '/shop/index.php' : 'SHOP AND ENJOY'
					};	
theLesson.content = {	'/index.php' : 'You post fashion images. We turn your images into clothing! Dahlia Wolf is a fashion inspiration community where the images you post inspire our newest designs.',
                        '/spine.php' : 'Show some love for your favorite members inspiration images. <br>The most loved images inspire the clothes we make!',
						'/grid.php' : 'Show some love for your favorite members inspiration images. <br>The most loved images inspire the clothes we make!', 
						'/post.php' : 'Share your personal style by posting fashion images. <br>Post images you already have or find new images in our D/W bank.', 
						'/explore.php': 'Shop the newest member inspired designs. <br>Inspired by you. Voted by you. Produced by Dahlia Wolf',
						'/profile.php': 'A collection of all your inspiraion posts, loves and followers. <br>Keep it updated and build your following!',
						'/account/invites.php': 'Invite your friends and get extra points',
						'/account/posts.php' : 'All the inspiration images you posted.',
						'/account/wild-4s.php' : 'All the inspiration images you have showed LOVE for.',
						'/shop/my-wishlist.php' : 'All the MEMBER INSPIRED items you added to your wishlist<br>Support your fellow members and buy something already!',
						'/pinit.php' : 'Add this button to your browser and post images from any site',
						'/wolf-pack.php' : 'These are the top 100 members on Dahlia Wolf. <br>Do you have what it takes to become a pack leader?Be the best of stand out from the rest!',
						'/account/settings.php' : 'This is where you can update your profile and adjust your settings. <br>Write something cool about yourself. Try not to be boring :)',
						'/my-runway.php' : 'These are all the styles you inspired. Keep inspiring and build your personal brand ',
						'/activity.php' : 'Here you can view all the recent activity on Dahlia',
                        '/inspire.php' : 'Post your favorite fashion images and inpsire a new work of art',
                        '/invite.php' : 'Find your friends from Facebook on Dahliawolf or invite them to join you on Dahliawolf',
                        '/shop/index.php' : 'SHOP MEMBER INSPIRED DESIGNS @ DAHLIAWOLF'
					};					

theLesson.postTitle = {'step1' : 'POST FASHION INSPIRATIONS', 'step2' : 'INSPIRE NEW DESIGNS', 'step3' : 'INSPIRATION POERTY' };
theLesson.postContent = {	'step1': 'Share your personal style by posting fashion images.<br> Post images you already have or find new image in our D/W image bank.', 
							'step2' : 'Share images of the styles you would like created. <br> Upload your own images or find new ones in the DW Image Bank.', 
							'step3' : 'Tell everyone what you love about this item. Use #tags and @members to help get your inspirations exposure',
						};
theLesson.height = 230;
theLesson.isOpen = false;
theLesson.speed = 200;

theLesson.toggleMe = theLessonToggleMe;
theLesson.changeTitle = theLessonChangeTitle;
theLesson.changeContent = theLessonChangeContent;
theLesson.showMe = theLessonShowMe;
theLesson.ShowTourGuide = theLessonShowTourGuide;
theLesson.CloseTourGuide = theLessonCloseTourGuide;
theLesson.resetToHome = theLessonResetToHome;
theLesson.checkFloat = theLessonCheckFloat;
theLesson.setSection = theLessonSetSection;
theLesson.init = theLessonInit;
theLesson.checkIfClosedByUser = theLessonCheckIfClosedByUser;
theLesson.toggleButton = theLessonToggleButton;


function theLessonToggleButton(){
	if(theLesson.isOpen){
        theLesson.toggleButtonDisplay.css('background-position',  106+'%');
		//theLesson.toggleButtonDisplay.html('HIDE HELPER');
	}else{
        theLesson.toggleButtonDisplay.css('background-position',  0+'%');
		//theLesson.toggleButtonDisplay.html('SHOW HELPER');
	}
}

function theLessonCheckIfClosedByUser(){
	if(sessionStorage.getItem("closedByUser") == null){
		theLesson.ClosedByUser = false;
	}else{
		theLesson.ClosedByUser = sessionStorage.getItem("closedByUser");
	}if(theLesson.ClosedByUser == 'false'){
		theLesson.ClosedByUser = false;
	}
}

function theLessonInit(str){
	theLesson.display = $('#theLesson');
	theLesson.titleDisplay = $('#lesson-title');
	theLesson.contentDisplay = $('#lesson-content');
	theLesson.toggleButtonDisplay = $('#tourButton');
	theLesson.checkIfClosedByUser();
	theLesson.setSection(str);
	/*theLesson.checkFloat();
	$(window).scroll(function(){
		theLesson.checkFloat();
	});*/
	theLesson.toggleButtonDisplay.bind('click', theLesson.toggleMe);
	$('#lessonCloser').bind('click', theLesson.toggleMe);
	
}


function theLessonSetSection(sect){
	theLesson.section = sect;
	
}

function theLessonCheckFloat(){
	if($(window).scrollTop() <= 0){
		theLesson.display.removeClass('float');	
	}else{
		theLesson.display.addClass('float');
	}
}

function theLessonResetToHome(){
	theLesson.changeTitle(theLesson.title[theLesson.section]);
	theLesson.changeContent(theLesson.content[theLesson.section]);
}

function theLessonCloseTourGuide(){// CLOSE THE TOUR GUIDE
	theLesson.display.slideUp(theLesson.speed);
	theLesson.isOpen = false;
	theLesson.toggleButton();
	sessionStorage.setItem("closedByUser", true);
}
function theLessonShowTourGuide(){//   OPENS THE TOUR GUIDE
    sendToAnal({name:'Opened tour guide', section:theLesson.title[this.section]});
    if(theLesson.title[this.section]){//check to make sure there is info for page
		$(window).scrollTop(0);
        theLesson.changeTitle(theLesson.title[theLesson.section]);
	    theLesson.changeContent(theLesson.content[theLesson.section]);
		theLesson.showMe();
	}
}

function theLessonShowMe(){
	theLesson.display.slideDown(theLesson.speed);
	theLesson.isOpen = true;
	theLesson.toggleButton();
	sessionStorage.setItem("closedByUser", false);
}

function theLessonChangeTitle(str){
	theLesson.titleDisplay.html(str);
}
function theLessonChangeContent(str){
	theLesson.contentDisplay.html(str);
}

function theLessonToggleMe(){
	if(theLesson.isOpen){
		theLesson.CloseTourGuide();
	}else{
		theLesson.ShowTourGuide();
	}
}