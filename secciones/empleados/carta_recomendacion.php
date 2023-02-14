<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    
    $sentencia=$conexion->prepare("SELECT *,(SELECT nombredelpuesto 
    FROM tbl_puestos 
    WHERE tbl_puestos.id=tbl_empleados.idpuesto limit 1) as puesto FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);



    $primernombre=$registro["primernombre"];
    $segundonombre=$registro["segundonombre"];
    $primerapellido=$registro["primerapellido"];
    $segundoapellido=$registro["segundoapellido"];

    $nombreCompleto=$primernombre." ".$segundonombre." ".$primerapellido." ".$segundoapellido;

    $foto=$registro["foto"];
    $cv=$registro["cv"];

    $idpuesto=$registro["idpuesto"];
    $puesto=$registro["puesto"];
    $fechadeingreso=$registro["fechadeingreso"];

    $fechaInicio= new DateTime($fechadeingreso);
    $fechaFin = new DateTime(date('Y-m-d'));
    $diferencia=date_diff($fechaInicio,$fechaFin);

}
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Recomendación</title>
</head>
<body>
    <h1>Carta de Recomendación Laboral</h1>
    <br/><br/>
    Barrancabermeja, Santander a <strong> <?php echo date('d M Y');?> </strong>
    <br/><br/>
    A quien pueda interesar:
    <br/><br/>
    Reciba un cordial y respetuoso saludo.
    <br/><br/>
    a través de estas líneas deseo hacer de su conocimiento que Sr(a) <strong> <?php echo $nombreCompleto;?> </strong>,
    quien Laboró en mi organización durante <strong><?php echo $diferencia->y;?> año(s)</strong>
    es un ciudadano con una conducta intachable. Ha demostrado ser un  gran trabajador,
    comprometido, responsable y fiel cumplidor de sus trareas.
    Siempre ha manifestado preocupación para mejorar, capacitarse y actualizar sus conocimientos.  
    <br/><br/>
    Durante estos años se ha desempeñado como: <strong> <?php echo $puesto;?> </strong>
    Es por ello le sgiero considere esta recomentación , con la confianza de que estará siempre a la altura 
    de sus compromisos y responsabilidades.
    <br/><br/>
    Sin más nada a que referirme y, esperando que esta misiva sea tomada en cuenta, dejo mi número de contacto
    para cualquier información de interés.
    <br/><br/><br/><br/><br/><br/>
    
    Atentamente,
    <br/><br/>
    ____________________________<br/>
    Ing. Jamava Piocuda Cervantes

</body>
</html>

<?php
$HTML=ob_get_clean();

require_once("../../libs/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf= new Dompdf();

$opciones=$dompdf->getOptions();
$opciones->set(array("isRemoteEnabled"=>true));

$dompdf->setOptions($opciones);
$dompdf->loadHtml($HTML);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment"=>false));




?>