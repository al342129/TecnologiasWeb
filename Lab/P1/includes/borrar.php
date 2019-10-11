
<?php

/**
*@title: Exercici 11
* @author Rocío y David &lt;al342129@uji.es&gt; * @copyright 2019 Rocío
* @license CC-BY-NC-SA
*/


    include("./gestionBD.php");
    function handler($pdo,$table)
    {
		$datos = $_REQUEST;
        $table = "A_cliente";   
		var_dump($query);
        $query = " DELETE  FROM  $table WHERE client_id = ? ";
        
        try{
			$a = array($_REQUEST['client_id']);
            $consult = $pdo->prepare($query);
            handler($pdo,$table);
            $a=$consult->execute(array($_REQUEST['client_id']));
            if (1>$a) echo "InCorrecto1";
            echo $query;  
            
        }catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        }
    }
?>