<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MP3 Album Cover Extractor</title>
</head>
<body>
    <h2>MP3 Album Cover Extractor</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="mp3File">Select MP3 File:</label><br>
        <input type="file" id="mp3File" name="mp3File" accept=".mp3, .m4a"><br><br>
        <input type="submit" value="Extract Album Cover" name="submit">
    </form>
    <hr>

    <?php
   require __DIR__ . '../../vendor/autoload.php';
   
    // Check if form is submitted
    if (isset($_POST['submit'])) {
        // Check if MP3 file is uploaded
        if (isset($_FILES['mp3File']) && $_FILES['mp3File']['error'] === UPLOAD_ERR_OK) {
            // Path to the uploaded MP3 file
            $mp3FilePath = $_FILES['mp3File']['tmp_name'];

            // Initialize getID3
            $getID3 = new getID3;

            // Extract metadata from the MP3 file
            $fileInfo = $getID3->analyze($mp3FilePath);

            // Check if embedded image exists
            if (isset($fileInfo['comments']['picture'][0]['data'])) {
                // Get the embedded image data
                $imageData = $fileInfo['comments']['picture'][0]['data'];

                // Get the MIME type of the embedded image
                $imageMime = $fileInfo['comments']['picture'][0]['image_mime'];

                // Output the embedded image
                echo '<h3>Extracted Album Cover:</h3>';
                echo "<img src='data:$imageMime;base64," . base64_encode($imageData) . "' alt='Album Cover'>";
            } else {
                echo '<p>No embedded image found in the MP3 file.</p>';
            }
        } else {
            echo '<p>Error uploading MP3 file.</p>';
        }
    }
    ?>
</body>
</html>
