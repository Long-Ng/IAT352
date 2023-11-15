<!-- Filename: form.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Homework 1: Form processing</title>
</head>
<body>
    <h1>Homework 1: Form processing</h1>

    <form method="post" action="processed_form.php">
        <!-- Input fields and other form elements go here -->
        
        Type of Program: <input type="text" name="program" value="Exchange"  style="color: gray">
        <br><br>
        Country <input type="text" name="country" value="Country" style="color: gray">
        <br><br>
        Term <input type="text" name="term" value="Term" style="color: gray">
        <br><br>
        Language of Instruction <input type="text" name="language" value ="Language" style="color: gray">
        <br><br>
        Level of study (at SFU) <select name="level" value ="None">
            <option value="Undergraduate">Undergraduate</option>
            <option value="Graduate">Graduate</option>
            <option value="PhD or Post-Doctoral">PhD or Post-Doctoral</option>
            <option value="PDP">PDP</option>
        </select>
        <input type="submit" value="Submit Name">
    </form>
</body>
</html>
