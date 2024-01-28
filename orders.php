<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orders</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
include 'connectdb.php';
?>
    <div class="navigation-links">
        <button onclick="location.href='restaurant.php'">Home Page</button>
        <button onclick="location.href='orders.php'">Orders</button>
        <button onclick="location.href='add_customer.php'">Add New Customer</button>
        <button onclick="location.href='employees.php'">Employees</button>
    </div>

	<h1>Dates Of Past Orders</hi>
	<?php

	$result = $connection->query("SELECT datePlaced, COUNT(*) as count FROM foodorder GROUP BY datePlaced;");

	if ($result->rowCount() == 0) {
        echo "No record of any orders";
    }
	else {
		echo '
		<table>
		<tr>
			<th>Date</th>
			<th>Number Of Orders</th>
		</tr>';

        while ($row = $result->fetch()) {

            echo '
                <tr>
                    <td>'.$row['datePlaced'].'</td>
                    <td>'.$row['count'].'</td>
                </tr>';
        }
        echo '
        </table>';     
    }
	?>

<h1>View Past Restaurant Orders</h1>

<form method="post">
    Date: <input type="date" name="name" value="YYYY-MM-DD"><br>
    <input type="submit">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' and ($_POST['name'] != '')) {
	echo "<h2>Orders On Date: " . $_POST["name"] . "</h2>";
    $date = $_POST["name"];
	$result = $connection->query("SELECT delivery.orderID, customeraccount.firstName, customeraccount.lastName,fooditemsinorder.food, foodorder.totalPrice, foodorder.tip, employee.firstName as fName, employee.lastName as lName
                                        FROM foodorder, fooditemsinorder, delivery, employee, orderplacement, customeraccount
                                        WHERE delivery.deliveryPerson = employee.ID
                                            AND fooditemsinorder.orderID = delivery.orderID 
                                            AND foodorder.orderID = fooditemsinorder.orderID 
                                            AND orderplacement.orderID = fooditemsinorder.orderID 
                                            AND orderplacement.customerEmail = customeraccount.emailAddress
                                            AND foodorder.datePlaced = '$date';");
    if ($result->rowCount() == 0) {
        echo "<p>No record of any orders on this date!<p>";
    }
    else {
        echo '<table>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Items</th>
            <th>Total Amount</th>
            <th>Tip</th>
            <th>Delivery Person</th>
        </tr>';
        $list = array();
        $num = 1;
    
        while ($row = $result->fetch()) {
            if (in_array($row['orderID'], $list)) {
                echo '
                    <tr>
                        <td></td>
                        <td></td>
                        <td>'.$row['food'].'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>';
                    array_push($list,$row['orderID']);
            }
            else {
                echo '
                    <tr>
                        <td>'.$num,".".'</td>
                        <td>'.$row['firstName'], " ", $row['lastName'].'</td>
                        <td>'.$row['food'].'</td>
                        <td>'."$",$row['totalPrice'].'</td>
                        <td>'."$",$row['tip'].'</td>
                        <td>'.$row['fName'], " ", $row['lName'].'</td>
                    </tr>';
                    array_push($list,$row['orderID']);
                    $num++;
            }
                
        }
    }
    echo '
    </table>';}
	?>
</body>
</html>