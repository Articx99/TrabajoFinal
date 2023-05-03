<style>
    th {
        width: auto;
    }

    td {
        text-align: left;
    }

    #rol_label {
        margin-bottom: 33px;
        margin-right: 5px;
        font-size: 20px;
        font-family: Arial, helvetica, sans-serif;
        color: black;
    }

    #checkbox {
        margin-left: 20px;
    }
</style>

<?= $header ?>
<?php if (isset($_SESSION['mensaje'])) { ?>
    <h2 class="alert alert-<?php echo $_SESSION['mensaje']['class'] ?>" id='message'><?= $_SESSION['mensaje']['texto'] ?>
    </h2>
    <?php unset($_SESSION['mensaje']);
} ?>


<form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2"
    action="<?= site_url("/saveUser") ?>" method="post">
    <div class="col d-flex justify-content-between">
        <div class="form-outline flex-grow-1 me-1 mx-1">
            <input type="hidden" name='id_usuario' value="">
            <input type="text" id="username" class="form-control" name="username" />
            <label class="form-label" for="username">Introduce nuevo usuario: </label>
            <small class="text-small text-danger">
                <?php echo isset($error['username']) ? $error['username'] : "" ?>
            </small>
        </div>
        <div class="form-outline flex-grow-1 me-1 mx-1">
            <input type="password" name="pass" class="form-control" value="">
            <label for="pass">Contraseña:</label>
            <small class="text-small text-danger">
                <?php echo isset($error['pass']) ? $error['pass'] : "" ?>
            </small>
        </div>
        <div class="form-outline flex-grow-1 me-1 mx-1">

            <input type="password" name="pass-repeat" class="form-control" value="">
            <label for="pass">Repite Contraseña:</label>
            <small class="text-small text-danger">
                <?php echo isset($error['pass-repeat']) ? $error['pass-repeat'] : "" ?>
            </small>
        </div>
        <div class="col-md-auto col-auto d-flex justify-content-between">
            <label for="id_rol" class="align-self-center" id="rol_label">Rol:</label>
            <select class="form-control mx-1" name="id_rol">
                <?php
                if (count($roles) > 0) {
                    foreach ($roles as $rol) { ?>
                        <option value="<?php echo $rol['id_rol'] ?>" <?php echo (2 == $rol['id_rol']) ? 'selected' : ''; ?>>
                            <?php echo $rol['nombre_rol'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <p class="text-danger mb-0">
                <?php echo isset($errores['id_rol']) ? $errores['id_rol'] : ''; ?>
            </p>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary form-control">Guardar</button>
        </div>

    </div>
</form>


<table class="table mb-4">
    <thead>
        <tr>
            <th scope="col" style="width: auto;">id</th>
            <th scope="col" style="width: auto;">username</th>
            <th scope="col" style="width: auto;">pass</th>
            <th scope="col" style="width: auto;">Rol</th>
            <th scope="col" style="width: auto;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($usuarios) && is_array($usuarios)): ?>


            <?php foreach ($usuarios as $usuario): ?>
                <tr class="<?php echo 'id' . $usuario['id_usuario'] ?>">
                    <th scope="row">
                        <?= esc($usuario['id_usuario']) ?>
                    </th>
                    <td>
                        <?= esc($usuario['username']) ?>
                    </td>
                    <td>
                        <?= esc($usuario['pass']) ?>
                    </td>
                    <td>
                        <?= esc($usuario['nombre_rol']) ?>
                    </td>
                    <td>
                        <button class="btn btn-danger button-to-strike"
                            onclick="deleteItem('<?php echo $usuario['id_usuario'] ?>','deleteUser')">Delete</button>

                        <a href="<?= base_url('edit/' . $usuario['id_usuario']) ?>" class="btn btn-info button-to-strike"
                            type="button">Editar</a>

                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    <?php else: ?>

        <h3>No Existen Usuarios</h3>

    <?php endif ?>
</table>

<?= $footer ?>