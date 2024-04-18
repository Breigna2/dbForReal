<?php
// Include config file
session_start();
require_once "config.php";

// Transacciones
$jsonInsert='"user": "breigna", "date":"'.date('Y-m-d H:i:s').'", "secction": "create.php" ';
require "transactions.php";
 
// Define variables and initialize with empty values
$description = $specifications = $price = "";
$description_err = $specifications_err = $price_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate description
    $input_description = trim($_POST["descripción"]);
    if(empty($input_description)){
        $description_err = "Por favor especifique la descripción del instrumento.";
    } else{
        $description = $input_description;
    }
    
    // Validate specifications
    $input_specifications = trim($_POST["specifications"]);
    if(empty($input_specifications)){
        $specifications_err = "Por favor especifique las especificaciones del instrumento..";     
    } else{
        $specifications = $input_specifications;
    }
    
    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Por favor especifique el precio del instrumento.";     
    } elseif(!ctype_digit($input_price)){
        $price_err = "El valor tiene que ser positivo.";
    } else{
        $price = $input_price;
    }
    
    // Check input errors before inserting in database
    if(empty($description_err) && empty($specifications_err) && empty($price_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO instruments (description, specifications, price) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssd", $param_description, $param_specifications, $param_price);
            
            // Set parameters
            $param_description = $description;
            $param_specifications = $specifications;
            $param_price = $price;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Algo salió mal, por favor inténtelo más tarde.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Instrument</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Agregar instrumento</h2>
                    </div>
                    <p>Favor de completar esta forma para agregar un nuevo instrumento</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                            <label>Descripción</label>
                            <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
                            <span class="help-block"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($specifications_err)) ? 'has-error' : ''; ?>">
                            <label>Especificaciones</label>
                            <textarea name="specifications" class="form-control"><?php echo $specifications; ?></textarea>
                            <span class="help-block"><?php echo $specifications_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Precio</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>
                        <input type="Agregar" class="btn btn-primary" value="Agregar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
