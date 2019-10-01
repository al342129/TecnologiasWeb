
/**
*@title: Exercici 11
* @author Rocío y David &lt;al342129@uji.es&gt; * @copyright 2019 Rocío
* @license CC-BY-NC-SA
*/

<?php
    include("./gestionBD.php");
    function handler($pdo,$table)
    {
        $table = "A_cliente";
        $client_id=5;    
        $query = "DELETE FROM $table WHERE 'client_id=$client_id' ";
        echo $query;  


        try{
            $consult = $pdo->prepare(query);
            handler($pdo,$table);
        }catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        }
    }
?>