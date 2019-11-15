<?php
/**
 * * Descripción: Controlador principal
 * *
 * * Descripción extensa: Iremos añadiendo cosas complejas en PHP.
 * *
 * * @author  Rocio <al342129@uji.es> 
 * * @copyright 2019 Rocio
 * * @license http://www.fsf.org/licensing/licenses/gpl.txt GPL 2 or later
 * * @version 2
 * */


//Estas 2 instrucciones me aseguran que el usuario accede a través del WP. Y no directamente
if ( ! defined( 'WPINC' ) ) exit;

if ( ! defined( 'ABSPATH' ) ) exit;




//Funcion instalación plugin. Crea tabla
function UB_MP_CrearT($UB_table){
    
    $UB_MP_pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD); 
    $UB_query="CREATE TABLE IF NOT EXISTS $UB_table (person_id INT(11) NOT NULL AUTO_INCREMENT, nombre VARCHAR(100),  email VARCHAR(200),  foto_file VARCHAR(200), clienteMail VARCHAR(100),  PRIMARY KEY(person_id))";
    $UB_consult = $UB_MP_pdo->prepare($UB_query);
    $UB_consult->execute (array());
}


function UB_MP_Register_Form($UB_MP_user , $UB_user_email)
{//formulario registro amigos de $user_email
    ?>
    <h1>Gestión de Usuarios </h1>
    <form class="fom_usuario" action="?action=my_datos&proceso=registrar" method="POST">
        <label for="clienteMail">Tu correo</label>
        <br/>
        <input type="text" name="clienteMail"  size="20" maxlength="25" value="<?php print $user_email?>"
        readonly />
        <br/>
        <legend>Datos básicos</legend>
        <label for="nombre">Nombre</label>
        <br/>
        <input type="text" name="userName" class="item_requerid" size="20" maxlength="25" value="<?php print $UB_MP_user["userName"] ?>"
        placeholder="Miguel Cervantes" />
        <br/>
        <label for="email">Email</label>
        <br/>
        <input type="text" name="email" class="item_requerid" size="20" maxlength="25" value="<?php print $UB_MP_user["email"] ?>"
        placeholder="kiko@ic.es" />
        <br/>
        <input type="file" name="foto_file" size="20" maxlength="25" value="<?php print $UB_MP_user["foto_file"] ?>" />
        <br/>
        <input type="submit" value="Enviar">
        <input type="reset" value="Deshacer">
    </form>
<?php
}

//CONTROLADOR
//Esta función realizará distintas acciones en función del valor del parámetro
//$_REQUEST['proceso'], o sea se activara al llamar a url semejantes a 
//https://host/wp-admin/admin-post.php?action=my_datos&proceso=r 

function UB_MP_my_datos()
{ 
    global $UB_user_ID , $UB_user_email, $UB_table;
    
    $UB_MP_pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD); 
    wp_get_current_user();
    if ('' == $UB_user_ID) {
                //no user logged in
                exit;
    }
    
    
    
    if (!(isset($_REQUEST['action'])) or !(isset($_REQUEST['proceso']))) { print("Opciones no correctas $user_email"); exit;}

    get_header();
    echo '<div class="wrap">';

    switch ($_REQUEST['proceso']) {
        case "registro":
            $UB_MP_user=null; //variable a rellenar cuando usamos modificar con este formulario
            UB_MP_Register_Form($UB_MP_user, $UB_user_email);
            break;
        case "registrar":
            if (count($_REQUEST) < 3) {
                print ("No has rellenado el formulario correctamente");
                return;
            }
            
            $fotoURL="";
            $IMAGENES_USUARIOS = '../fotos/';
            if(array_key_exists('foto_file', $_FILES) && $_POST['email']) {
                $fotoURL = $IMAGENES_USUARIOS.$_POST['userName']."_".$_FILES['foto_file']['name'];
                    if (move_uploaded_file($_FILES['foto_file']['tmp_name'], $fotoURL))
                        { echo "foto subida con éxito";
                    } 
            }
            
            $UB_query = "INSERT INTO $UB_table (nombre, email,clienteMail, foto_file) VALUES (?,?,?,?)";         
            $a=array($_REQUEST['userName'], $_REQUEST['email'],$_REQUEST['clienteMail'], $fotoURL);
            //$pdo1 = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD); 
            $consult = $UB_MP_pdo->prepare($UB_query);
            $a=$consult->execute($a);
            if (1>$a) {echo "InCorrecto $UB_query";}
            else wp_redirect(admin_url( 'admin-post.php?action=my_datos&proceso=listar'));
            break;
            
        case "listar":
            //Listado amigos o de todos si se es administrador.
            $a=array();
            if (current_user_can('administrator')) {$UB_query = "SELECT     * FROM       $UB_table ";}
            else {$campo="clienteMail"; $campo2="clienteMail";
                $UB_query = "SELECT     * FROM  $UB_table      WHERE $campo = ? OR $campo2 = ? ";
                $a=array( $user_email, $fotoURL);
 
            } 

            $consult = $UB_MP_pdo->prepare($UB_query);
            $a=$consult->execute($a);
            $rows=$consult->fetchAll(PDO::FETCH_ASSOC);
            if (is_array($rows)) {/* Creamos un listado como una tabla HTML*/
                print '<div><table><th>';
                foreach ( array_keys($rows[0])as $key) {
                    echo "<td>", $key,"</td>";
                }
                print "</th>";
                foreach ($rows as $row) {
                    print "<tr>";
                    foreach ($row as $key => $val) {
                        echo "<td>", $val, "</td>";
                    }
                    print "</tr>";
                }
                print "</table></div>";
            }
            else{echo "No existen valores";}
            break;
        default:
            print "Opción no correcta";
        
    }
    echo "</div>";
    // get_footer ademas del pie de página carga el toolbar de administración de wordpres si es un 
    //usuario autentificado, por ello voy a borrar la acción cuando no es un administrador para que no aparezca.
    if (!current_user_can('administrator')) {

        // for the admin page
        remove_action('admin_footer', 'wp_admin_bar_render', 1000);
        // for the front-end
        remove_action('wp_footer', 'wp_admin_bar_render', 1000);
    }

    get_footer();
    }
//add_action('admin_post_nopriv_my_datos', 'my_datos');
//add_action('admin_post_my_datos', 'my_datos'); //no autentificados
?>
