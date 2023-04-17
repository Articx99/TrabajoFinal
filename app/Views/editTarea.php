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

<form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2"
    action="<?= site_url("/edit") ?>" method="post">
    <div class="col d-flex justify-content-between">
        <div class="form-outline flex-grow-1 me-1 mx-1">
            <input type="hidden" name='id' value="<?php echo $tareas['id'] ?>">
            <input type="hidden" name='id_usuario' value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '' ?>">
            <input type="text" id="task" class="form-control" name="task" value="<?php echo $tareas['tarea'] ?>" />
            <label class="form-label" for="task">Editar tarea: </label>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary form-control">Guardar cambios</button>
        </div>
    </div>
</form>


<?= $footer ?>