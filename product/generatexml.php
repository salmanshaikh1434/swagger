<?php

// Connect to MySQL database
$mysqli = new mysqli("localhost", "u_asidb", "RooT@@123", "asidb");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch data from MySQL table
$result = $mysqli->query("SELECT * FROM glb limit 10");

// Create a new SimpleXMLElement object
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="Windows-1252" standalone="yes"?><VFPData></VFPData>');

// Loop through the fetched rows
while ($row = $result->fetch_assoc()) {
// Add a new 'resultcur' element for each row
$resultcur = $xml->addChild('resultcur');
foreach ($row as $key => $value) {
// Add child elements for each column in the row
$resultcur->addChild($key, htmlspecialchars($value));
}
}

// Save the XML to a file
$xml->asXML('output.xml');

// Close MySQL connection
$mysqli->close();

echo "XML file generated successfully.";

?>