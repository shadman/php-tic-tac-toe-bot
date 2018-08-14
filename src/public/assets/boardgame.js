
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
		
		// placing desired position
		$(this).val('X');
		var coordinates = ($(this).attr('id')).split(',');
		boardgame[coordinates[0]][coordinates[1]] = 'X';

/*
		var matrix = $("input[id='matrix").val();

		var response = [];
		for(var row=0; row<matrix; row++){
			var data = [];
			for(var col=0; col<matrix; col++){
				data.push($("input[id='box["+row+"]["+col+"]']").val());
			}
			response.push(data);
		}

		$('input').attr({ disabled: true});
		//postdata here

		//render response 
		$("input[id='box[1][1]']").val('O');
		$('input').attr({ disabled: false});
		console.log(response);

		//console.log($('form#boardgame').serializeArray());
		//alert($(this).attr('name'));
		*/
	});


});
