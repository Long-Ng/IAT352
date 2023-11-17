<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/phpstyles.css">
    <title>Recipe Saved!</title>
</head>
<body>
    <h1> RECIPE SAVED </h1>
    <nav>
        <ul>
            <li><a href="index.php">All Recipe</a></li>
            <li><a href="add-recipe.php">Add Recipe</a></li>
        </ul>
    </nav>
<?php


$count = 10;


require('form-functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $_GET['message'] = array("");
    $_GET['errorcode'] = array("");

    if( isset($_GET['title'])) $title=($_GET['title']); 
    if( isset($_GET['description'])) $description=($_GET['description']); 
	if( isset($_GET['type'])) $type=($_GET['type']); 
	if( isset($_GET['size'])) $size=$_GET['size']; 
	if( isset($_GET['prephrs'])) $prephrs=$_GET['prephrs']; 
    if( isset($_GET['prepmins'])) $prepmins=$_GET['prepmins']; 
    if( isset($_GET['cookhrs'])) $cookhrs=$_GET['cookhrs']; 
    if( isset($_GET['cookmins'])) $cookmins=$_GET['cookmins']; 
    
    if( isset($_GET['steps'])) $steps=$_GET['steps']; 
    if( isset($_GET['tags'])) $tags=$_GET['tags']; 


    $qtyArr= array_fill(0, $count, null);
    $measurementArr=array_fill(0, $count, null);
    $itemArr=array_fill(0, $count, null);
    for ($i = 0; $i < 10; $i++) {
        $qtyArr[$i]=$_GET["qty_$i"];
        $measurementArr[$i]=$_GET["measurement_$i"];
        $itemArr[$i]=$_GET["item_$i"];
    }

    $_GET['qtyArr']=$qtyArr;
    $_GET['measurementArr']=$measurementArr;
    $_GET['itemArr']=$itemArr;

    if(!validatingFormRequired()){
        array_push($_GET['message'],"Please fill in the required fields");
        array_push($_GET['errorcode'],1);


        $getParams=http_build_query($_GET);
        $redirectUrl = "add-recipe.php" . ($getParams ? "?" . $getParams : "");
        header("Location: " . $redirectUrl);  
    }

    //todo: fix this and add arraylize these entries with a differnet functiom
    if(!validatingQtyEntry($qtyArr,$count)){
        
        array_push($_GET['errorcode'],2);
        $getParams=http_build_query($_GET);
        $redirectUrl = "add-recipe.php" . ($getParams ? "?" . $getParams : "");
        header("Location: " . $redirectUrl);
 
    }

    if(!validatingNumericTime()){
        
        array_push($_GET['errorcode'],4);
        $getParams=http_build_query($_GET);
        $redirectUrl = "add-recipe.php" . ($getParams ? "?" . $getParams : "");
        header("Location: " . $redirectUrl);
 
    }

    if(!validatingIngredientCompletion($qtyArr,$measurementArr,$itemArr,$count)){
        
        array_push($_GET['errorcode'],5);
        $getParams=http_build_query($_GET);
        $redirectUrl = "add-recipe.php" . ($getParams ? "?" . $getParams : "");
        header("Location: " . $redirectUrl);
 
    }

    if(!validatingTags()){
        
        array_push($_GET['errorcode'],5);
        $getParams=http_build_query($_GET);
        $redirectUrl = "add-recipe.php" . ($getParams ? "?" . $getParams : "");
        header("Location: " . $redirectUrl);
 
    }

    

    // if(validatingFormRequired() && validatingQtyEntry()){
    if(validatingTags()&&validatingIngredientCompletion($qtyArr,$measurementArr,$itemArr,$count)&&validatingNumericTime()&&validatingFormRequired() && validatingQtyEntry($qtyArr,$count)){

        $_GET['message'] = array();
        $_GET['errorcode'] = array();

        global $docroot;
        $docroot = $_SERVER['DOCUMENT_ROOT'];
        $fp = fopen("$docroot/HoangLong_Nguyen_A1/data/recipelist.csv",'a');
        if(!$fp) {
            echo "<p>f open fail<e>";
			echo "<strong>Unable to open data file.</strong>";
			exit;
        }
        else{
            //echo "<p>Successfully read in $docroot/HoangLong_Nguyen_A1/data/recipelist.csv</p>";
            showDetail();
            echo "<p class = \" num-col\"> Bing chilling </p>";
            $lineCount = count(file("$docroot/HoangLong_Nguyen_A1/data/recipelist.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
            $ingOut = "";
            for ($i = 0; $i < 10; $i++) {
                ${"qty_$i"} = $_GET["qty_$i"];
                ${"measurement_$i"} = $_GET["measurement_$i"];
                ${"item_$i"} = $_GET["item_$i"];
                $ingOut = $ingOut . ${"qty_$i"} . "+++" . ${"measurement_$i"} . "+++" . ${"item_$i"} . "|||";
            }

            //todo: add id
            $id = $lineCount + 1;
            $description = str_replace("\r\n",'<br>',$description);
            $steps = str_replace("\r\n",'<br>',$steps);
            $outArr = array($id,$title,$description,$type,$size,$prephrs,$prepmins,$cookhrs,$cookmins,$ingOut,$steps,$tags);

            fputcsv($fp,$outArr);

            // echo $tags;
            // $altTags = str_replace(",", " &#44;", $tags);
            // echo "$tags";
            // $out = "$out" . str_replace(",", " &#44;", $tags) . "," ;
            // $out = "$out\n";
            // fwrite($fp,$out);
            fclose($fp);
            showDetail($id);
            echo "Bing";
            exit;
        }
    }
    else{
        $message = "File reading error";
        $errorcode = 3;
        //header("Location: add-recipe.php");
    }


    // for ($i = 0; $i < $count; $i++) {
    //     echo "<br>i count = $i<br>";
    //     ${"qty_$i"} = $_GET['qty_$i'];
    //     ${"measurement_$i"} = $_GET['measurement_$i'];
    //     ${"item_$i"} = $_GET['item_$i'];

    //     if (!is_numeric(${"qty_$i"})) {
    //         echo "Quantity for item $i is not a valid number.";
    //     }
    //     echo "Item number: " . $i . ", quantity: " . $_GET["qty_$i"] . ", measurement: " . $_GET["measurement_$i"] . ", item: " . $_GET["item_$i"];
    // }

    // echo "Received title: $title, description: $description, type: $type, size: $size, prephrs: $prephrs, prepmins: $prepmins, cookhrs: $cookhrs, cookmins: $cookmins";
}


?>

</body>
</html>
