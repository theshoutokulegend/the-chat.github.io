<?php
$targetDirectory = "files/";

// Check if the directory exists, if not create it
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

$targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
$uploadOk = 1;

if ($uploadOk == 0) {
    echo "File upload failed.";
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // Get the file name
        $fileName = basename($targetFile);

        // Generate a unique message ID
        $messageId = uniqid();

        // Prepare the message data
        $message = [
            "id" => $messageId,
            "username" => $_POST["username"],
            "content" => "uploaded a file: <a href='files/$fileName' target='_blank'>$fileName</a>"
        ];

        // Send the message data as JSON response
        header("Content-Type: application/json");
        echo json_encode($message);
    } else {
        echo "Failed to upload file.";
    }
}
?>