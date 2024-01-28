<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="navigation-links">
        <button onclick="location.href='restaurant.php'">Home Page</button>
        <button onclick="location.href='orders.php'">Orders</button>
        <button onclick="location.href='add_customer.php'">Add New Customer</button>
        <button onclick="location.href='employees.php'">Employees</button>
    </div>
	<h1>Welcome to Christian's Restaurant Database!</h1>
	<img src="restaurants.jpg" alt="cute pigs" width="575" height="400">

	<?php
    include 'connectdb.php';
	$result = $connection->query("SELECT * FROM restaurant order by name;");

	if ($result->rowCount() == 0) {
        echo "<p>No restaurants to show at this time!</p>";
    }
	else {
		echo '
		<table>
		<tr>
            <th>Restaurant</th>
			<th>Location</th>
            <th>Website</th>
		</tr>';

        while ($row = $result->fetch()) {

            echo '
                <tr>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['streetAddress'], ", ", $row['city'], ", ", $row['postalCode'].'</td>
                    <td>'.$row['url'].'</td>
                </tr>';            
        }
        echo '
        </table>';
	}
	?>

</body>
</html>
