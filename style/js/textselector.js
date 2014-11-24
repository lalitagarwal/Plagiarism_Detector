$(document).ready(function() {
	var highlighter1, highlighter2;
	
	$("#scrollbox1").scrollbar({
		height: 400
    });
	$("#scrollbox2").scrollbar({
		height: 400
    });
	
	var xKeyPressed = false;
	var xKeyCode = 88;

	$(window).keydown(function(e) {
		xKeyPressed = (e.which == xKeyCode);
		}).keyup(function(e) {
			xKeyPressed = !(e.which == xKeyCode);
		});
				
		$('body').on('mouseup', '.highlighted', function(){					
			if (xKeyPressed) {
				$('#scrollbox1').getHighlighter().removeHighlights(this);
				$('#scrollbox2').getHighlighter().removeHighlights(this);
			}
		});
				
		$('#remove-highlights-btn').click(function() {
			$('#scrollbox1').getHighlighter().removeHighlights();
			$('#scrollbox2').getHighlighter().removeHighlights();
		});
		  
		$('#scrollbox1').textHighlighter({
				color: '#99CCFF'
			});

		$('#scrollbox2').textHighlighter({
			color: '#66FF66'
		});
		
		/*$('#serialize-btn').click(function() {
              var jsonStr = highlighter1.serializeHighlights() + highlighter2.serializeHighlights();
              $('textarea').val(jsonStr);
			
			  highlighter1.removeHighlights();
			  highlighter2.removeHighlights();
        });*/
		
        /*$('#next-btn').click(function() {
              //var jsonStr = highlighter1.serializeHighlights() + highlighter2.serializeHighlights();
              //$('textarea').val(jsonStr);
			  $.post("index5.php",
				{
				  docData:"Donald Duck",
				  city:"Duckburg"
				});
              /*$.ajax({
                type: "POST",
                url: "index5.php",
                data: {'docData':  'gh'},
				//success: function(data) {
                    //$('textarea').html(data);
					//alert("Data: " + data);
                //}
				});
			  //highlighter1.removeHighlights();
			  //highlighter2.removeHighlights();
        });*/
		
		//highlighter1 = $('#scrollbox1').getHighlighter();
		//highlighter2 = $('#scrollbox2').getHighlighter();
});