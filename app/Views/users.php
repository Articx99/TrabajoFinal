<style>
    th {
        width: auto;
    }

    td {
        text-align: left;
    }

    #checkbox {
        margin-left: 20px;
    }
</style>

<?= $header ?>
<?php if (isset($_SESSION['mensaje'])) { ?>
    <h2 class="text-<?php echo $_SESSION['mensaje']['class'] ?>"><?= $_SESSION['mensaje']['texto'] ?></h2>
    <?php unset($_SESSION['mensaje']);
} ?>


<form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2"
    action="<?= site_url("/save") ?>" method="post">
    <div class="col d-flex justify-content-between">
        <div class="form-outline flex-grow-1 me-1 mx-1">
            <input type="hidden" name='id_usuario' value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '' ?>">
            <input type="text" id="task" class="form-control" name="task" />
            <label class="form-label" for="task">Introduce nueva tarea: </label>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary form-control">Guardar</button>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning form-control ">Ver tarea</button>
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
                    <tr class="complete">
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
                            <a href="<?php echo base_url('deleteUser/' . $usuario['id_usuario']) ?>"
                                class="btn btn-danger button-to-strike" type="button">Delete</a>
                            
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