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

//Checking if the session variable numeros is set
if (!isset($_SESSION['numeros'])) {
    $_SESSION['numeros'] = [10, 20, 30]; 
}

$modifiedIndex = null;
$media = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pos']) && isset($_POST['valor'])) {
        //Retrieves pos and valor from the form.
        $pos = $_POST['pos'];
        $valor = $_POST['valor'];

        //Ensures pos is within valid bounds (0 to array length - 1)
        if ($pos >= 0 && $pos < count($_SESSION['numeros'])) {
            $_SESSION['numeros'][$pos] = $valor;
            $modifiedIndex = $pos;
        }
    }
    
    if (isset($_POST['calcular_media'])) {
        $media = array_sum($_SESSION['numeros']) / count($_SESSION['numeros']);
    }
    
    if (isset($_POST['reset'])) {
        $_SESSION['numeros'] = [10, 20, 30];
        $modifiedIndex = null;
        $media = null;
    }
}

?>
    <h2>Modify array saved in session</h2>
        <form method="post">
            <label>Position to modify:</label>
            <select name="pos">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <br>
            <label>New value:</label>
            <input type="number" name="valor" required>
            <br><br>
            <button type="submit" name="modify">Modify</button>
            <button type="submit" name="calcular_media">Average</button>
            <button type="submit" name="reset">Reset</button>
        </form>
        
        <p>Current array: 
            <?php 
                foreach ($_SESSION['numeros'] as $index => $num) {
                    echo $index === $modifiedIndex ? $num : $num;
                    echo $index < count($_SESSION['numeros']) - 1 ? ", " : "";
                }
            ?>
        </p>
        
        <?php if (isset($media)): ?>
            <p class="result">Average: <?php echo number_format($media, 2); ?></p>
        <?php endif; ?>
   
</body>
</html>