$(function(){

	var requestList = $.ajax({
		method: "GET",
		url: "post.php?1=1",
		dataType: "json"
	});

	requestList.always(function(e){
		console.log(e);
		var table = '';
		for (var k in e){
			table += '<tr><th scope="row">' + e[k].id + '</th>';
			table += '<td>' + e[k].name + '</td>';
			table += '<td>' + e[k].email + '</td>';
			table += '<td>' + e[k].telephone + '</td></tr>';
		}
		$("#contacts tbody").html(table);
	});

	$('#AjaxRequest').submit(function(){
		var form = $(this).serialize();

		var request = $.ajax({
			method: "POST",
			url: "post.php",
			data: form,
			dataType: "json"
		});

		request.done(function(e){
			$('#msg').html(e.msg);
			if(e.status){
				$('#AjaxRequest').each(function(){
					this.reset();
				});

				var table = '<tr><th scope="row">' + e.contacts.id + '</th>';
				table += '<td>' + e.contacts.name + '</td>';
				table += '<td>' + e.contacts.email + '</td>';
				table += '<td>' + e.contacts.telephone + '</td></tr>';
				$("#contacts tbody").prepend(table);
			}
		});

		request.fail(function(e){
			console.log("fail");
			console.log(e);
		});

		request.always(function(e){
			console.log("always");
			console.log(e);
		});

		return false;
	});
})