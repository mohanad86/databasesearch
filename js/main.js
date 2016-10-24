$(function() { // DOM ready
	$('#search').keyup(function(e) {
		$('#query-time').text('Loading data...');
		$.get('search.php?q=' + $('#search').val(), function(data) {
			$('#query-time').text('SQL query took ' + data.query_time + ' seconds');
			var table = $('#search-results').empty();
			for (var i = 0, l = data.products.length; i < l; i++) {
				var product = data.products[i];
				var row = $('<tr>');
				row.append($('<td>').text(product.id));
				row.append($('<td>').text(product.production_date));
				row.append($('<td>').text(product.serial_number));
				row.append($('<td>').text(product.name));
				table.append(row);
			}
		});
	});
});

// This function for automatic check the time 
setInterval(function(){ 
    $.getJSON('search.php?q=', function(data) {
    $('#query-time').text('SQL query took ' + data.query_time + ' seconds');
    for (var i = 0, l = data.products.length; i < l; i++) {
    var product = data.products[i];
    var table = $('#search-results').empty();
     //console.info("product.production_date");
        $("<td>").text(product.id);
          $("<td>").text(product.production_date);
           $("<td>").text(product.serial_number);
            $("<td>").text(product.name);
           console.info(product.production_date, product.serial_number, product.name);
         }
    });
}, 3000);

