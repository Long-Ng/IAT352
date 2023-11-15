<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A3</title>
</head>
<body>
    <h1>Query</h1>
    <nav>
        <ul>
            <li></li>
        </ul>
    </nav>

    <?php
    //requires
    require("form-functions.php");



    $incomplete = true;
    // $incomplete = !empty($title) || !empty($type) || !empty($prephrs) || !empty($prepmins) || !empty($cookhrs) || !empty($cookmins);

    if(isset($_GET['orderNumber'])) $orderNumber = ($_GET['orderNumber']);
    if(isset($_GET['orderDateFrom'])) $orderDateFrom = ($_GET['orderDateFrom']);
    if(isset($_GET['orderDateTo'])) $orderDateTo = ($_GET['orderDateTo']);

    if(isset($_GET['displayOrderNumber'])) $displayOrderNumber = ($_GET['displayOrderNumber']);
    if(isset($_GET['displayOrderDate'])) $displayOrderDate = ($_GET['displayOrderDate']);
    if(isset($_GET['displayShippedDate'])) $displayShippedDate = ($_GET['displayShippedDate']);
    if(isset($_GET['displayProductName'])) $displayProductName = ($_GET['displayProductName']);
    if(isset($_GET['displayProductDescription'])) $displayProductDescription = ($_GET['displayProductDescription']);
    if(isset($_GET['displayQuantityOrdered'])) $displayQuantityOrdered = ($_GET['displayQuantityOrdered']);
    if(isset($_GET['displayPriceEach'])) $displayPriceEach = ($_GET['displayPriceEach']);
    


    echo "<form method=\"get\" action=\"form-sent.php\">";
    echo "<table>\n";
    // First column
    echo "<td>";
    echo "<h2>Select Order Parameters</h2>";
    
    echo "<tr>";
    makeInputField("orderNumber","000000","orderNumber",true,$incomplete);
    echo "</tr>";
    
    echo "<tr>";
    makeInputField("orderDateFrom","000000","orderDateFrom",true,$incomplete);
    echo "</tr>";
   
    echo "<tr>";
    makeInputField("orderDateTo","000000","orderDateTo",true,$incomplete);
    echo "</tr>";
    echo "</td>";
    
    // Second column
    echo "<td>";
    makeCheckbox("Order Number","displayOrderNumber");
    makeCheckbox("Order Date","displayOrderDate");
    makeCheckbox("Shipped Date","displayShippedDate");
    makeCheckbox("Product Name","displayProductName");
    makeCheckbox("Product Description","displayProductDescription");
    makeCheckbox("Quantity Ordered","displayQuantityOrdered");
    makeCheckbox("Price Each","displayPriceEach");
    echo "</td>";
    
    echo "<tr><td style=\"text-align: center\"><input type=\"submit\" class= \"button-link\" name=\"submit\" border=0 value=\"Submit\"></td></tr>";

    echo "</table>\n";
    echo "</form>";
    ?>
</body>
</html>