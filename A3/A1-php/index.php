<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/phpstyles.css">

    <title>All recipe</title>
</head>
<body>
    <h1>RECIPE LIBRARY</h1>
    <nav>
        <ul>
            
            <li><a href="index.php">All Recipe</a></li>
            <li><a href="add-recipe.php">Add Recipe</a></li>
        </ul>
    </nav>
    
    <?php
        
        $assArr = array(
            "road" => "Personal vehicle or bus",
            "air" => "Plane",
            "water" => "ferry or personal boat");
        

        function radio_format($radioGroupName, $valueArr){
            echo"<td>$radioGroupName</td>";
    
            foreach ($valueArr as $key => $value){
                echo "<br><input type=\"radio\" name=\"$radioGroupName\" value = \"$key\">$value"; 
            }
        }

        radio_format("groupname",$assArr)
    

    ?>
</body>
</html>