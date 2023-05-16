<?= $header ?>
<style>
    th {
        width: auto;
    }

    td {
        text-align: left;
    }

    #users_label {
        margin-bottom: 33px;
        margin-right: 5px;
        font-size: 20px;
        font-family: Arial, helvetica, sans-serif;
        color: black;
    }

    #checkbox {
        margin-left: 20px;
    }

    .rounded-circle {
        border: 1px solid;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: inline-block;
        /* o display: inline; */
    }


    input[type="color"] {
        width: 50px;
        padding: 0;
        border: none;
        outline: none;
    }

    .error-message {
        margin-top: 5px;
        font-size: 12px;
    }
</style>


<?php if (isset($_SESSION['mensaje'])) { ?>
    <h2 class="alert alert-<?php echo $_SESSION['mensaje']['class'] ?>"><?= $_SESSION['mensaje']['texto'] ?></h2>
    <?php unset($_SESSION['mensaje']);
} ?>

<form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2" action="/editUser"
    method="post">
    <div class="col d-flex justify-content-between">
        <div class="form-outline flex-grow-1 me-1 mx-1">
            <input type="hidden" name='id_usuario' value="<?php echo $usuarios['id_usuario'] ?>">
            <input type="text" id="username" class="form-control" name="username"
                value="<?php echo $usuarios['username'] ?>" />
            <label class="form-label" for="nombre_etiqueta">Nombre de usuario:</label>
            <small class="text-small text-danger error-message">
                <?php echo isset($errors['username']) ? $errors['username'] : "" ?>
            </small>
        </div>

        <div class="col-md-auto col-auto d-flex justify-content-between">
            <label for="pass" id="users_label">Contraseña:</label>
            <input type="password" name="pass" class="form-control" value="">
            <small class="text-small text-danger error-message">
                <?php echo isset($errors['pass']) ? $errors['pass'] : "" ?>
            </small>
        </div>
        <div class="col-md-auto col-auto d-flex justify-content-between">
            <label for="pass" id="users_label">Repite&nbsp;contraseña:</label>
            <input type="password" name="pass-repeat" class="form-control" value="">
            <p class="text-small text-danger error-message">
                <?php echo isset($errors['pass-repeat']) ? $errors['pass-repeat'] : "" ?>
            </p>
        </div>
        <div class="col-md-auto col-auto d-flex justify-content-between">
            <label for="id_rol" class="align-self-center" id="users_label">Roles:</label>
            <select class="form-control mx-1" name="id_rol">
                <?php
                if (count($roles) > 0) {
                    foreach ($roles as $rol) {
                        ?>
                        <option value="<?php echo $rol['id_rol'] ?>" <?php echo ($usuarios['id_rol'] == $rol['id_rol']) ? 'selected' : ''; ?>>
                            <?php echo $rol['nombre_rol'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <p class="text-small text-danger error-message mb-0">
                <?php echo isset($errors['id_rol']) ? $errors['id_rol'] : ''; ?>
            </p>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary form-control">Guardar</button>
        </div>
    </div>
</form>
<?= $footer ?>