<!DOCTYPE html>
<?php
require("helper.php");
require("db.php");
@$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
    echo "not connected" . mysqli_connect_error();
    exit;
}

//prepared statements for the 2 order params
$query_by_number = "SELECT orders.orderNumber, orders.orderDate, orders.shippedDate, products.productName, products.productDescription, orderdetails.quantityOrdered, orderdetails.priceEach
FROM orders
INNER JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber
INNER JOIN products ON orderdetails.productCode = products.productCode
WHERE orders.orderNumber = ?";

$query_by_date = "SELECT orders.orderNumber, orders.orderDate, orders.shippedDate, products.productName, products.productDescription, orderdetails.quantityOrdered, orderdetails.priceEach
FROM orders
INNER JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber
INNER JOIN products ON orderdetails.productCode = products.productCode
WHERE orders.orderDate >= ? AND orders.orderDate <= ?";

$stmt_number = mysqli_prepare($db, $query_by_number);
$stmt_date = mysqli_prepare($db, $query_by_date);

if(!$stmt_number || !$stmt_date) {
    die("Error is:". mysqli_error($db) );
}

//query for order numbers, used for order params dropdown input
$query_order_nums = "SELECT * FROM orders";
$order_nums_result = mysqli_query($db, $query_order_nums);
if (!$order_nums_result) {
    die("query failed");
}
?>

<html lang="en">
    <head>
        <title>A3</title>
    </head>
    <body>
        <h1>Query</h1>
        <form action="dbquery.php" method="POST">
            <h2>select order parameters</h2>
            <label for="order_num">Order number:</label>
            <select name="order_num" id="order_num">
                <option value=""></option>
                <?php
                if (mysqli_num_rows($order_nums_result) != 0) {
                    while ($row = mysqli_fetch_assoc($order_nums_result)) {
                        echo add_dropdown_option($row['orderNumber']);
                    }
                }
                ?>
            </select>

            <p>or</p>

            <label>Order Date (YYYY-MM-DD)</label>
            <br>
            <label for="start_date">from:</label>
            <input type="date" id="start_date"/>
            <label for="end_date">to:</label>
            <input type="date" id="end_date"/>

            <h2>Select columns to display</h2>
            
            <input type="checkbox" id="order_number" value="orderNumber"/>
            <label for="order_number">Order number</label>

            <input type="checkbox" id="order_date" value="orderDate"/>
            <label for="order_date">Order date</label>

            <input type="checkbox" id="shipped_date" value="shippedDate"/>
            <label for="shipped_date">Shipped date</label>

            <input type="checkbox" id="prod_name" value="productName"/>
            <label for="prod_name">Product name</label>

            <input type="checkbox" id="prod_desc" value="productDescription"/>
            <label for="prod_desc">Product description</label>

            <input type="checkbox" id="qty_ordered" value="quantityOrdered"/>
            <label for="qty_ordered">Quantity ordered</label>

            <input type="checkbox" id="price_each" value="priceEach"/>
            <label for="price_each">Price each</label>
            

            <input type="submit" name="submit"/>
        </form>

        <h3>SQL Query:</h3>

        <?php
        if (!empty($_POST['order_num'])) {
            echo $query_by_number;
            // mysqli_stmt_bind_param($stmt_number, 'i', );
        }
        ?>
        
        <h3>Result</h3>


        
    </body>
</html>
<?php
    //bind and execute as needed
    // mysqli_stmt_bind_param($stmt_date, 'ii', )
    $db->close();
?>