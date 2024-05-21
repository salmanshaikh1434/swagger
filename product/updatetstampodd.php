<?php

	include_once '../config/database.php';
    $batchSize = 5000;
	$updated = 0;
	$database = new Database();
	$db = $database->getConnection();

    $sqlUpdate = "
    UPDATE odd
    SET tstamp = (
    SELECT tstamp
    FROM ohd
    WHERE ohd.`order` = odd.`order`
    )
    WHERE EXISTS (
    SELECT 1
    FROM ohd
    WHERE ohd.`order` = odd.`order`
    )  LIMIT $batchSize
    ";
    
    $stmt = $db->query($sqlUpdate);

    while ($stmt !== false) {
        $affectedRows = $stmt->rowCount();
        
        if ($affectedRows > 0) {
            $updated += $affectedRows;
            echo "Batch updated successfully. Total updated: $updated<br>";
        } else {
            echo "No more records to update.<br>";
            break;
        }
    }
?>
