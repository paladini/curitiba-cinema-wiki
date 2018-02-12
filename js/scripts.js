  function designer_slider(site_url) {
  
        my_slider_counter = 0;
        curr_slide = 0;
        nav_slider_counter = 0;
        
        $(".slide_nav_cont ul").empty();
	$('.slide_thumbs_cont').html('');
        $('#slideshow .slide_box').each(function() {
            $(this).addClass('slide_' + my_slider_counter);
		
		if(my_slider_counter < 5) {
			
			$('.slide_thumbs_cont').append( '<img src="' + site_url + '/timthumb.php?src=' + $('.slide_' + my_slider_counter).find('img').attr('src') + '&h=90&w=179" />' );
		}
		
            my_slider_counter++;
           
             //if(my_slider_counter == 1)
               //$('.slide_nav_cont ul').append('<li class="current"></li>');
             //else
              //$('.slide_nav_cont ul').append('<li></li>');
        });
        
        $('.slide_thumbs_cont img').each(function() {
            $(this).attr('alt',nav_slider_counter);
            nav_slider_counter++;
        });                
        
        function home_switch_slide() {
  
            if(curr_slide >= my_slider_counter)
                curr_slide = 0;
            else if(curr_slide < 0)
                curr_slide = (my_slider_counter-1);
                
            //alert(curr_slide);
            
            $('.slide_' + curr_slide).fadeIn(750);
            //$('.slide_nav_cont ul li').removeClass('current');
            //$('.slide_nav_cont ul li[alt="' + curr_slide + '"]').addClass('current');
            
                
        }
        
        function hide_curr_slide() {
               $('.slide_' + curr_slide).stop();
               $('.slide_' + curr_slide).fadeOut(400);
        }
        
        function next_slide_slider(jump_to_slide) {
            hide_curr_slide(); 
            
            if(jump_to_slide == null)
                curr_slide++;     
            else 
                curr_slide = jump_to_slide;
            
            t_slide=setTimeout(home_switch_slide,50); 
            //home_switch_image();
        }
        
        function prev_slide_slider(jump_to_slide) {
            hide_curr_slide();
            
            
//            curr_slide--;        
            if(jump_to_slide == null)
                curr_slide--;     
            else 
                curr_slide = jump_to_slide;
            //home_switch_image();
            t_slide=setTimeout(home_switch_slide,50);
        }        
        
        $('.slide_prev').click(function() {
          
            prev_slide_slider();
            clearInterval(intervalID_slide);
            //clearInterval(t_slide);
            intervalID_slide = setInterval(next_slide_slider, 8000);
        });
        
        $('.slide_next').click(function() {
            
            next_slide_slider();
            clearInterval(intervalID_slide);
            intervalID_slide = setInterval(next_slide_slider, 8000);
        });                
        
        $('.slide_thumbs_cont img').click(function() {
            
            clearInterval(intervalID_slide);
            next_slide_slider($(this).attr('alt'));
		
            
            //clearInterval(t_testi);
            intervalID_slide = setInterval(next_slide_slider, 8000);            
        
        });        
	
if((navigator.userAgent.match(/iPhone/i)) || 
 (navigator.userAgent.match(/iPod/i))) {	
	 
 } else {
	$('.slide_box').hover(
		function() {
			clearInterval(intervalID_slide);
		},
		function() {
			intervalID_slide = setInterval(next_slide_slider, 8000);            
		}
	);	
}	
        
        //setInterval(next_slide_image, 5000);
        intervalID_slide = setInterval(next_slide_slider, 8000);  
  
  
  }
  
  
  
  
function fire(e) { alert('hi'); }
function touchHandler(event)
{
    var touches = event.changedTouches,
        first = touches[0],
        type = "";
    switch(event.type)
    {
       case "touchstart": type = "mousedown"; break;
       case "touchmove":  type = "mousemove"; break;        
       case "touchend":   type = "mouseup"; break;
       default: return;
    }
    //initMouseEvent(type, canBubble, cancelable, view, clickCount, 
    //           screenX, screenY, clientX, clientY, ctrlKey, 
    //           altKey, shiftKey, metaKey, button, relatedTarget);
    var simulatedEvent = document.createEvent("MouseEvent");
    simulatedEvent.initMouseEvent(type, true, true, window, 1, 
                          first.screenX, first.screenY, 
                          first.clientX, first.clientY, false, 
                          false, false, false, 0/*left*/, null);
    first.target.dispatchEvent(simulatedEvent);
    event.preventDefault();
}
function init() 
{
    document.addEventListener("touchstart", touchHandler, true);
    document.addEventListener("touchmove", touchHandler, true);
    document.addEventListener("touchend", touchHandler, true);
    document.addEventListener("touchcancel", touchHandler, true);    
}  
  
  
  
  
      $(document).ready(function() {
        $(window).bind('resize', function(){
            if($(this).width() > 500)
                $('.mobile_top ul').css('display','block');
            else 
               $('.mobile_top ul').css('display','none');
        }).resize();      
       
       
        $('.header_menu li').hover(
            function () {
                $('ul:first', this).css('display','block');
     
            }, 
            function () {
                $('ul:first', this).css('display','none');         
            }
        );               
	//init();
	//$(document).trigger('retrieve.infscr');
	/*$('.load_more_text a').click(function(e) {
	//$('.load_more_text a').on('click touchstart', function(e) {
	//$('.load_more_text a').bind( "touchstart", function(e) {
		alert('test');
		e.preventDefault();
		$(document).trigger('retrieve.infscr');
	});*/
	    	    
        
    });