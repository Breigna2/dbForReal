<?PHP 

//Transacciones
$jsonInsert='"user": "evesmax", "date":"'.date('Y-m-d H:i:s').'", "secction": "menu.php" ';
require "transactions.php";

// start a session 
session_start();
// manipulate session variables 
$_SESSION["db"]="instrumentos1";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Base de datos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>


</head>

   <form action="index.php">
        <div class="page-header clearfix">
            <select  aria-label="" name="cmbdb" id="cmbdb">
                <option value="Instrumentos_Guadalajara">Instrumentos Guadalajara</option>
                <option value="Instrumentos_Monterrey1">Instrumentos Monterrey</option>
                <option value="Instrumentos_CDMX1">Instrumentos CDMX</option>
                <option value="instrumentos1">Instrumentos1</option>
                <option value="Instrumentos_Bodega">Instrumentos Bodega</option>
            </select><BR>
            <button type="submit" class="btn btn-success">Conectar</button>
        </div>
    </Form>
