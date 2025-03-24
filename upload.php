<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $upload_success = [];
    $upload_errors = [];
   
    // Controleer of de directory bestaat, zo niet, maak deze aan
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
   
    // Loop door alle geüploade bestanden
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
   
    <?php if (isset($upload_success) || isset($upload_errors)): ?>
        <?php if (!empty($upload_success)): ?>
            <div class="result success">
                <p><strong>Succesvol geüpload:</strong></p>
                <ul>
                    <?php foreach ($upload_success as $file): ?>
                        <li><?php echo $file; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
       
        <?php if (!empty($upload_errors)): ?>
            <div class="result error">
                <p><strong>Fout bij uploaden:</strong></p>
                <ul>
                    <?php foreach ($upload_errors as $file): ?>
                        <li><?php echo $file; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>
   
    <div class="upload-container">
        <form action="" method="post" enctype="multipart/form-data" id="uploadForm">
            <input type="file" name="filesToUpload[]" id="filesToUpload" class="file-input" multiple required>
            <label for="filesToUpload" class="file-label">Selecteer bestanden</label>
            <div class="selected-files" id="fileList">Geen bestanden geselecteerd</div>
            <input type="submit" value="Upload Bestanden" class="submit-button">
        </form>
    </div>
   
    <script>
        // Script om de geselecteerde bestandsnamen te tonen
        document.getElementById('filesToUpload').addEventListener('change', function(e) {
            const fileList = document.getElementById('fileList');
            if (this.files.length > 0) {
                let fileNames = '<p><strong>Geselecteerde bestanden:</strong></p><ul>';
                for (let i = 0; i < this.files.length; i++) {
                    fileNames += '<li>' + this.files[i].name + '</li>';
                }
                fileNames += '</ul>';
                fileList.innerHTML = fileNames;
            } else {
                fileList.innerHTML = 'Geen bestanden geselecteerd';
            }
        });
    </script>
</body>
</html>
