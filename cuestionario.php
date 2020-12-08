<?php

session_start();

?>

<!DOCTYPE html>
<html>

<body>

    <h1>Cuestionario de satisfacción del cliente</h1>

    <form action="http://localhost/cuestionario.php" method="GET">
        <label for="email">Ingrese su email: </label> <br>
        <input type="email" id="email" name="email" required><br><br>
        <label>Nivel de satisfacción:</label><br>
        <input type="radio" name="nivel_satisfaccion" value="alto"> <label>Alto</label><br>
        <input type="radio" name="nivel_satisfaccion" value="medio"> <label>Medio</label><br>
        <input type="radio" name="nivel_satisfaccion" value="bajo"> <label>Bajo</label><br><br>
        <input type="submit" value="Enviar">
    </form>



</body>

</html>


<?php


$b=false;

$lista_emails = explode("," , $_SESSION["listaemails"]);
if(isset($_GET['email']) and isset($_GET["nivel_satisfaccion"])){

    if(!isset($_SESSION["listaemails"])){
        $_SESSION["listaemails"] = $_GET["email"];
        
    }
    else{
        foreach($lista_emails as $em){
            if ($_GET["email"] == $em) {
                echo "Este email ya ha participado en la encuesta, utilice otro";
                $b = true;
                break;
            }
        }
    }
        if ($b == false) {
            $_SESSION["listaemails"] = $_SESSION["listaemails"] . "," . $_GET["email"];
            if ($_GET["nivel_satisfaccion"] == "alto") {
                $_SESSION["alto"] = (intval($_SESSION["alto"])+1);
            }
            else if ($_GET["nivel_satisfaccion"] == "medio") {
                $_SESSION["medio"] = (intval($_SESSION["medio"])+1);
            }
            else if ($_GET["nivel_satisfaccion"] == "bajo") {
                $_SESSION["bajo"] = (intval($_SESSION["bajo"])+1);
            }
            $participaciones = intval($_SESSION["alto"]) + intval($_SESSION["medio"]) + intval($_SESSION["bajo"]);
            $porcentalto = (intval($_SESSION["alto"]) * 100) / $participaciones;
            $porcentmedio = (intval($_SESSION["medio"]) * 100) / $participaciones;
            $porcentbajo = (intval($_SESSION["bajo"]) * 100) / $participaciones;

            echo "<h3>Resultados de las participaciones:</h3>" . "<br>" . "Nivel de satisfacción alto: " . $_SESSION["alto"] . " personas (" . round($porcentalto,2) . "% de las participaciones)" . "<br>" . "Nivel de satisfacción medio: ". $_SESSION["medio"] . " personas (" . round($porcentmedio,2) . "% de las participaciones)" . "<br>" . "Nivel de satisfacción bajo: ". $_SESSION["bajo"] . " personas (" . round($porcentbajo,2) . "% de las participaciones)";
            echo "<p>Número de participaciones: " . $participaciones . "</p>";
        }
    }
    else {
    	echo "Elija el nivel de satisfacción.";
    }



?>

