<section class="vh-100" style="background-color: #eee;">
  <div class="container-fluid py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-9 col-xl-7">
        <div class="card rounded-3">
          <div class="card-body p-4">

            <h4 class="text-center my-3 pb-3">To Do App</h4>
            
            <form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                <div class="col d-flex justify-content-between">
                  <div class="form-outline flex-grow-1 me-1 mx-1">
                    <input type="text" id="form1" class="form-control" />
                    <label class="form-label" for="form1">Enter a task here</label>
                  </div>
                  <div class="col-auto">
                    <button type="submit" class="btn btn-primary form-control">Save</button>
                  </div>
                  <div class="col-auto">
                    <button type="submit" class="btn btn-warning form-control">Get tasks</button>
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
                        <th scope="row"><?= esc($tarea['id']) ?></th>
                        <td><?= esc($tarea['tarea']) ?></td>
                        <td>In progress</td>
                        <td>
                            <div class="row flex-row">
                              <button type="submit" class="btn btn-danger">Delete</button>
                              <button type="submit" class="btn btn-success ms-1">Finished</button>
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

          </div>
        </div>
      </div>
    </div>
  </div>
</section>