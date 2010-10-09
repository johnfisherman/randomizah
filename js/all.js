	// global = hackish
	// we'll jump to this URL
	var url;
	// Start the countdown at *step*
	var step = 3;
	
	$(document).ready( function() {

		$('#theButton').click(function() {

			// Fetch the words, JSON style
			$.ajax({
				method: "get", url:"engine.php",dataType: "json",
				complete: function(){ },
				success: function(wordyJson){
					 
					$.log('wordyJson length : ' + wordyJson.length);
					
					// build a div hosting the triggering words ...
					var wordList = '<div>';
					
					// that will feature on the url
					url = 'http://www.google.com/search?q=';
					
					for (var i = 0; i < wordyJson.length; i++) {
						
						currentWord = wordyJson[i];
						
						wordList += '<div>';
						wordList += currentWord;
						wordList += '</div>';
					
						url += currentWord;
						
						// do not add a plus if last word
						if(i != wordyJson.length - 1)  {
							url += '+';
						}
						
					}
					
					wordList += '</div>';
					
					url += "&btnI=I%27m+Feeling+Lucky";
					
					// display the words
					$("#words").html(wordList);
					
					// trigger countdown
					var timeoutID = window.setTimeout('countdown()', 1000);
					
		 		},
				error: function(html, textStatus, errorThrown){ //
					$("#feedback").val("Could not perform operation. Possible reason: " + textStatus + " or " + errorThrown); //show the html inside .content div
					$("#feedback").css("visibility", "visible");
					
		 		}


			}); //close $.ajax(
			
		});
		
	});

	function countdown() {
		
		// break recursion, jumpt to new page.
		if (step == 0) {
			window.location=url;
		} else {

			step--;
			$.log('step : ' + step);
			
			// recursive call
			var timeoutID = window.setTimeout('countdown()', 1000);
			
			// update timer
			$('#countdownTimer').html(step);
		}
		
	}