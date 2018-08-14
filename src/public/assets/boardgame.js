
$(document).ready(function () {
  // Function code here.

	var url = 'http://localhost/challenge/php-tic-tac-toe-bot/src/v2';
	var boardgame = [];


	$.get(url+"/matrix", function(matrixSize){
		var rows = [];
		for(var row=0; row<matrixSize; row++){
			cols = [];
			for(var col=0; col<matrixSize; col++){
				//var inputbox = $('<input/>').attr({ type: 'text', id:"box["+row+"]["+col+"]", value:'', class: 'box'});
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


	$(document).on('click', 'input', function(){ 
		
		// placing player move on desired position
		$(this).val('X').attr({ disabled: true});
		//$('input').attr({ disabled: true});

		// updating board matrix to send 
		var coordinates = ($(this).attr('id')).split(',');
		boardgame[coordinates[0]][coordinates[1]] = 'X';

		//post data to api
		/*
		$.post( url+'/move', JSON.stringify({'boardState' : boardgame, 'playerUnit' : 'X'}) ).done(function( data ) {
			console.log( "Data Loaded: " + data[0] );

			//render response 
			$("input[id='"+data[0]+","+data[1]+"'").val('O');
			$('input').attr({ disabled: false});

		});
		*/

		$.ajax({
			url: url+'/move',
			method: 'POST',
			dataType: 'json',
			contentType: "text/json; charset=utf-8",
			data: JSON.stringify({'boardState' : boardgame, 'playerUnit' : 'X'}),
			success: function(data, statusText, xhr){

				if (data[0]!=null && data[1]!=null ) {
					$("input[id='"+data[0]+","+data[1]+"'").val(data[2]).attr({ disabled: true });
					boardgame[data[0]][data[1]] = 'O';
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

		/*$.ajax({
			type: "POST",
			url: url+'/move',
			data: boardgame,
			success: success,
			dataType: dataType
		});*/

		//postdata here

		//console.log(response);

		//console.log($('form#boardgame').serializeArray());
		//alert($(this).attr('name'));
		
	});


});
