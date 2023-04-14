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
            <input type="hidden" name='id_usuario' value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''?>">
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
            <th scope="col" id="TableStart" style="width: 100px;">Hecho</th>
            <th scope="col" style="width: auto;">No.</th>
            <th scope="col" style="width: auto;">Para Hacer</th>
            <th scope="col" style="width: auto;">Estado</th>
            <th scope="col" style="width: auto;">Acciones</th>
            <?php if($_SESSION['admin_panel'] == 'rwd'):?>
                <th scope="col" style="width: auto;">Usuario</th>
            <?php endif?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tareas) && is_array($tareas)):?>
          

            <?php foreach ($tareas as $tarea): ?>
                <?php if($tarea['id_usuario'] == $_SESSION['id'] || $_SESSION['admin_panel'] == 'rwd'):?>
                <tr class="complete">
                    <td>
                        <input class="form-check-input" type="checkbox" id="checkbox" value="option1">
                    </td>
                    <th scope="row">
                        <?= esc($tarea['id']) ?>
                    </th>
                    <td>
                        <?= esc($tarea['tarea']) ?>
                    </td>
                    <td>
                        <?= esc($tarea['nombre_estado']) ?>
                    </td>

                    <td>
                        <a href="<?= base_url('delete/' . $tarea['id']) ?>" class="btn btn-danger button-to-strike"
                            type="button">Delete</a>
                        <a href="<?= base_url('edit/' . $tarea['id']) ?>" class="btn btn-info button-to-strike"
                            type="button">Editar</a>
                    </td>
                    <?php if($_SESSION['admin_panel'] == 'rwd'):?>
                    <td>
                        <?= esc($tarea['username']) ?>
                    </td>
                    <?php endif?>
                </tr>
                <?php endif?>
            <?php endforeach ?>
        </tbody>
    <?php else: ?>

        <h3>No News</h3>

        <p>Unable to find any news for you.</p>

    <?php endif ?>
</table>

<?= $footer ?>
