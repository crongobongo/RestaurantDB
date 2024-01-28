<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add New Customer</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        form {
            align-items: left;
            flex-direction: column;
        }

        input[type=text] {
            padding: 5px;
            border-radius: 5px;
            border: none;
            box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.25);
        }

        input[type=submit] {
            padding: 5px 15px;
            border-radius: 5px;
            border: none;
            background-color: #0e7fcc;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type=submit]:hover {
            background-color: #06456b;
        }
    </style>

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
    <h1>Add New Customer</h1>

	<form method="post">
	Email: <input type="text" name="email"><br>
    First Name: <input type="text" name="fname"><br>
    Last Name: <input type="text" name="lname"><br>
    Phone Number: <input type="text" name="num"><br>
    Street: <input type="text" name="street"><br>
    City: <input type="text" name="city"><br>
    Postal Code: <input type="text" name="pc"><br>
	<input type="submit">
	</form>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' and ($_POST['email'] != '') and ($_POST['fname'] != '') and ($_POST['lname'] != '')) {
        $email = $_POST['email'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $num = $_POST['num'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $pc = $_POST['pc'];
        //check if email is already in Customer table
        $result = $connection->query("SELECT emailAddress
                                        FROM customerAccount
                                        WHERE emailAddress = '$email'");
        if ($result->rowCount() == 0) {
            $insert = $connection->query("INSERT INTO customerAccount values
                                        ('$email', '$fname', '$lname', '$num', '$street', '$city', '$pc', 5.00)");
            echo "<p>Customer added to database</p>";
        }
        else {
            echo "<p>Email already in use! Please try another email!</p>";
        }
    }
	?>
</body>
</html>