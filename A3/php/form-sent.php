<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Sent</title>
</head>
<body>
    <h1>Form Data Received</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Assuming the form uses the GET method

        $orderNumber = isset($_GET['orderNumber']) ? $_GET['orderNumber'] : '';
        $orderDateFrom = isset($_GET['orderDateFrom']) ? $_GET['orderDateFrom'] : '';
        $orderDateTo = isset($_GET['orderDateTo']) ? $_GET['orderDateTo'] : '';

        $displayOrderNumber = isset($_GET['displayOrderNumber']) ? $_GET['displayOrderNumber'] : '';
        $displayOrderDate = isset($_GET['displayOrderDate']) ? $_GET['displayOrderDate'] : '';
        $displayShippedDate = isset($_GET['displayShippedDate']) ? $_GET['displayShippedDate'] : '';
        $displayProductName = isset($_GET['displayProductName']) ? $_GET['displayProductName'] : '';
        $displayProductDescription = isset($_GET['displayProductDescription']) ? $_GET['displayProductDescription'] : '';
        $displayQuantityOrdered = isset($_GET['displayQuantityOrdered']) ? $_GET['displayQuantityOrdered'] : '';
        $displayPriceEach = isset($_GET['displayPriceEach']) ? $_GET['displayPriceEach'] : '';


        echo "<p>Order Number: $orderNumber</p>";
        echo "<p>Order Date From: $orderDateFrom</p>";
        echo "<p>Order Date To: $orderDateTo</p>";


        echo "<p>Display Order Number: " . ($displayOrderNumber === 'true' ? 'Yes' : 'No') . "</p>";
        echo "<p>Display Order Date: " . ($displayOrderDate === 'true' ? 'Yes' : 'No') . "</p>";
        echo "<p>Display Shipped Date: " . ($displayShippedDate === 'true' ? 'Yes' : 'No') . "</p>";
        echo "<p>Display Product Name: " . ($displayProductName === 'true' ? 'Yes' : 'No') . "</p>";
        echo "<p>Display Product Description: " . ($displayProductDescription === 'true' ? 'Yes' : 'No') . "</p>";
        echo "<p>Display Quantity Ordered: " . ($displayQuantityOrdered === 'true' ? 'Yes' : 'No') . "</p>";
        echo "<p>Display Price Each: " . ($displayPriceEach === 'true' ? 'Yes' : 'No') . "</p>";
        

    } else {
        echo "<p>Invalid request method</p>";
    }
    ?>
</body>
</html>
