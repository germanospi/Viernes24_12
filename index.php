<?php require_once('Connections/CALDAS.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['contrasena'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "menuprincipal.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_CALDAS, $CALDAS);
  
  $LoginRS__query=sprintf("SELECT usuario, contrasena FROM tabla_form WHERE usuario=%s AND contrasena=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "int")); 
   
  $LoginRS = mysql_query($LoginRS__query, $CALDAS) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario registro</title>
    <style>
        body{
            background-color: #87CCC1;
            margin: 0;
            padding: 0;
        }
        h1{
            text-align: center;
            width: 50%;
            margin: auto;
            margin-top: 30px;
        }
        table{
            border: 3px solid #CCA633;
            padding: 20px 50px;
            margin-top: 20px;
            border-radius: 5px;
            background-color: #EDF797;
        }
    </style>
</head>
<body>
    <h1>Formulario de Registro</h1>
    <form action="menuprincipal.php" <?php echo $loginFormAction; ?>" name="marzo" method="POST">
        <table border="0" align="center">
            <tr>
                <td>Nombre de usuario</td>
                <td><label for="user"></label>
                <input type="text" name="usuario" id="user" required>
                </td>
            </tr>
            <tr>
                <td>Contraseña</td>
                <td><label for="contra"></label>
                <input type="password" name="contrasena" id="contra" required>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center"><input type="submit" name="enviar" id="enviar" value="Registrarse"></td>
                <td align="center"><input type="reset" name="limpiar" id="limpiar" value="Restablecer"></td>
            </tr>
        </table>
    </form>
</body>
</html>