<!DOCTYPE html>
<?php
require("helper.php");
require("db.php");

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
    die("Error:" . mysqli_error($db) );
}

//query for order numbers, used to create order params dropdown input
$query_order_nums = "SELECT * FROM orders";
$order_nums_result = mysqli_query($db, $query_order_nums);
if (!$order_nums_result) {
    die("query failed");
}

//to hold checked columns
$selectedColumns = [];
$validColumns = ["orderNumber", "orderDate", "shippedDate", "productName", "productDescription", "quantityOrdered", "priceEach"];

//loop through all checkboxes
for ($i = 0; $i < 7; $i++) {
    $colName = "checkbox$i"; 
    if (isset($_POST[$colName])) {
        //check if the checkbox values are valid column names
        if (array_search($_POST[$colName], $validColumns) === FALSE) {
            echo "invalid column name";
            exit();
        }
        else {
            //add checked checkboxes to arraylist
            array_push($selectedColumns, $colName);
        }
    }
}

//to whitelist the columns
$columnVars = [$col0 = "default", $col1 = "default", $col2 = "default", $col3 = "default", $col4 = "default", $col5 = "default", $col6 = "default"];

for ($j = 0; $j < count($selectedColumns); $j++) {
    //replace values of variables with values of checkboxes
    $columnVars[$j] = $_POST[$selectedColumns[$j]];
}

?>

<html lang="en">
    <head>
        <title>A3</title>
        <link rel="stylesheet" href="css/mainStyle.css">
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
            <input type="date" id="start_date" name="start_date"/>
            <label for="end_date">to:</label>
            <input type="date" id="end_date" name="end_date"/>

            <h2>Select columns to display</h2>
            
            <input type="checkbox" name="checkbox0" id="order_number" value="orderNumber"/>
            <label for="order_number">Order number</label>

            <input type="checkbox" name="checkbox1" id="order_date" value="orderDate"/>
            <label for="order_date">Order date</label>

            <input type="checkbox" name="checkbox2" id="shipped_date" value="shippedDate"/>
            <label for="shipped_date">Shipped date</label>

            <input type="checkbox" name="checkbox3" id="prod_name" value="productName"/>
            <label for="prod_name">Product name</label>

            <input type="checkbox" name="checkbox4" id="prod_desc" value="productDescription"/>
            <label for="prod_desc">Product description</label>

            <input type="checkbox" name="checkbox5" id="qty_ordered" value="quantityOrdered"/>
            <label for="qty_ordered">Quantity ordered</label>

            <input type="checkbox" name="checkbox6" id="price_each" value="priceEach"/>
            <label for="price_each">Price each</label>
            
            <br>
            <br>
            <input type="submit" name="submit"/>
        </form>

        <h3>SQL Query:</h3>

        <?php
        if (!empty($_POST['order_num'])) {
            echo $query_by_number;
            $order_num = $_POST['order_num'];
            mysqli_stmt_bind_param($stmt_number, 'i', $order_num);
            mysqli_stmt_execute($stmt_number);
            $result = mysqli_stmt_get_result($stmt_number);
        }
        else if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
            if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
                echo $query_by_date;
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                mysqli_stmt_bind_param($stmt_date, "ss", $start_date, $end_date);
                mysqli_stmt_execute($stmt_date);
                $result = mysqli_stmt_get_result($stmt_date);
            }
        }
        // echo $_POST['checkbox1'];
        // $col1 = $_POST['checkbox1'];
        // echo "SELECT $col1
        // FROM orders
        // INNER JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber
        // INNER JOIN products ON orderdetails.productCode = products.productCode
        // WHERE orders.orderNumber = ?";
        ?>
        
        <h3>Result</h3>
        <table>
            <tr>
                <?php
                if (mysqli_num_rows($result) != 0) {
                    foreach ($columnVars as $col) {
                        if ($col != "default") {
                            echo "<th>";
                            echo $col;
                            echo "</th>";
                        }
                    }
                }
                ?>
            </tr>
            
            <?php
            if (mysqli_num_rows($result) != 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($columnVars as $col) {
                        if ($col != "default") {
                            echo "<td>" .$row[$col]. "</td>";
                        }
                    }
                    echo "</tr>";
                }
            }
            ?>
        </table>

        <?php
        mysqli_free_result($result);
        ?>

    </body>
</html>

<?php
    $db->close();
?>