<?= $header ?>
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


<?php if (isset($_SESSION['mensaje'])) { ?>
    <h2 class="text-<?php echo $_SESSION['mensaje']['class'] ?>"><?= $_SESSION['mensaje']['texto'] ?></h2>
    <?php unset($_SESSION['mensaje']);
} ?>
<?php if (!isset($borrador)): ?>
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
<?php endif ?>
<table class="table mb-4">
    <thead>
        <tr>
            <?php if (!isset($borrador)): ?>
                <th scope="col" id="TableStart" style="width: 100px;">Hecho</th>
            <?php endif ?>
            <th scope="col" style="width: auto;">No.</th>
            <th scope="col" style="width: auto;">Para Hacer</th>
            <th scope="col" style="width: auto;">Estado</th>
            <?php if ($_SESSION['admin_panel'] == 'rwd'): ?>
                <th scope="col" style="width: auto;">Usuario</th>
            <?php endif ?>
            <th scope="col" style="width: auto;">Acciones</th>

        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tareas) && is_array($tareas)): ?>


            <?php foreach ($tareas as $tarea): ?>
                <?php if ($tarea['id_usuario'] == $_SESSION['id'] || $_SESSION['admin_panel'] == 'rwd'): ?>
                    <tr class="complete">
                        <?php if (!isset($borrador)): ?>
                            <td>
                                <input class="form-check-input" type="checkbox" id="checkbox" value="option1">
                            </td>
                        <?php endif ?>
                        <th scope="row">
                            <?= esc($tarea['id']) ?>
                        </th>
                        <td>
                            <?= esc($tarea['tarea']) ?>
                        </td>
                        <td>
                            <?= esc($tarea['nombre_estado']) ?>
                        </td>
                        <?php if ($_SESSION['admin_panel'] == 'rwd'): ?>
                            <td>
                                <?= esc($tarea['username']) ?>
                            </td>
                        <?php endif ?>
                        <td>
                            <a href="<?php echo isset($borrador) ? base_url('permaDelete/' . $tarea['id_usuario'] . '/' . $tarea['id']) : base_url('delete/' . $tarea['id_usuario'] . '/' . $tarea['id']) ?>"
                                class="btn btn-danger button-to-strike" type="button">Delete</a>
                            <?php if (!isset($borrador)) { ?>
                                <a href="<?= base_url('edit/'  . $tarea['id_usuario'] . '/' . $tarea['id']) ?>" class="btn btn-info button-to-strike"
                                    type="button">Editar</a>
                            <?php } else { ?>
                                <a href="<?= base_url('recuperar/' . $tarea['id_usuario'] . '/' . $tarea['id']) ?>" class="btn btn-info button-to-strike"
                                    type="button">Recuperar</a>
                            <?php } ?>
                        </td>

                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        </tbody>
    <?php else: ?>

        <h3>No Tienes Tareas <?php echo isset($borrador) ? 'En Borrador' : '' ?></h3>

        <p>Crea tareas y empiza a planificar.</p>

    <?php endif ?>
</table>

<?= $footer ?>