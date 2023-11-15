
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/phpstyles.css">
    <title>Add recipe</title>
</head>
<body>
    <h1> ADD NEW RECIPE </h1>
    <nav>
        <ul>
            <li><a href="index.php">All Recipe</a></li>
            <li><a href="add-recipe.php">Add Recipe</a></li>
        </ul>
    </nav>
<?php
    $count = 10;
    require('form-functions.php');

    $qtyArr= array_fill(0, $count, null);
    $measurementArr=array_fill(0, $count, null);
    $itemArr=array_fill(0, $count, null);
    if( isset($_GET['title'])) $title=($_GET['title']); 
    if( isset($_GET['description'])) $description=($_GET['description']); 
	if( isset($_GET['type'])) $type=($_GET['type']); 
	if( isset($_GET['size'])) $size=$_GET['size']; 
	if( isset($_GET['prephrs'])) $prephrs=$_GET['prephrs']; 
    if( isset($_GET['prepmins'])) $prepmins=$_GET['prepmins']; 
    if( isset($_GET['cookhrs'])) $cookhrs=$_GET['cookhrs']; 
    if( isset($_GET['cookmins'])) $cookmins=$_GET['cookmins']; 
//needtag and steps
    if( isset($_GET['qtyArr'])) $qtyArr=$_GET['qtyArr']; 
    if( isset($_GET['measurementArr'])) $measurementArr=$_GET['measurementArr']; 
    if( isset($_GET['itemArr'])) $itemArr=$_GET['itemArr']; 
    if( isset($_GET['steps'])) $steps=$_GET['steps']; 
    if( isset($_GET['tags'])) $tags=$_GET['tags']; 


    // echo "Title: " . (isset($title) ? $title : "none") . "<br>";
    // echo "Description: " . (isset($description) ? $description : "") . "<br>";
    // echo "Type: " . (isset($type) ? $type : "") . "<br>";
    // echo "Size: " . (isset($size) ? $size : "") . "<br>";
    // echo "Preparation Hours: " . (isset($prephrs) ? $prephrs : "") . "<br>";
    // echo "Preparation Minutes: " . (isset($prepmins) ? $prepmins : "") . "<br>";
    // echo "Cooking Hours: " . (isset($cookhrs) ? $cookhrs : "") . "<br>";
    // echo "Cooking Minutes: " . (isset($cookmins) ? $cookmins : "") . "<br>";
    // echo "qty: " . (isset($qtyArr) ? implode(',', $qtyArr) : "") . "<br>";
    // echo "measurement: " . (isset($measurementArr) ? implode(',', $measurementArr) : "") . "<br>";
    // echo "item: " . (isset($itemArr) ? implode(',', $itemArr) : "") . "<br>";
    // echo "steps: " . (isset($steps) ?  $steps : "") . "<br>";
    // echo "tags: " . (isset($tags) ?  $tags : "") . "<br>";
 

    $count = 10;



    $incomplete = true;
    $incomplete = !empty($title) || !empty($type) || !empty($prephrs) || !empty($prepmins) || !empty($cookhrs) || !empty($cookmins);




 

    echo "<div class = \"dropshadow\">";
    echo "<p style= \"text-align: center; color:red\">";
    if (isset($_GET['message'])) {
        if(count($_GET['message']) > 0){
            foreach ($_GET['message'] as $val){
                echo $val . "<br>";
            }
        }
    } else {
        echo "Please fill in the required fields";
    }
    echo "</p>";
    echo "<hr><br><h2> Basic information</h2>";
    
    //echo "<form method=\"get\" action=\"process-recipe.php\">";
    echo "<form method=\"get\" action=\"process-recipe.php\">";

    echo "<table style = \" border-width:1px; width: 45vw\">";
    //title
    echo "<tr class=\"no-border num-col\" width: 45vw\">";
    makeInputField("","Recipe Title*","title",true,$incomplete);
    echo "</tr>";
    //description
    echo "<tr>";
    makeTextAreaField("","Recipe Description","description",false,$incomplete);
    echo "</tr>";
    echo "</table>";
    echo "<hr><br><h2> Size </h2>";
    echo "<table class=\"small-table\" style = \" border-left: solid; border-right: solid; border-width:1px; width: 45vw\">";
    //make serve
    echo "<tr style=\"border-collapse: collapse; border-top: 1px solid black; border-bottom: 1px solid black; height: 60px\">";
    makeRadioButtonGroup("This recipe*: ", "type", ['makes','serves'],['makes','serves'],true,$incomplete);
    makeInputField("","Size *","size",true,$incomplete);
    echo "</tr>";
    //preptime
    echo "<tr style=\"border-collapse: collapse; border-top: 1px solid black; border-bottom: 1px solid black; height: 60px\">";
    makeInputField("Prep time*","Hrs*","prephrs",true,$incomplete);
    makeInputField("","Mins*","prepmins",true,$incomplete);
    echo "</tr>";
    //cooktime
    echo "<tr style=\"border-collapse: collapse; border-top: 1px solid black; border-bottom: 1px solid black; height: 60px\">";
    makeInputField("Cook time*","Hrs*","cookhrs",true,$incomplete);
    makeInputField("","Mins*","cookmins",true,$incomplete);
    echo "</tr>";
    echo "</table>";



    echo "<hr><br><h2> Ingredients </h2>";
    //ingredient
    echo "<table style = \" border-left: solid; border-right: solid; border-width:1px; width: 45vw\">";
    makeDuplicateRows(10,$qtyArr,$measurementArr,$itemArr,$incomplete);
    echo "</table>";


    //step
    echo "<hr><br><h2> Steps </h2>";
    echo "<table class=\"no-border num-col\">";
    echo "<p class=\"num-col\"> Enter each step on a separated line one at a time </p>";
    echo makeTextAreaField("","E.x: Crack eggs \nHeat up pan \nWatch TV...","steps",false,$incomplete);
    echo "</table>";

    echo "<hr><br><h2> Tags </h2>";
    //tags
    echo "<table>";
    echo "<tr>";
    echo "<p class=\"num-col\"> Enter each tags separated by a comma </p>";
    echo makeTextAreaField("","E.x: easy, simple, breakfast, egg, howto, basic","tags",false,$incomplete);
    echo "<tr>";
    echo "</table>";

    // $qtyArr= arraylizeEntries($count,"qty_");
    echo "<div style=\"text-align: center\">";
    echo "<tr><td style=\"text-align: center\"><input type=\"submit\" class= \"button-link\" name=\"submit\" border=0 value=\"Submit\"></td></tr>";
    echo "</div>";
	echo "</table></form>";
    echo "</form>";
    echo "</div>"

    //check incomplete

?>

</body>
</html>