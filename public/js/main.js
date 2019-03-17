var airports = document.getElementById('airports');

if (airports) {

	airports.addEventListener('click', function(e) {

		console.log(airports);
		if(e.target.className === 'btn btn-danger delete-airport'){
			var airportToDelete = e.target.getAttribute('data-name');
			if(confirm('Are you sure you want to delete ' + airportToDelete + ' ?')) {
				
				const id = e.target.getAttribute('data-id').toString();
				var url = "/airports/delete/" + id;

				$.ajax({ 
					url: '{{ path('delete-airport', { 'id': id })}}' ,
					method : 'POST'

				}).success(function(res){

					console.log(result)
				 	window.location.reload();
				}).fail(function(err){
					console.log(err);
				});
			}
		}
	});
}
