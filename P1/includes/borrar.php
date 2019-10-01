/**
*@title: Exercici 11
* @author Rocío y David &lt;al342129@uji.es&gt; * @copyright 2019 Rocío
* @license CC-BY-NC-SA
*/

<?php
    include("./gestionBD.php");
    function handler($pdo,$table,$valor)
    {
        $table = "A_cliente";   
        $query = "DELETE   FROM   $table WHERE client_id =(?)";
        


        try{
            $consult = $pdo->prepare($query);
            handler($pdo,$table,$valor);
            $a=$consult->execute(array($valor));
            if (1>$a) echo "InCorrecto1";
            echo $query;  
            
        }catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        }
    }
?>