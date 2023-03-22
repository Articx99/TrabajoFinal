<?=$header?> 
<h4 class="text-center my-3 pb-3">To Do App</h4>
<?php if(isset($mensaje)){ ?>
  <h2 class="text-<?php echo $mensaje['class']?>"><?= $mensaje['texto']?></h2>
<?php }?>


<form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2" action="<?=site_url("/save")?>" method="post">
  <div class="col d-flex justify-content-between">
    <div class="form-outline flex-grow-1 me-1 mx-1">
      <input type="text" id="task" class="form-control" name="task"/>
      <label class="form-label" for="task">Introduce nueva tarea: </label>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary form-control">Guardar</button>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-warning form-control">Ver tarea</button>
    </div>
  </div>
</form>
<table class="table mb-4">
  <thead>
    <tr>
      <th scope="col">No.</th>
      <th scope="col">Todo item</th>
      <th scope="col">Status</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($tareas) && is_array($tareas)): ?>

      <?php foreach ($tareas as $tarea): ?>
        <tr>
          <th scope="row">
            <?= esc($tarea['id']) ?>
          </th>
          <td>
            <?= esc($tarea['tarea']) ?>
          </td>
          <td>In progress</td>
          <td>
            <div class="row flex-row">
              <a href="<?=base_url('delete/'.$tarea['id'])?>" class="btn btn-danger">Delete</a>
              <a href="<?=base_url('view/'.$tarea['id'])?>" class="btn btn-success ms-1">Finished</a>
            </div>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  <?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

  <?php endif ?>
</table>
<?=$footer?> 