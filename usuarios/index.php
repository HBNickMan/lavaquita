<?php
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtUSU=(isset($_POST['txtUSU']))?$_POST['txtUSU']:"";
    $txtEmail=(isset($_POST['txtEmail']))?$_POST['txtEmail']:"";
    $txtNombres=(isset($_POST['txtNombres']))?$_POST['txtNombres']:"";
    $txtApellidos=(isset($_POST['txtApellidos']))?$_POST['txtApellidos']:"";
    $txtPassword=(isset($_POST['txtPassword']))?$_POST['txtPassword']:"";
    $txtAcceso=(isset($_POST['txtAcceso']))?$_POST['txtAcceso']:"";
    $txtFoto=(isset($_FILES['txtFoto']["name"]))?$_FILES['txtFoto']["name"]:"";

    $accion=(isset($_POST['accion']))?$_POST['accion']:"";

    include("../conexion/conexion.php");

    switch ($accion) {
        case 'btnAgregar':
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
            echo $txtID;
            echo "Presionaste => btnAgregar";
            break;
        case 'btnModificar':
            $sentencia = $pdo->prepare("UPDATE usuarios SET 
            nomuser=:Nomuser,
            correo=:Correo,
            nombre=:Nombre,
            apellido=:Apellido,
            password=:Password,
            acceso=:Acceso,
            foto=:Foto WHERE
            id=:id");

            $sentencia->bindParam(':Nomuser',$txtUSU);
            $sentencia->bindParam(':Correo',$txtEmail);
            $sentencia->bindParam(':Nombre',$txtNombres);
            $sentencia->bindParam(':Apellido',$txtApellidos);
            $sentencia->bindParam(':Password',$txtPassword);
            $sentencia->bindParam(':Acceso',$txtAcceso);
            $sentencia->bindParam(':Foto',$txtFoto);
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();

            header('Location: index.php');
            echo $txtID;
            echo "Presionaste => btnModificar"; 
            break;
        case 'btnEliminar':
            $sentencia = $pdo->prepare("DELETE FROM usuarios WHERE id=:id");
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();
            header('Location: index.php');
            echo $txtID;
            echo "Presionaste => btnEliminar";
            break;
        case 'btnCancelar':
            echo $txtID;
            echo "Presionaste => btnCancelar";
            break;
    }

    $sentencia = $pdo->prepare("SELECT * FROM usuarios WHERE 1");
    $sentencia->execute();
    $listaUsuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    /*print_r($listaUsuarios);*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="">Id:</label>
            <input type="text" name="txtID" value="<?php echo $txtID; ?>" placeholder="" id="txt1" require="">
            <br>

            <label for="">Usuario:</label>
            <input type="text" name="txtUSU" value="<?php echo $txtUSU; ?>" placeholder="" id="txt2" require="">
            <br>

            <label for="">Correo:</label>
            <input type="text" name="txtEmail" value="<?php echo $txtEmail; ?>" placeholder="" id="txt3" require="">
            <br>

            <label for="">Nombre(s):</label>
            <input type="text" name="txtNombres" value="<?php echo $txtNombres; ?>" placeholder="" id="txt4" require="">
            <br>

            <label for="">Apellido(s):</label>
            <input type="text" name="txtApellidos" value="<?php echo $txtApellidos; ?>" placeholder="" id="txt5" require="">
            <br>

            <label for="">Contraseña:</label>
            <input type="text" name="txtPassword" value="<?php echo $txtPassword; ?>" placeholder="" id="txt6" require="">
            <br>

            <label for="">Acceso:</label>
            <input type="text" name="txtAcceso" value="<?php echo $txtAcceso; ?>" placeholder="" id="txt7" require="">
            <br>

            <label for="">Fotografia:</label>
            <input type="file" accept="image/*" name="txtFoto" value="<?php echo $txtFoto; ?>" placeholder="" id="txt8" require="">
            <br>

            <button value="btnAgregar" type="submit" name="accion">Agregar</button>
            <button value="btnModificar" type="submit" name="accion">Modificar</button>
            <button value="btnEliminar" type="submit" name="accion">Eliminar</button>
            <button value="btnCancelar" type="submit" name="accion">Cancelar</button>
        </form>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre y Apellidos</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <?php foreach($listaUsuarios as $usuario){ ?>
                    <tr>
                        <td><img class="img-thumbnail" width="100px" src="../img/<?php echo $usuario['foto']; ?>" alt=""> </td>
                        <td><?php echo $usuario['nombre']; ?> <?php echo $usuario['apellido']; ?></td>
                        <td><?php echo $usuario['correo']; ?></td>
                        <td>
                        
                        <form action="" method="post">
                            <input type="hidden" name="txtID" value="<?php echo $usuario['id']; ?>">
                            <input type="hidden" name="txtUSU" value="<?php echo $usuario['nomuser']; ?>">
                            <input type="hidden" name="txtEmail" value="<?php echo $usuario['correo']; ?>">
                            <input type="hidden" name="txtNombres" value="<?php echo $usuario['nombre']; ?>">
                            <input type="hidden" name="txtApellidos" value="<?php echo $usuario['apellido']; ?>">
                            <input type="hidden" name="txtPassword" value="<?php echo $usuario['password']; ?>">
                            <input type="hidden" name="txtAcceso" value="<?php echo $usuario['acceso']; ?>">
                            <input type="hidden" name="txtFoto" value="<?php echo $usuario['foto']; ?>">
                            <input type="submit" value="Seleccionar" name="accion"> 
                            <button value="btnEliminar" type="submit" name="accion">Eliminar</button>
                        </form>

                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>