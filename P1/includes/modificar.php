/**
*@title: Exercici 12
* @author Rocío y David &lt;al342129@uji.es&gt; * @copyright 2019 Rocío
* @license CC-BY-NC-SA
*/

<?php
include("./gestionBD.php");
function handler($pdo,$table,$valor){
    $query = "UPDATE $table SET (nombre=?, apellidos=?, email=?, dni_?, clave=?, foto_file=?,) WHERE client_id =(?)";
    $consult = $pdo->prepare($query);
    $a=$consult->execute(array($valor));
    if (1>$a)echo "InCorrecto";
    echo $query;
    
    try {
        $a=array($_REQUEST['nombre'], $_REQUEST['apellidos'],$_REQUEST['email'],$_REQUEST['dni'],$_REQUEST['clave'],$_REQUEST['foto_file'] );
        print_r ($a);
        $consult = $pdo->prepare($query);
        $a=$consult->execute(array($_REQUEST['nombre'], $_REQUEST['email'],$_REQUEST['dni'],$_REQUEST['clave'],$_REQUEST['foto_file'] ));
        if (1>$a)echo "InCorrecto";
        
    } catch (PDOExeption $e) {
        echo ($e->getMessage());
    }

    $table = "A_cliente";
    var_dump($_POST);
    handler( $pdo,$table);
    
}
?>