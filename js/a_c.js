	$("#inline_content").colorbox({inline:true, width:"50%"});
	
	var A_look = 'tags'
	var A_url = "ajax/search.php?tags=";
	var S_url = "ajax/search.php?tags=";

	$('#drop').dropkick({
		change: function (value, label) {
			switch (value) {
			case 'tags':
				A_look = 'tags';
				A_url = "ajax/suggestions.php?tags=";
				S_url = "ajax/search.php?tags=";
			break;
			case 'users':
				A_look = 'users';
				A_url = "ajax/suggestions.php?users=";
				S_url = "ajax/search.php?users=";
			break;
			case 'location':
				A_look = 'location';
				A_url = "ajax/suggestions.php?location=";
				S_url = "ajax/location.php?address=";
			break;
			default:
				A_look = 'tags';
				A_url = "ajax/suggestions.php?tags=";
				S_url = "ajax/search.php?tags=";
				break;
			}
		}
	});
	
	$('#query').keyup(function() {
	switch (A_look) {
		case 'tags':
		$('#query').autocomplete({
			source: function( request, response ) {
			$.ajax({
			type: "GET",
			url: "ajax/suggestions.php",
			dataType: "json",
			data: { 
				"tags" : request.term
			},
			success: function( data ) {
            var terms = [];

            for (var i = 0; i < data[1].length; i++) {
                terms.push(data[1][i][0]);
            }

            response(terms);
			}
			});
		},
		minLength: 2
		});
		break;
		case 'users':
		$('#query').autocomplete({
			source: function( request, response ) {
			$.ajax({
			type: "GET",
			url: "ajax/suggestions.php",
			dataType: "json",
			data: { 
				"users" : request.term
			},
			success: function( data ) {
				related = data[1];
				response(data[1]);
			}
			});
		},
		minLength: 2
		});
		break;
		case 'location':
		$('#query').autocomplete({
			source: function( request, response ) {
			$.ajax({
			type: "GET",
			url: "ajax/suggestions.php",
			dataType: "json",
			data: { 
				"location" : request.term
			},
			success: function( data ) {
				related = data[1];
				response(data[1]);
			}
			});
		},
		minLength: 2
		});
		break;
		default:
		$('#query').autocomplete({
			source: function( request, response ) {
			$.ajax({
			type: "GET",
			url: "ajax/suggestions.php",
			dataType: "json",
			data: { 
				"tags" : request.term
			},
			success: function( data ) {
				related = data[1];
				response(data[1]);
			}
			});
		},
		minLength: 2
		});
		break;
	}
	});