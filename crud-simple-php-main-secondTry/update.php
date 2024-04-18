<?php
// Include config file
session_start();
require_once "config.php";

// Transacciones
$jsonInsert='"user": "evesmax", "date":"'.date('Y-m-d H:i:s').'", "secction": "update.php" ';
require "transactions.php";
 
// Define variables and initialize with empty values
$description = $specifications = $price = "";
$description_err = $specifications_err = $price_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate description
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Por favor introduzca la descripción del instrumento a actualizar";
    } else{
        $description = $input_description;
    }
    
    // Validate specifications
    $input_specifications = trim($_POST["specifications"]);
    if(empty($input_specifications)){
        $specifications_err = "Por favor introduzca las especificaciones del instrumento a actualizar";     
    } else{
        $specifications = $input_specifications;
    }
    
    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Favor de indicar el precio actualizado.";     
    } elseif(!ctype_digit($input_price)){
        $price_err = "El valor no corresponde al campo, por favor introduzca un valor positivo";
    } else{
        $price = $input_price;
    }
    
    // Check input errors before inserting in database
    if(empty($description_err) && empty($specifications_err) && empty($price_err)){
        // Prepare an update statement
        $sql = "UPDATE instruments SET description=?, specifications=?, price=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssdi", $param_description, $param_specifications, $param_price, $param_id);
            
            // Set parameters
            $param_description = $description;
            $param_specifications = $specifications;
            $param_price = $price;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM instruments WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $description = $row["descripción"];
                    $specifications = $row["especificaciones"];
                    $price = $row["precio"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Algo salió mal, por favor inténtelo más tarde.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Instrumento</title>
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
                        <h2>Actualizar Instrumento</h2>
                    </div>
                    <p>Por favor de editar los valores a actualizar</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
