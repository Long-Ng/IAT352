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
        echo "<div class = \"dropshadow\">";
        echo "<table>\n";
        echo "<hr><h2>All recipes</h2><hr>";
        echo "<tr><th>ID</th><th>Recipe name</th><th>Prep time</th><th>Cook time</th><th>Serves</th><th class=\"cell-fit-content\"></th></tr>";
        global $docroot;
        $docroot = $_SERVER['DOCUMENT_ROOT'];
        if(!file_exists("$docroot/HoangLong_Nguyen_A1/data/recipelist.csv")){
            echo "<p class=\"num-col\">No recipe found, let's make one</p>";
            echo "<div style=\" margin: auto\" class=\"num-col\"><a class =\"button-link\" style=\" margin: auto\" href=\"add-recipe.php\">Add Recipe</a></div></li>";
            exit;
        }
        else{
            $fp = fopen("$docroot/HoangLong_Nguyen_A1/data/recipelist.csv",'r');
        }

        if(!$fp) {
            echo "<p>f open fail<e>";
			echo "<strong>Unable to open data file.</strong>";
			exit;
        }
        else{
            
           
            while($line = fgetcsv($fp)){

                echo "<tr>";
                echo "<td class=\" num-col \">". $line[0]. "</td>";
                echo "<td>". $line[1]. "</td>";
                echo "<td class=\" num-col \">". $line[5]. ":"  . $line[6] . "</td>";
                echo "<td class=\" num-col \">". $line[7]. ":"  . $line[8] . "</td>";
                echo "<td class=\" num-col \">". $line[4]. "</td>";
                echo "<td><a class=\"button-link\" href=\"details.php?ID=" . $line[0] . "\">Detail ></a></td>";
                 
            }
            echo "</table>";
        }
        echo "</div>";

    ?>
</body>
</html>