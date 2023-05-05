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

<table class="table mb-4" >
    <thead>
        <tr>
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
                    <tr class="id<?php echo $tarea['id']?>">
                        <th scope="row">
                            <?= esc($tarea['id_tarea']) ?>
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
                            <button class="btn btn-danger button-to-strike" onclick="deleteItem('<?php echo $tarea['id']?>', 'permaDelete')">Delete</button> 
                                <a href="/<?php echo 'recover/' . $tarea['id'] ?>" class="btn btn-info button-to-strike"
                                    type="button">Recuperar</a>
                            
                        </td>

                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        </tbody>
    <?php else: ?>

        <h3>No Tienes Tareas En Borrador</h3>

        <p>Crea tareas y empiza a planificar.</p>

    <?php endif ?>
</table>

<?= $footer ?>