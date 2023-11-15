<!DOCTYPE html>
<!-- Filename: processed_form.php -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output</title>
</head>
<body>
    <h1>Form submitted</h1>
    <p>Your application is successfully submitted. The following information is listed in the application:</p>
    <?php
    echo "<p>Type of Program:" . $_POST['program'] . "\n</p>";
    echo "<p>Country: " . $_POST['country'] . "\n</p>";
    echo "<p>Term: " . $_POST['term'] . "\n</p>";
    echo "<p>Language of Instruction: " . $_POST['language'] . "\n</p>";
    echo "<p>Level of study (at SFU): " . $_POST['level'] . "\n</p>";
    ?>

    <h2>Thank you</h2>
</body> 
</html>
