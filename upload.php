echo '<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $upload_success = [];
    $upload_errors = [];

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (isset($_FILES["filesToUpload"])) {
        $fileCount = count($_FILES["filesToUpload"]["name"]);

        for ($i = 0; $i < $fileCount; $i++) {
            if ($_FILES["filesToUpload"]["error"][$i] == 0) {
                $target_file = $target_dir . basename($_FILES["filesToUpload"]["name"][$i]);

                if (move_uploaded_file($_FILES["filesToUpload"]["tmp_name"][$i], $target_file)) {
                    $upload_success[] = htmlspecialchars(basename($_FILES["filesToUpload"]["name"][$i]));
                } else {
                    $upload_errors[] = htmlspecialchars(basename($_FILES["filesToUpload"]["name"][$i]));
                }
            } else {
                $upload_errors[] = "Bestand #" . ($i + 1) . " heeft een fout: " . $_FILES["filesToUpload"]["error"][$i];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestanden Uploaden</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .upload-container {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .file-input {
            display: none;
        }
        .file-label {
            background-color: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            margin: 10px 0;
            font-size: 16px;
        }
        .submit-button {
            background-color: #2196F3;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
        }
        .selected-files {
            margin: 15px 0;
            text-align: left;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .error {
            background-color: #ffebee;
            color: #c62828;
        }
    </style>
</head>
<body>
    <h1>Bestanden Uploaden</h1>
</body>
</html>' 
