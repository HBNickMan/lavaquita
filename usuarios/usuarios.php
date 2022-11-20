<?php
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtUSU=(isset($_POST['txtUSU']))?$_POST['txtUSU']:"";
    $txtEmail=(isset($_POST['txtEmail']))?$_POST['txtEmail']:"";
    $txtEmail2=(isset($_POST['txtEmail2']))?$_POST['txtEmail2']:"";
    $txtNombres=(isset($_POST['txtNombres']))?$_POST['txtNombres']:"";
    $txtApellidos=(isset($_POST['txtApellidos']))?$_POST['txtApellidos']:"";
    $txtPassword=(isset($_POST['txtPassword']))?$_POST['txtPassword']:"";
    $txtPassword2=(isset($_POST['txtPassword2']))?$_POST['txtPassword2']:"";
    $txtAcceso=(isset($_POST['txtAcceso']))?$_POST['txtAcceso']:"";
    $txtFoto=(isset($_FILES['txtFoto']["name"]))?$_FILES['txtFoto']["name"]:"";

    $accion=(isset($_POST['accion']))?$_POST['accion']:"";

    $accionAgregar=$accionCancelar="";
    $accionModificar=$accionEliminar="disabled";
    $mostrarModal=false;

    function validar_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    include("../conexion/conexion.php");

    switch ($accion) {
        case 'btnAgregar':
            $txtAcceso=(!empty($txtAcceso))?$txtAcceso:"2";
            $sentencia = $pdo->prepare("INSERT INTO usuarios(nomuser,correo,nombre,apellido,password,acceso,foto) VALUES (:Nomuser,:Correo,:Nombre,:Apellido,:Password,:Acceso,:Foto)");
            $sentencia->bindParam(':Nomuser',$txtUSU);
            $sentencia->bindParam(':Correo',$txtEmail);
            $sentencia->bindParam(':Nombre',$txtNombres);
            $sentencia->bindParam(':Apellido',$txtApellidos);
            $sentencia->bindParam(':Password',$txtPassword);
            $sentencia->bindParam(':Acceso',$txtAcceso);

            $Fecha= new DateTime();
            $nombreArchivo=($txtFoto!="")?$Fecha->getTimestamp()."_".$_FILES['txtFoto']["name"]:"imagen.jpg";
            $tmpFoto=$_FILES['txtFoto']["tmp_name"];
            if($tmpFoto!=""){
                move_uploaded_file($tmpFoto,"../img/".$nombreArchivo);
            }

            $sentencia->bindParam(':Foto',$nombreArchivo);
            $sentencia->execute();
            header('Location: ./index.php');
            break;
        case 'btnModificar':
            $sentencia = $pdo->prepare("UPDATE usuarios SET 
            nomuser=:Nomuser,
            correo=:Correo,
            nombre=:Nombre,
            apellido=:Apellido,
            password=:Password,
            acceso=:Acceso 
            WHERE id=:id");

            $sentencia->bindParam(':Nomuser',$txtUSU);
            $sentencia->bindParam(':Correo',$txtEmail);
            $sentencia->bindParam(':Nombre',$txtNombres);
            $sentencia->bindParam(':Apellido',$txtApellidos);
            $sentencia->bindParam(':Password',$txtPassword);
            $sentencia->bindParam(':Acceso',$txtAcceso);
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();

            $Fecha= new DateTime();
            $nombreArchivo=($txtFoto!="")?$Fecha->getTimestamp()."_".$_FILES['txtFoto']["name"]:"imagen.jpg";
            $tmpFoto=$_FILES['txtFoto']["tmp_name"];
            if($tmpFoto!=""){
                move_uploaded_file($tmpFoto,"../img/".$nombreArchivo);

                $sentencia = $pdo->prepare("SELECT Foto FROM usuarios WHERE id=:id");
                $sentencia->bindParam(':id',$txtID);
                $sentencia->execute();
                $usuario=$sentencia->fetch(PDO::FETCH_LAZY);
                if (isset($usuario["Foto"])) {
                    if (file_exists("../img/".$usuario["Foto"])) {
                        if($usuario['Foto']!="imagen.jpg"){
                            unlink("../img/".$usuario["Foto"]);
                        }
                    }
                }

                $sentencia = $pdo->prepare("UPDATE usuarios SET 
                foto=:Foto WHERE id=:id");
                $sentencia->bindParam(':Foto',$nombreArchivo);
                $sentencia->bindParam(':id',$txtID);
                $sentencia->execute();
                
            }

            header('Location: ./index.php');
            break;
        case 'btnEliminar':
            $sentencia = $pdo->prepare("SELECT Foto FROM usuarios WHERE id=:id");
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();
            $usuario=$sentencia->fetch(PDO::FETCH_LAZY);
            if (isset($usuario["Foto"]) && $usuario['Foto']!="imagen.jpg" ) {
                if (file_exists("../img/".$usuario["Foto"])) {
                    unlink("../img/".$usuario["Foto"]);
                }
            }

            $sentencia = $pdo->prepare("DELETE FROM usuarios WHERE id=:id");
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();
            header('Location: ./index.php');
            break;
        case 'btnCancelar':
            header('Location: ./index.php');
        case 'Seleccionar':
            $accionAgregar="disabled";
            $accionModificar=$accionEliminar=$accionCancelar="";
            $mostrarModal=true;
            $sentencia = $pdo->prepare("SELECT * FROM usuarios WHERE id=:id");
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();
            $usuario=$sentencia->fetch(PDO::FETCH_LAZY);

            $txtUSU=$usuario['nomuser'];
            $txtEmail=$usuario['correo'];
            $txtEmail2=$usuario['correo'];
            $txtNombres=$usuario['nombre'];
            $txtApellidos=$usuario['apellido'];
            $txtPassword=$usuario['password'];
            $txtPassword2=$usuario['password'];
            $txtAcceso=$usuario['acceso'];
            $txtFoto=$usuario['foto'];
            break;
    }

    $sentencia = $pdo->prepare("SELECT * FROM usuarios WHERE 1");
    $sentencia->execute();
    $listaUsuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

?>