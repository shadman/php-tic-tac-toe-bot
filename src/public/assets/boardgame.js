
$(document).ready(function () {

  	// Configuration
	var url = 'http://localhost/challenge/php-tic-tac-toe-bot/src/v1';
	
	// Board matrix, to hold all moves
	var boardgame = [];


	/*
	* Getting matrix size from tic tac toe API, to make things fully dynamic
	* As all business logics are present in services
	*/
	$.get(url+"/matrix", function(matrixSize){
		var rows = [];
		for(var row=0; row<matrixSize; row++){
			cols = [];
			for(var col=0; col<matrixSize; col++){
				var inputbox = $('<input/>').attr({ type: 'text', id:row+","+col, value:'', class: 'box'});
				$("#board").append(inputbox);
				cols.push('');
			}
			rows.push(cols);
			$("#board").append("<br>");
		}

		// retain board matrix to set values, to make things optimize
		boardgame = rows;
		var hiddenbox = $('<input/>').attr({ type: 'hidden', id:"matrix", value:matrixSize});
		$("#board").append(hiddenbox);
	});


	/*
	* On clicking boxes, this function will be called to send moves to the server
	* and getting bot move from the server 
	*/
	$(document).on('click', 'input', function(){ 
		
		// Placing player move on desired position
		$(this).val('X').attr({ disabled: true});

		// Updating board matrix to send 
		var coordinates = ($(this).attr('id')).split(',');
		boardgame[coordinates[0]][coordinates[1]] = 'X';


		// Posting move to the API and getting bot move
		$.ajax({
			url: url+'/move',
			method: 'POST',
			dataType: 'json',
			contentType: "text/json; charset=utf-8",
			data: JSON.stringify({'boardState' : boardgame, 'playerUnit' : 'X'}),
			success: function(data, statusText, xhr){

				if (data[0]!=null && data[1]!=null ) {
					$("input[id='"+data[0]+","+data[1]+"'").val(data[2]).attr({ disabled: true });
					boardgame[data[0]][data[1]] = data[2];
				} 

					if (xhr.status===201) { 
						$('#message').html(data[3]);
						$('input').attr({ disabled: true});
					}

			},
			error: function(xhr, statusText, err){
				alert("Something went wrong or API not working - Error:" + xhr.status); 
			}
		});
		
	});

});
