<?php ob_start() ?>


    <div class="div-perfil container text-center p-1">
        <form id="perfilForm" action="index.php?ctl=perfil" method="post" enctype="multipart/form-data">
            <div class="div-atr">
                <div class="box"><img class="foto-perfil" src=
                    <?php
                        echo "./img/" . $_SESSION['user'] . "/image.png";
                    ?>>
                </div>
                
                <!--User's information-->
                
                <label>User :</label>
                <div class="name-user">
                    <label><?php echo $userGet ?></label><br>
                </div>
                <label>Email :</label>
                <div class="user-box">
                    <input type="text" value="<?php echo $emailGet?>" name="Email" id="Email" class="slope"></input><br>
                </div>
               
              
                <label>Change image of profile :</label><br>
                <input type="file" name="imagen" id="imagen"/>
                <br>
                <input type="submit" class="buttonForm optionButton" name="submitImage" value="Acept"/>
                <input type="button" id="Cancel" class="buttonForm optionButton" name="Cancel" value="Cancel" onClick="perfil.php"/>
                <br>
            </div>
            <input type="submit" class="buttonForm" name="SignOff" value="Log out" />
            <br>
            <?php
                if (isset($_REQUEST["SignOff"])) {
                    session_destroy();
                    header("location:index.php?ctl=inicio");
                }
            ?>
            <?php
                if (isset($_REQUEST["SignOff"])) {
                    session_destroy();
                    header("location:index.php?ctl=inicio");
                }
            ?>
        </form>
    </div>

    <footer>
<div  class=" pie ">
		<div  >
			<div class="prueba">
			<div id="textoFooter">
			<p>Contáctanos</p>
	<p>Asociación GUP

C/ Ntra. Sra. de la Asunción, 2.   46020 Valencia

</p>
<p>

Teléfono 616420909

</p>
<p>

asociaciongup@hotmail.es



</p>
<a  href="https://www.facebook.com/asociaciongup/?locale=es_ES"><img id="socialMedia"  src="./img/facebook.png" ></img></a>
		<a href="https://www.instagram.com/asociaciongup/?hl=es">	<img  id="socialMedia"  src="./img/instgram3.png" ></img></a>
</div>
			</div>
		
		</div>
	</div>
	</footer>
    <script>
        //Restores values of inputs to nothing =""
        let cancel = document.getElementById("Cancel");

        cancel.addEventListener('click', () => {
            let cancelV = document.querySelectorAll(".slope");
            cancelV.forEach(name => {
                document.getElementById(name.id).value = "";
            })
        });
    </script>
</body>
 
</html>
<?php
    if (isset($_REQUEST['submitImage'])) {
        if (($_FILES['imagen']['error'] != 0)) {
            switch ($_FILES['imagen']['error']) {
                case 1:
                    $errors["imagen"] = "UPLOAD_ERR_INI_SIZE. File very big";
                    break;
                case 2:
                    $errors["imagen"] = "UPLOAD_ERR_FORM_SIZE. File very big";
                    break;
                case 3:
                    $errors["imagen"] = "UPLOAD_ERR_PARTIAL. File update is interrumpt ";
                    break;
                case 4:
                    $errors["imagen"] = "UPLOAD_ERR_NO_FILE. File is not update";
                    break;
                case 6:
                    $errors["imagen"] = "UPLOAD_ERR_NO_TMP_DIR. Without temporal folder <br>";
                case 7:
                    $errors["imagen"] = "UPLOAD_ERR_CANT_WRITE. Not to write in the disk<br>";

                default:
                    $errors["imagen"] = 'Error undefined.';
            }
        } else {
            $nameFile = $_FILES['imagen']['name'];
            $directorioTemp = $_FILES['imagen']['tmp_name'];

            $tamanyoFile = filesize($directorioTemp);
            $extension = strtolower(pathinfo($nameFile, PATHINFO_EXTENSION));

            if (!in_array($extension, $extensions)) {
                $errors["imagen"] = "The extension is not valid";
            }
            if ($tamanyoFile > $max_file_size) {
                $errors["imagen"] = "The image is more " . $max_file_size;
            }

            if (empty($errors)) {
                //change img profile in this page
                $nameFile = "image.png";
                if (is_file("./img/" . $_SESSION['user'] . "/" . $nameFile)) {
                    unlink("./img/" . $_SESSION['user'] . "/image.png");
                }

                move_uploaded_file($directorioTemp, './img/' . $_SESSION['user'] . '/' . $nameFile);
                header("Refresh:0");
            }
        }
        try {
            //if email and name are true in the base is update
            // $checkEmail = false;
            
            if (preg_match("#[\w\._]{3,}@\w{5,}\.+[\w]{2,}#i", $_REQUEST["Email"]) == 1) {
                $usuario = new Usuario();

                // if ($emailCom = $usuario->checkEmail($_REQUEST["Email"])) {
                    $update = $usuario->actualizainfo( $_REQUEST["Email"]);
                // } else {
                    // $checkEmail = true;
                // }
            }  
        } catch (PDOException $e) {
            error_log($e->getMessage() . "##Code: " . $e->getCode() . "  " . microtime() . PHP_EOL, 3, "../logBD.txt");
            // save errors
            $errorsGuide['NoGuide'] = "Error <br>";
        }
      
    }


?>



<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>





