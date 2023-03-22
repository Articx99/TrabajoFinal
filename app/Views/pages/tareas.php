<!DOCTYPE html>
<html lang="en">

<head>
  <base href="/">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>
  <link rel="stylesheet" type="text/css" href="css/sidebar.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-default no-margin">

    <div class="navbar-header fixed-brand">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" id="menu-toggle">
        <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-rocket fa-4"></i> SEEGATESITE</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active">
          <button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"> <span
              class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button>
        </li>
      </ul>
    </div>
    <!-- navbar-header-->


    <!-- bs-example-navbar-collapse-1 -->
  </nav>
  <div id="wrapper">
    <div id="sidebar-wrapper">

      <ul class="sidebar-nav nav-pills nav-stacked" id="menu">

        <li class="active">
          <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span>
            Dashboard</a>
          <ul class="nav-pills nav-stacked" style="list-style-type:none;">
            <li><a href="#">link1</a></li>
            <li><a href="#">link2</a></li>
          </ul>
        </li>
        <li>
          <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-flag fa-stack-1x "></i></span> Shortcut</a>
          <ul class="nav-pills nav-stacked" style="list-style-type:none;">
            <li><a href="#"><span class="fa-stack fa-lg pull-left"><i
                    class="fa fa-flag fa-stack-1x "></i></span>link1</a></li>
            <li><a href="#"><span class="fa-stack fa-lg pull-left"><i
                    class="fa fa-flag fa-stack-1x "></i></span>link2</a></li>

          </ul>
        </li>
        <li>
          <a href="#"><span class="fa-stack fa-lg pull-left"><i
                class="fa fa-cloud-download fa-stack-1x "></i></span>Overview</a>
        </li>
        <li>
          <a href="#"> <span class="fa-stack fa-lg pull-left"><i
                class="fa fa-cart-plus fa-stack-1x "></i></span>Events</a>
        </li>
        <li>
          <a href="#"><span class="fa-stack fa-lg pull-left"><i
                class="fa fa-youtube-play fa-stack-1x "></i></span>About</a>
        </li>
        <li>
          <a href="#"><span class="fa-stack fa-lg pull-left"><i
                class="fa fa-wrench fa-stack-1x "></i></span>Services</a>
        </li>
        <li>
          <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-server fa-stack-1x "></i></span>Contact</a>
        </li>
      </ul>
    </div>
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
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
                            <th scope="row">
                              <?= esc($tarea['id']) ?>
                            </th>
                            <td>
                              <?= esc($tarea['tarea']) ?>
                            </td>
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
      </div>
    </div>

  </div>
  <em>&copy; 2023</em>
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

  </script>
</body>

</html>