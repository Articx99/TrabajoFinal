<?= $header ?>
<style>
    th {
        width: auto;
    }

    td {
        text-align: left;
    }

    #etiqueta_label {
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
</style>


<?php if (isset($_SESSION['mensaje'])) { ?>
    <h2 class="text-<?php echo $_SESSION['mensaje']['class'] ?>"><?= $_SESSION['mensaje']['texto'] ?></h2>
    <?php unset($_SESSION['mensaje']);
} ?>
<?php if (!isset($borrador)): ?>
    <form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2"
        action="<?= site_url("/saveEtiqueta") ?>" method="post">
        <div class="col d-flex justify-content-between">
            <div class="form-outline flex-grow-1 me-1 mx-1">
                <input type="hidden" name='id_usuario'
                    value="<?php echo isset($_SESSION['username']['id_usuario']) ? $_SESSION['username']['id_usuario'] : '' ?>">
                <input type="text" id="nombre_etiqueta" class="form-control" name="nombre_etiqueta" />
                <label class="form-label" for="nombre_etiqueta">Introduce Etiqueta: </label>
            </div>
            <div class="col-md-auto col-auto d-flex justify-content-between">
                <label for="color_etiqueta" class="align-self-center" id="etiqueta_label">Color:</label>
                <input type="color" id="color_etiqueta" class="form-control" name="color_etiqueta" />
                <p class="text-danger mb-0">
                    <?php echo isset($errores['color_etiqueta']) ? $errores['color_etiqueta'] : ''; ?>
                </p>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary form-control">Guardar</button>
            </div>
        </div>
    </form>
<?php endif ?>

<table class="table mb-4">
    <thead>
        <tr>
            <th scope="col" style="width: auto;">id_etiqueta</th>
            <th scope="col" style="width: auto;">Nombre</th>
            <th scope="col" style="width: auto;">Username</th>
            <th scope="col" style="width: auto;">Color</th>
            <th scope="col" style="width: auto;">Acciones</th>

        </tr>
    </thead>
    <tbody>
        <?php if (!empty($etiquetas) && is_array($etiquetas)): ?>


            <?php foreach ($etiquetas as $etiqueta): ?>
                <?php if ($etiqueta['id_usuario'] == $_SESSION['id'] || $_SESSION['admin_panel'] == 'rwd'): ?>
                    <tr class="<?php echo $etiqueta['username'] . $etiqueta['id_etiqueta'] ?>">

                        <th scope="row">
                            <?= esc($etiqueta['id_etiqueta']) ?>
                        </th>
                        <td>
                            <?= esc($etiqueta['nombre_etiqueta']) ?>
                        </td>
                        <td>
                            <?= esc($etiqueta['username']) ?>
                        </td>
                        <td>
                            <span style="background-color: <?= esc($etiqueta['color_etiqueta']) ?>;color: transparent; "
                                class="rounded-circle"></span>
                        </td>
                        <td>
                            <button class="btn btn-danger button-to-strike"
                                onclick="deleteEtiqueta('<?php echo $etiqueta['id_etiqueta'] ?>', '<?php echo $etiqueta['id_usuario'] ?>', 'permaDelete')">Delete</button>

                            <a href="<?= base_url('edit/' . $etiqueta['id_etiqueta']) ?>" class="btn btn-info button-to-strike"
                                type="button">Editar</a>

                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        </tbody>
    <?php else: ?>
        <h3>No Tienes etiquetas </h3>
        <p>Crea etiquetas y empiza a planificar.</p>

    <?php endif ?>
</table>

<?= $footer ?>