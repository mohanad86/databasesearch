<?php
require 'setup.php';
if (!isset($_GET['q'])) {
	die('Please set the search parameter (GET parameter "q").');
}
header('Content-type: text/json; charset=utf-8');
$searchParam = '%' . $_GET['q'] . '%';
$moment = microtime(true);
$stmt = $db->prepare('SELECT * FROM product WHERE (serial_number LIKE ? OR name LIKE ?) ORDER BY production_date DESC LIMIT 10');
//if (!$stmt) die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
$countproducts = $stmt->fetchColumn();
if ($countproducts > 0 ){

	$stmt = $db->prepare('SELECT * FROM product WHERE (serial_number LIKE ? OR name LIKE ?)'
				. ' ORDER BY production_date' . min(10, $countproducts));
	$stmt->execute(array($searchParam, $searchParam));
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($countproducts);
}



$stmt->execute(array($searchParam, $searchParam));
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($products);
$queryTime = microtime(true) - $moment;
$output = array(
	'query_time' => $queryTime,
	'products' => $products
);
die(json_encode($output));
