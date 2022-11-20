<?php require("usuarios.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <style>
        .error {color: #FF0000;}
        .invalid-feedback{ display:block !important}
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="post" id="formUsuarios" enctype="multipart/form-data">
            <!-- Modal -->
            <div class="modal fade" id="usuariosModal" tabindex="-1" role="dialog" aria-labelledby="usuariosModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="usuariosModalLabel">Usuarios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <input type="hidden" required name="txtID" value="<?php echo $txtID; ?>" placeholder="" id="txt1" require="">
                            
                            <div class="form-group col-md-4">
                                <label class="col-form-label"><span class="error">* </span>Usuario:</label>
                                <input type="text" class="form-control" name="txtUSU" value="<?php echo $txtUSU; ?>" placeholder="" id="txt2" require="">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label">Nombre(s):</label>
                                <input type="text" class="form-control" name="txtNombres" value="<?php echo $txtNombres; ?>" placeholder="" id="txt4" require="">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Apellido(s):</label>
                                <input type="text" class="form-control" name="txtApellidos" value="<?php echo $txtApellidos; ?>" placeholder="" id="txt5" require="">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="col-form-label"><span class="error">* </span>Correo:</label>
                                <input type="text" class="form-control <?php echo (isset($emailErr))?(!empty($emailErr))?"is-invalid":"is-valid":"";?>" name="txtEmail" value="<?php echo $txtEmail; ?>" placeholder="" id="txt3" require="">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="col-form-label">Repita el Correo:</label>
                                <input type="text" class="form-control <?php echo (isset($emailErr2))?(!empty($emailErr2))?"is-invalid":"is-valid":"";?>" name="txtEmail2" value="<?php echo $txtEmail2; ?>" placeholder="" id="txt31" require="">
                            </div>                 

                            <div class="form-group col-md-5">
                                <label class="col-form-label"><span class="error">* </span>Contraseña:</label>
                                <input type="text" class="form-control <?php echo (isset($claveErr))?(!empty($claveErr))?"is-invalid":"is-valid":"";?>" name="txtPassword" value="<?php echo $txtPassword; ?>" placeholder="" id="txt6" require="">
                            </div>
                            <div class="form-group col-md-5">
                                <label class="col-form-label">Repita Contraseña:</label>
                                <input type="text" class="form-control <?php echo (isset($claveErr))?(!empty($claveErr))?"is-invalid":"is-valid":"";?>"  name="txtPassword2" value="<?php echo $txtPassword2; ?>"placeholder="" id="txt61" require="">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label">Acceso:</label>
                                <input type="text" class="form-control" name="txtAcceso" value="<?php echo $txtAcceso; ?>" placeholder="" id="txt7" require="">
                            </div>

                            <div class="form-group col-md-12">
                                <label class="col-form-label">Fotografia:</label>

                                <?php if($txtFoto!=''){ ?>
                                    <br>
                                    <img src="../img/<?php echo $txtFoto; ?>" alt="" class="img-thumbnail rounded mx-auto d-block" width="100px">
                                    <br>
                                <?php } ?>

                                <input type="file" class="form-control" accept="image/*" name="txtFoto" value="<?php echo $txtFoto; ?>" placeholder="" id="txt8" require="">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">                                
                        <button value="btnAgregar" <?php echo $accionAgregar?> class="btn btn-success" type="submit" name="accion">Agregar</button>
                        <button value="btnModificar" <?php echo $accionModificar?> class="btn btn-warning" type="submit" name="accion">Modificar</button>
                        <button value="btnEliminar" <?php echo $accionEliminar?> class="btn btn-danger" type="submit" name="accion">Eliminar</button>
                        <button value="btnCancelar" <?php echo $accionCancelar?> class="btn btn-primary" type="submit" name="accion">Cancelar</button>
                    </div>
                </div>
            </div>
            </div>
            <br><br>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#usuariosModal">
                Agregar Registro +
            </button>
        </form>
        <br>
        <div class="row">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Usuario</th>
                        <th>Nombre y Apellidos</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <?php foreach($listaUsuarios as $usuario){ ?>
                    <tr>
                        <td><img class="img-thumbnail" width="100px" src="../img/<?php echo $usuario['foto']; ?>" alt=""> </td>
                        <td><?php echo $usuario['nomuser']; ?></td>
                        <td><?php echo $usuario['nombre']; ?> <?php echo $usuario['apellido']; ?></td>
                        <td><?php echo $usuario['correo']; ?></td>
                        <td>
                        
                        <form action="" method="post">
                            <input type="hidden" name="txtID" value="<?php echo $usuario['id']; ?>">
                            <input type="submit" class="btn btn-info" value="Seleccionar" name="accion"> 
                            <button value="btnEliminar" type="submit" class="btn btn-danger" name="accion">Eliminar</button>
                        </form>

                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php if($mostrarModal){?>
            <script>
                $('#usuariosModal').modal('show');
            </script>
        <?php }?>
        <script>
            $(document).ready(function() {
                function validateEmail(email) {
                    let res = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                    return res.test(email);
                }
                $('#formUsuarios').on('submit', function(event) {
                    var $searchValue = "";
                    var error = '<span style="color: red;">Error. Vacio.</span>';
                    for (let index = 2; index <= 10; index++) {
                        switch (index) {
                            case 2:
                                input = document.getElementById("txt2");
                                inputnom = "txt2";
                                break;
                            case 3:
                                input = document.getElementById("txt3");
                                inputnom = "txt3";
                                break;
                            case 4:
                                input = document.getElementById("txt31");
                                inputnom = "txt31";
                                break;
                            case 5:
                                input = document.getElementById("txt6");
                                inputnom = "txt6";
                                break;
                            case 6:
                                input = document.getElementById("txt61");
                                inputnom = "txt61";
                                break;
                            case 7:
                                error = '<span style="color: red;">Email deben ser Iguales</span>';
                                input1 = document.getElementById("txt3");
                                input2 = document.getElementById("txt31");
                                $searchValue = "x";
                                if(input1.value != input2.value){
                                    $searchValue = "";
                                } 
                                inputnom = "txt31";
                                break;
                            case 8:
                                error = '<span style="color: red;">Password deben ser Iguales</span>';
                                input1 = document.getElementById("txt6");
                                input2 = document.getElementById("txt61");
                                $searchValue = "x";
                                if(input1.value != input2.value){
                                    $searchValue = "";
                                } 
                                inputnom = "txt61";
                                break;
                            case 9:
                                error = '<span style="color: red;">Email Invalido</span>';
                                input = document.getElementById("txt3");
                                $searchValue = input.value;
                                if(!validateEmail($searchValue)) {
                                    $searchValue = "";
                                } 
                                inputnom = "txt3";
                                break;
                            case 10:
                                error = '<span style="color: red;">Email Invalido</span>';
                                input = document.getElementById("txt31");
                                $searchValue = input.value;
                                if(!validateEmail($searchValue)) {
                                    $searchValue = "";
                                } 
                                inputnom = "txt31";
                                break;
                        }
                        if(index<=6){
                            $searchValue = input.value;
                        }
                        $("#"+inputnom).removeClass("is-invalid");
                        $("#"+inputnom).addClass("is-valid");
                        if ($searchValue === "") {
                            event.preventDefault();
                            $("#"+inputnom).removeClass("is-valid");
                            $("#"+inputnom).addClass("is-invalid");
                            $("#"+inputnom).after($(error).fadeOut(2000));
                            $("#"+inputnom).css( "border-color","red");
                         }
                    }
                    

                });
            });
        </script>
    </div>
</body>
</html>