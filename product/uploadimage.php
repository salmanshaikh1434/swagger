<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$uploadDirectory = "../uploads/";
if (!file_exists($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}

$bulk = json_decode(file_get_contents("php://input"));

$stmt = $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->beginTransaction();

$success = true;

foreach ($bulk->records as $data) {
    $image = $data->file->value;
    $imageName = $data->file->options->filename;


    $uniqueFilename = uniqid() . '_' . $imageName;
    $targetPath = $uploadDirectory . $uniqueFilename;


    if (move_uploaded_file($image, $targetPath)) {
        try {
            $query = "UPDATE inv SET `image` = :image, `tstamp` = NOW() WHERE `sku` = :sku";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':sku', $data->sku);
            $stmt->bindParam(':image', $targetPath);
            $stmt->execute();
        } catch (PDOException $e) {
            $success = false;
            $message = $e->getMessage();
            echo $message;
        }
    } else {
        $success = false;
        echo "Failed to move uploaded file.";
    }
}

if ($success) {
    $db->commit();
    http_response_code(200);
    echo json_encode(array("message" => "UPDATED.."));
} else {
    $db->rollBack();
    http_response_code(503);
    echo json_encode(array("message" => "ERROR UPDATING!!"));
}
?>