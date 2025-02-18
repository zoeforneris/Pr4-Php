<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<style>
        table {
            width: 50%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        button {
            margin: 2px;
            padding: 5px;
        }
</style>
</head>
<body>

<?php


session_start();

if (!isset($_SESSION['shopping_list'])) {
    $_SESSION['shopping_list'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $quantity = (int)$_POST['quantity'];
        $price = (float)$_POST['price'];
        $cost = $quantity * $price;
        
        $_SESSION['shopping_list'][] = ['name' => $name, 'quantity' => $quantity, 'price' => $price, 'cost' => $cost];
    }
    
    if (isset($_POST['delete'])) {
        $index = $_POST['index'];
        unset($_SESSION['shopping_list'][$index]);
        $_SESSION['shopping_list'] = array_values($_SESSION['shopping_list']);
    }
}
?>








<h1>Shopping list</h1>
<label for="name">name: </label>
<input type="text" name="name" id="name"><br>
<label for="quantity">quantity: </label>
<input type="number" name="quantity" id="quantity"><br>
<label for="price">price: </label>
<input type="number" name="price" id="price"><br><br>

<button type="submit" name="add">Add</button>
<button type="submit" name="update">Update</button>
<button type="submit" name="reset">Reset</button>

<table>
    <tr>
        <th>name</th>
        <th>quantity</th>
        <th>price</th>
        <th>cost</th>
        <th>actions</th>
    </tr>
    <tr>
        <td><?php echo isset( $_SESSION['name']) ?  $_SESSION['name'] : ''; ?></td>
        <td><?php echo isset( $_SESSION['quantity']) ?  $_SESSION['quantity'] : ''; ?></td>
        <td><?php echo isset( $_SESSION['price']) ?  $_SESSION['price'] : ''; ?></td>
        <td><?php echo isset( $_SESSION['cost']) ?  $_SESSION['cost'] : ''; ?></td>
        <td>
            <button>Edit</button>
            <button>Delete</button>
        </td>
    </tr>
    <tr>
        <td colspan="3"><strong>Total:</strong></td>
        <td id="total">0</td>
        <td><button onclick="calculateTotal()">Calculate total</button></td>
    </tr>
</table>




    
</body>
</html>