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

    #etiqueta {
        margin-top: auto;
        background-color: #F9A825;
        color: white;
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-right: 10px;

    }

    #etiqueta_label {
        margin-bottom: 33px;
        margin-right: 5px;
        font-size: 20px;
        font-family: Arial, helvetica, sans-serif;
        color: black;
    }

    #tabla {
        margin-top: 2px;
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
            <div class="col-md-auto col-auto d-flex justify-content-between">
                <label for="id_etiqueta" class="align-self-center" id="etiqueta_label">Etiqueta:</label>
                <select class="form-control mx-1" name="id_etiqueta">
                    <?php
                    if (count($etiquetas) > 0) {
                        foreach ($etiquetas as $etiqueta) {
                            ?>
                            <option value="<?php echo $etiqueta['id_etiqueta'] ?>" <?php echo (0 == $etiqueta['id_etiqueta']) ? 'selected' : ''; ?>><?php echo $etiqueta['nombre_etiqueta'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <p class="text-danger mb-0">
                    <?php echo isset($errores['id_etiqueta']) ? $errores['id_etiqueta'] : ''; ?>
                </p>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary form-control">Guardar</button>
            </div>
        </div>
    </form>
<?php endif ?>
<?php if (count($tareas) > 0): ?>
    <?php foreach ($tareas as $etiqueta => $tarea): ?>
        <?php if (count($tarea) > 0) { ?>
            <br>
            <span id="etiqueta" style="background-color: <?php echo $tarea[0]['color_etiqueta']; ?>">
                <?php echo isset($etiqueta) ? $etiqueta : '' ?>
            </span>
            <br>
            <br>
            <input class="form-check-input" type="checkbox" class="checkbox" id='showAll<?php echo $tarea[0]['id_etiqueta'] ?>' <?php echo (isset($_SESSION['showAll' . $tarea[0]['id_etiqueta']]) && $_SESSION['showAll' . $tarea[0]['id_etiqueta']] == 'true') ? 'checked' : '' ?>>
            <label for="showAll">Mostrar completadas</label>



            <table class="table mb-3" id="tabla">
                <thead>
                    <tr>

                        <th scope="col" id="TableStart" style="width: 100px;">Hecho</th>

                        <th scope="col" style="width: auto;">No.</th>
                        <th scope="col" style="width: auto;">Para Hacer</th>
                        <th scope="col" style="width: auto;">Estado</th>
                        <th scope="col" style="width: auto;">Etiqueta</th>
                        <?php if ($_SESSION['admin_panel'] == 'rwd'): ?>
                            <th scope="col" style="width: auto;">Usuario</th>
                        <?php endif ?>
                        <th scope="col" style="width: auto;">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tarea) && is_array($tarea)): ?>

                        <?php foreach ($tarea as $t): ?>
                            <?php if ($t['id_usuario'] == $_SESSION['id'] || $_SESSION['admin_panel'] == 'rwd'): ?>
                                <tr class="<?php echo $t['username'] . $t['id'] ?>">

                                    <td>
                                    <input class="form-check-input" type="checkbox" id="checkbox" data-username="<?php echo $t['username'] ?>" data-id="<?php echo $t['id'] ?>" data-id_usuario="<?php echo $t['id_usuario'] ?>" <?php echo ($t['id_estado'] == 2) ? 'checked' : '' ?>>
                                    </td>
                                <?php endif ?>
                                <th scope="row">
                                    <?= esc($t['id']) ?>
                                </th>
                                <td>
                                    <?= esc($t['tarea']) ?>
                                </td>
                                <td>
                                    <?= esc($t['nombre_estado']) ?>
                                </td>
                                <td>
                                    <?= esc($t['nombre_etiqueta']) ?>
                                </td>
                                <?php if ($_SESSION['admin_panel'] == 'rwd'): ?>
                                    <td>
                                        <?= esc($t['username']) ?>
                                    </td>
                                <?php endif ?>
                                <td>
                                    <button class="btn btn-danger button-to-strike"
                                        onclick="deleteTarea('<?php echo $t['id'] ?>', '<?php echo $t['id_usuario'] ?>', '<?php echo $t['username'] ?>', '<?php echo isset($borrador) ? 'permaDelete' : 'delete' ?>')">Delete</button>

                                    <a href="<?= base_url('edit/' . $t['id_usuario'] . '/' . $t['id']) ?>"
                                        class="btn btn-info button-to-strike" type="button">Editar</a>

                                </td>

                            </tr>

                        <?php endforeach ?>
                    </tbody>
                <?php else: ?>

                    <h3>No Tienes Tareas

                    </h3>

                    <p>Crea tareas y empiza a planificar.</p>

                <?php endif ?>
            </table>
        <?php } ?>
    <?php endforeach ?>
<?php endif ?>

<?= $footer ?>