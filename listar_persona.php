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

$maxRows_lispersona = 20;
$pageNum_lispersona = 0;
if (isset($_GET['pageNum_lispersona'])) {
  $pageNum_lispersona = $_GET['pageNum_lispersona'];
}
$startRow_lispersona = $pageNum_lispersona * $maxRows_lispersona;

mysql_select_db($database_CALDAS, $CALDAS);
$query_lispersona = "SELECT * FROM persona";
$query_limit_lispersona = sprintf("%s LIMIT %d, %d", $query_lispersona, $startRow_lispersona, $maxRows_lispersona);
$lispersona = mysql_query($query_limit_lispersona, $CALDAS) or die(mysql_error());
$row_lispersona = mysql_fetch_assoc($lispersona);

if (isset($_GET['totalRows_lispersona'])) {
  $totalRows_lispersona = $_GET['totalRows_lispersona'];
} else {
  $all_lispersona = mysql_query($query_lispersona);
  $totalRows_lispersona = mysql_num_rows($all_lispersona);
}
$totalPages_lispersona = ceil($totalRows_lispersona/$maxRows_lispersona)-1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<table border="1">
  <tr>
    <td>Documento</td>
    <td>Nombre</td>
    <td>Apellido</td>
    <td>Direccion</td>
    <td>Telefono</td>
    <td>Correo_E</td>
    <td>Fecha</td>
    <td>Hora</td>
    <td>Barrio</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_lispersona['documento']; ?></td>
      <td><?php echo $row_lispersona['Nombre']; ?></td>
      <td><?php echo $row_lispersona['Apellido']; ?></td>
      <td><?php echo $row_lispersona['direccion']; ?></td>
      <td><?php echo $row_lispersona['telefono']; ?></td>
      <td><?php echo $row_lispersona['Correo_e']; ?></td>
      <td><?php echo $row_lispersona['fecha']; ?></td>
      <td><?php echo $row_lispersona['hora']; ?></td>
      <td><?php echo $row_lispersona['barrio']; ?></td>
    </tr>
    <?php } while ($row_lispersona = mysql_fetch_assoc($lispersona)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($lispersona);
?>
