<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>View Employees</title>
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
    
    <h1>List Of Employees</h1>

	<?php

	$result = $connection->query("SELECT ID, firstName, lastName, restaurantName FROM employee;");

	if ($result->rowCount() == 0) {
        echo "No employees recorded";
    }
	else {
		echo '
		<table>
		<tr>
            <th>Employee ID</th>
			<th>Name</th>
            <th>Restaurant</th>
		</tr>';

        while ($row = $result->fetch()) {

            echo '
                <tr>
                    <td>'.$row['ID'].'</td>
                    <td>'.$row['firstName'], " ", $row['lastName'].'</td>
                    <td>'.$row['restaurantName'].'</td>
                </tr>';            
        }
        echo '
        </table>';
	}
    
	
	?>
    <h1>View Employee Schedule</h1>

    <form method="post">
    Employee ID: <input type="text" name="name"><br>
    <input type="submit">
    </form>

	<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' and ($_POST['name'] != '')) {
        $id = (int)$_POST["name"];
        $employee = $connection->query("SELECT * FROM employee where id = '$id';");
        if ($employee->rowCount() == 0) {
            echo "<p>The employee with ID:" . $_POST["name"] . " does not exist!</p>";
            echo '<table></table>';
        }
        else {
            $employeeFetch = $employee->fetch();
            $employeeName = $employeeFetch['firstName'] . " " . $employeeFetch['lastName'];
            echo "<h2>Schedule of Employee: " . $employeeName . " (ID ". $_POST["name"] . ") </h2>";
            echo '<table>
            <tr>
                <th>Day</th>
                <th>Hours Working</th>
            </tr>';
            $weekday = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
        
            for ($i = 0; $i < 5; $i++) {
                //get the schedule for the day
                $day = $connection->query("SELECT dayOrder, weekdays.day as dayWeek, startTime, endTime 
                                            from (weekdays JOIN shift) 
                                            WHERE empId = '$id' and weekdays.day = shift.day and weekdays.day = '$weekday[$i]'");
                //check if the table has rows
                if ($day->rowCount() == 0) {
                    $shift = "-";
                }
                else {
                    $row = $day->fetch();
                    $shift = $row['startTime'] . " - " . $row['endTime'];
                }
                echo '
                    <tr>
                        <td>'.$weekday[$i].'</td>
                        <td>'.$shift.'</td>
                    </tr>';        
            }
            echo '
            </table>';
        }  
    }
	?>
</body>
</html>