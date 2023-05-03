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
    <h2 class="alert alert-<?php echo $_SESSION['mensaje']['class'] ?>" id="message"><?= $_SESSION['mensaje']['texto'] ?></h2>
    <?php unset($_SESSION['mensaje']);
} ?>

<form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2"
    action="/save" method="post">
    <div class="col d-flex justify-content-between">
        <div class="form-outline flex-grow-1 me-1 mx-1">
            <input type="hidden" name='id_usuario' value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '' ?>">
            <input type="text" id="task" class="form-control" name="task" />
            <label class="form-label" for="task">Introduce nueva tarea: </label>
        </div>
        <div class="col-md-auto col-auto d-flex justify-content-between">
            <label for="id_etiqueta" class="align-self-center" id="etiqueta_label">Etiqueta:</label>
            <select class="form-control mx-1" name="id_etiqueta" <?php echo count($etiquetas) == 0 ? 'onclick="window.location = this.value"' : '' ?>>
                <?php
                if (count($etiquetas) > 0) {
                    foreach ($etiquetas as $etiqueta) {
                        if ($etiqueta['id_usuario'] === session('id')) {
                            ?>
                            <option value="<?php echo $etiqueta['id'] ?>" <?php echo ($_SESSION['id_etiqueta'] == $etiqueta['id']) ? 'selected' : ''; ?>>
                                <?php echo $etiqueta['nombre_etiqueta'] ?></option>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <option value="" selected>-</option>
                    <option value="/etiquetas">Crear etiqueta</option>
                    <?php
                }
                ?>
            </select>
            <p class="text-danger mb-0">
                <?php echo isset($errores['id']) ? $errores['id'] : ''; ?>
            </p>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary form-control">Guardar</button>
        </div>
    </div>
</form>

<?php if (count($tareas) > 0): ?>
    <?php $i = 0; ?>
    <?php foreach ($tareas as $etiqueta => $tarea): ?>
        <?php if (count($tarea) > 0) {
            $textColor = ((max(...sscanf($tarea[0]['color_etiqueta'], "#%02x%02x%02x")) + min(...sscanf($tarea[0]['color_etiqueta'], "#%02x%02x%02x"))) / 2 > 127) ? "#000000" : "#FFFFFF";
            ?>
            <div id="<?php echo 'div' . $tarea[0]['id_etiqueta'] ?>">
                <br>
                <span id="etiqueta"
                    style="background-color: <?php echo $tarea[0]['color_etiqueta']; ?>; color: <?php echo $textColor ?>">
                    <?php echo isset($etiqueta) ? $etiqueta : '' ?>
                </span>
                <br>
                <br>
                <input class="form-check-input" type="checkbox" class="checkbox" id='showAll<?php echo $tarea[0]['id_etiqueta'] ?>'
                    <?php echo (isset($_SESSION['showAll' . $tarea[0]['id_etiqueta']]) && $_SESSION['showAll' . $tarea[0]['id_etiqueta']] == 'true') ? 'checked' : '' ?> data-etiqueta='<?php echo $tarea[0]['id_etiqueta']; ?>'>
                <label for="showAll">Mostrar completadas</label>


                <table class="table mb-3" id="<?php echo 'tb' . $tarea[0]['id_etiqueta'] ?>">
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
                                    <tr class="<?php echo 'id' . $t['id'] ?>">

                                        <td>
                                            <input class="form-check-input" type="checkbox" id="checkbox" data-id="<?php echo $t['id'] ?>"
                                                data-id_etiqueta="<?php echo $t['id_etiqueta'] ?>" <?php echo ($t['id_estado'] == 2) ? 'checked' : '' ?>>

                                        </td>
                                    <?php endif ?>
                                    <th scope="row">
                                        <?= esc($t['id_tarea']) ?>
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
                                            onclick="deleteItem('<?php echo $t['id'] ?>','delete', '<?php echo $t['id_etiqueta'] ?>')">Delete</button>
                                        <a href="<?= '/'.'edit/' . $t['id'] . '/' . $t['id_etiqueta'] ?>"
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
            </div>
        <?php } ?>
        <?php $i++; endforeach ?>
<?php endif ?>

<?= $footer ?>