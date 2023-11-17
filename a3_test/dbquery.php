<!DOCTYPE html>
<?php
require_once("helper.php");
require_once("db.php");

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
            <p>Note: If Order Number and Order Date are both selected, SQL query will prioritize Order Number</p>
            <label for="order_num">Order number:</label>
            <select name="order_num" id="order_num">
                <option value=""></option>
                <?php
                if (mysqli_num_rows($order_nums_result) != 0) {
                    while ($row = mysqli_fetch_assoc($order_nums_result)) {
                        echo add_dropdown_option($row['orderNumber']);
                        $selected = ($_POST['order_num'] == $row['orderNumber']) ? 'selected' : '';
                        echo "<option value='{$row['orderNumber']}' $selected>{$row['orderNumber']}</option>";
                    }
                }
                ?>
            </select>

            <p>or</p>

            <label>Order Date (YYYY-MM-DD)</label>
            <br>
            <?php
            makeDateEntry("start_date","from:","start_date");
            makeDateEntry("end_date","to:","end_date");
            ?>


            <h2>Select columns to display</h2>
            <?php 
            makeCheckbox("Order Number","Order Number", "checkbox0", "orderNumber");
            makeCheckbox("Order Date","Order Date", "checkbox1", "orderDate");
            makeCheckbox("Shipped Date","Shipped Date", "checkbox2", "shippedDate");
            makeCheckbox("Product Name","Product Name", "checkbox3", "productName");
            makeCheckbox("Product Description","Product Description", "checkbox4", "productDescription");
            makeCheckbox("Quantity Ordered","Quantity Ordered", "checkbox5", "quantityOrdered");
            makeCheckbox("Price Each","Price Each", "checkbox6", "priceEach");
            ?>           
            <br>
            <br>
            <input type="submit" name="submit"/>
        </form>

        <h3>SQL Query:</h3>

        <?php
        if (!empty($_POST['order_num'])) {
            $order_num_query_str =  str_replace("?",$_POST['order_num'],$query_by_number);
            echo $order_num_query_str;
            $order_num = $_POST['order_num'];
            mysqli_stmt_bind_param($stmt_number, 'i', $order_num);
            mysqli_stmt_execute($stmt_number);
            $result = mysqli_stmt_get_result($stmt_number);
        }
        else if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
            if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
                if(strtotime($_POST['end_date']) < strtotime($_POST['start_date']))
                {
                    echo "End date should come before start date";
                    exit;
                }
            else{
                    $firstpos = strpos($query_by_date, "?");
                    $order_date_query_str = substr_replace($query_by_date, $_POST['start_date'], strpos($query_by_date, "?"), strlen("?"));
                    $order_date_query_str = substr_replace($order_date_query_str, $_POST['end_date'], strpos($order_date_query_str, "?"), strlen("?"));
                    echo $order_date_query_str;
                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];
                    mysqli_stmt_bind_param($stmt_date, "ss", $start_date, $end_date);
                    mysqli_stmt_execute($stmt_date);
                    $result = mysqli_stmt_get_result($stmt_date);
                }
            }
        }
        else{
            echo "please enter something in the form";
            exit;
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
                if(!empty($result)){
                    if (mysqli_num_rows($result) != 0) {
                        foreach ($columnVars as $col) {
                            if ($col != "default") {
                                echo "<th>";
                                echo $col;
                                echo "</th>";
                            }
                        }
                    }
                }
                ?>
            </tr>
            
            <?php
            if(!empty($result)){
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
            }
            ?>
        </table>

        <?php
        if(!empty($result)){
            mysqli_free_result($result);
        }
        ?>

    </body>
</html>

<?php
    $db->close();
?>