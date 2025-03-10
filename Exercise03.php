<!DOCTYPE html>
<html>

<head>
    <title>Shopping list</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
        }

        input[type=submit] {
            margin-top: 10px;
        }
    </style>
</head>

<body>
<?php
session_start();

if (!isset($_SESSION['shopping_list'])) {
    $_SESSION['shopping_list'] = [];
}

$name = $quantity = $price = "";
$error = $message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reset'])) {
        $name = $quantity = $price = "";
    } else {
        $name = $_POST['name'];
        $quantity = intval($_POST['quantity']);
        $price = floatval($_POST['price']);
    
        if (!empty($name) && $quantity > 0 && $price > 0) {
            if (isset($_POST['update']) && isset($_SESSION['shopping_list'][$name])) {
                $_SESSION['shopping_list'][$name]['quantity'] = $quantity;
                $_SESSION['shopping_list'][$name]['price'] = $price;
                $_SESSION['shopping_list'][$name]['cost'] = $quantity * $price;
                $message = "Item updated properly.";
            } else {
                $_SESSION['shopping_list'][$name] = [
                    'quantity' => $quantity,
                    'price' => $price,
                    'cost' => $quantity * $price
                ];
                $message = "Item added properly.";
            }
        } else {
            $error = "Please enter valid name, quantity, and price.";
        }
    }
}

if (isset($_GET['delete'])) {
    $name = $_GET['delete'];
    unset($_SESSION['shopping_list'][$name]);
    $message = "Item deleted properly.";
}

$total_cost = array_sum(array_column($_SESSION['shopping_list'], 'cost'));
?>

    <h1>Shopping list</h1>
    <form method="post">
        <label for="name">name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>">
        <br>
        <label for="quantity">quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
        <br>
        <label for="price">price:</label>
        <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($price); ?>">
        <br>
        <input type="submit" name="add" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="reset" value="Reset">
    </form>
    <p style="color:red;"><?php echo $error; ?></p>
    <p style="color:green;"><?php echo $message; ?></p>
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>cost</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['shopping_list'] as $item_name => $item) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($item_name); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo number_format($item['cost'], 2); ?></td>
                    <td>
                        <a href="?edit=<?php echo urlencode($item_name); ?>">Edit</a>
                        <a href="?delete=<?php echo urlencode($item_name); ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><?php echo number_format($total_cost, 2); ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
