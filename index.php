<?php
require 'setup.php';
define('PRODUCT_COUNT', 5000000);
header('Content-type: text/html; charset=utf-8');
try {
	$stmt = $db->prepare('SELECT COUNT(*) FROM product;');
	$stmt->execute();
	$productCount = $stmt->fetchColumn();
	if ($productCount < PRODUCT_COUNT) {
		if (0 == $productCount) {
			$db->exec('CREATE INDEX product_date ON product(production_date DESC);');
			$db->exec('CREATE INDEX product_name ON product(name);');
			$db->exec('CREATE INDEX product_serial ON product(serial_number);');
		}
		$newProducts = PRODUCT_COUNT - $productCount;
		echo '<p>Generating <strong>' . $newProducts . '</strong> new products. This takes &quot;some&quot; time... (will print a dot for every thousand)</p>';
		ob_flush(); flush();
		$productNames = array('Rubber duck', 'Washing machine', 'Oven', 'Light bulb', 'Regular car', 'Tractor',
			'Book', 'Bike', 'Motorbike', 'Fridge', 'Computer', 'Laptop', 'Door', 'Bag', 'Box');
		$db->beginTransaction();
		echo '<p>';
		for ($i = 0; $i < $newProducts; $i++) {
			$stmt = $db->prepare('INSERT INTO product(serial_number, name, production_date) VALUES(:serial_number, :name, :production_date);');
			$name =  $productNames[array_rand($productNames)] . ' ' . rand(1, 10000);
			$stmt->bindParam(':serial_number', $serial);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':production_date', $date);
			if (0 == $i % 1000) {
				echo '. ';
				ob_flush(); flush();
				$db->commit();
				$db->beginTransaction();
			}
		}
		$db->commit();
		echo '<p>Done.</p>';
	}
}
catch (Exception $e) {
	die($e->getMessage());
}
?>
<html>
<head>
	<title>The search box</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="http://enos.itcollege.ee/~malyhass/databasesearch/js/main.js"></script>
</head>
<body>
	<div class="container-fluid" style="padding-top: 20px;">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading"><h2>The search box</h2></div>
				<div class="panel-body">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
							<input class="form-control" autocomplete="off" placeholder="Filter products by name or serial number" type="text" id="search" />
						</div>
					</div>
					<div><span class="glyphicon glyphicon-time"></span> <span id="query-time"></span></div>
					<div><span class="glyphicon glyphicon-search"></span> <span id="founded"></span></div>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Produced</th>
								<th>Serial</th>
								<th>Name</th>
							</tr>
						</thead>
						<tbody id="search-results"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
