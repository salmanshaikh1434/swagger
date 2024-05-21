<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();
$data = json_decode(file_get_contents("php://input"));

$table = array_keys((array)$data)[0];
$q = 'DESCRIBE ' . $table;
$stmt = $db->prepare($q);
$stmt->execute();

$query = "INSERT INTO " . $table . " (";
$columns = array();
$columnTypes = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $columns[] = "`" . $row['Field'] . "`";
    $columnTypes[$row['Field']] = $row['Type'];
}
$query .= implode(",", $columns) . ") VALUES ";

if (isset($data->$table)) {
    $values = array();
    foreach ($data->$table as $record) {
        $rowValues = array();
        foreach ($columns as $column) {
            $column = str_replace('`', '', $column);
            if (!isset($record->$column) || $record->$column === null) {
                $type = $columnTypes[$column];
                if (strpos($type, 'int') !== false || strpos($type, 'float') !== false) {
                    $value = 0;
                } elseif (strpos($type, 'bool') !== false) {
                    $value = 0;
                } elseif (strpos($type, 'datetime') !== false) {
                    $value = 'NOW()';
                } else {
                    $value = '';
                }
            } else {
                $value = $record->$column;
            }

            $escapedValue = $db->quote($value);
            $columnType = $columnTypes[$column];

            if (strpos($columnType, 'int') !== false || strpos($columnType, 'float') !== false) {
                $rowValues[] = $escapedValue;
            } elseif (strpos($columnType, 'bool') !== false) {
                $rowValues[] = ($value ? '1' : '0');
            } else {
                $rowValues[] = $escapedValue;
            }
        }
        $values[] = "(" . implode(",", $rowValues) . ")";
    }
    $query .= implode(",", $values);
    $query .= " ON DUPLICATE KEY UPDATE ";

    $updateValues = array();
    foreach ($columns as $column) {
        $column = str_replace('`', '', $column);

        if ($column == 'tstamp') {
            $updateValues[] = "`tstamp`" . "=" . 'NOW()';
        } else {
            $updateValues[] = "`" . $column . "`" . "=VALUES(" . "`" . $column . "`" . ")";
        }
    }
    $query .= implode(",", $updateValues);
}


$stmt = $db->prepare($query);
if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(array("message" => "UPDATED.."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "ERROR UPDATING!!"));
}
