<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

session_start();


$quantityMilk = 0;
$quantitySoftDrink = 0;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $worker = $_POST['worker'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];

    $_SESSION['worker'] = $_POST['worker'];


    if(isset($_POST['add'])){
        switch($product){
            case 'milk':
                $_SESSION['milk']  += $quantity;
                break;

            case 'softDrink' :
                $_SESSION['softDrink']  += $quantity;
                break;
            
            default:
            echo "<br> <font color = 'red' ><p> Error: Product not found. </p></font>";
            break;
        }
    } elseif (isset($_POST['remove'])){
        switch ($product) {
            case 'milk':
                // Remove quantity from corresponding product
                $_SESSION['milk'] = max(0, $_SESSION['milk'] - $quantity);
                break;

            case 'softDrink':
                // Remove quantity from corresponding product
                $_SESSION['softDrink'] = max(0, $_SESSION['softDrink'] - $quantity);
                break;

            default:
                echo "<br> <font color='red'><p>Error: Product not found. </p></font>";
                break;
    }
    } elseif (isset($_POST['reset'])) {
        $_SESSION['worker']  = '';
        $_SESSION['milk']  = 0;
        $_SESSION['softDrink'] = 0;

    }
}
?>



<h1>Supermarket management</h1>
<form action="Exercise01.php" method="post">
    
        <label for="worker">Worker name:</label>
        <input type="text" id="worker" name="worker" value="<?php echo isset( $_SESSION['worker']) ?  $_SESSION['worker'] : ''; ?>">
        <br><br>
 
    <label for="product">Choose product:</label>
    <select name="product" id="product">
        <option value="softDrink">Soft Drink</option>
        <option value="milk">Milk</option>
    </select>
    <br><br>

    <label for="quantity">Product quantity:</label>
    <input type="number" id="quantity" name="quantity" required>
    <input type="submit" value="add" name="add">
    <input type="submit" value="remove" name="remove">
    <input type="submit" value="reset" name="reset">
</form>

<h2>Inventory</h2>
<p>worker: <?php echo isset( $_SESSION['worker']) ?  $_SESSION['worker'] : ''; ?></p>
<p>units milk: <?php echo isset($_SESSION['milk'] ) ? $_SESSION['milk'] : ''; ?> </p>
<p>units soft drink: <?php echo isset($_SESSION['softDrink'] ) ? $_SESSION['softDrink']  : ''; ?> </p>
</body>
</html>