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
    <h2 class="alert alert-<?php echo $_SESSION['mensaje']['class'] ?>"><?= $_SESSION['mensaje']['texto'] ?></h2>
    <?php unset($_SESSION['mensaje']);
} ?>
<?php var_dump($etiquetas)?>
<form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2"
    action="<?= base_url("editEtiqueta") ?>" method="post">
    <div class="col d-flex justify-content-between">
        <div class="form-outline flex-grow-1 me-1 mx-1">
            <input type="hidden" name='id_usuario'
                value="<?php echo isset($_SESSION['username']['id_usuario']) ? $_SESSION['username']['id_usuario'] : '' ?>">
            <input type="hidden" id="id" class="form-control" name="id" value="<?php echo $etiquetas['id'] ?>"/>
            <input type="hidden" id="id_etiqueta" class="form-control" name="id_etiqueta" value="<?php echo $etiquetas['id_etiqueta'] ?>"/>
            <input type="text" id="nombre_etiqueta" class="form-control" name="nombre_etiqueta" value="<?php echo $etiquetas['nombre_etiqueta'] ?>"/>
            <label class="form-label" for="nombre_etiqueta">Introduce Etiqueta: </label>
        </div>
        <div class="col-md-auto col-auto d-flex justify-content-between">
            <label for="color_etiqueta" class="align-self-center" id="etiqueta_label">Color:</label>
            <input type="color" id="color_etiqueta" class="form-control" name="color_etiqueta" value="<?php echo $etiquetas['color_etiqueta'] ?>" />
            <p class="text-danger mb-0">
                <?php echo isset($errores['color_etiqueta']) ? $errores['color_etiqueta'] : ''; ?>
            </p>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary form-control">Guardar</button>
        </div>
    </div>
</form>
<?= $footer ?>