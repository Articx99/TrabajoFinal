<!-- login.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Iniciar sesión</title>
    <!-- Importar los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #fff;
        }

        .card {
            background-color: #222;
            color: #fff;
            border-radius: 0;
        }

        .card-header {
            background-color: #000;
            border-bottom: none;
        }

        .form-control {
            background-color: #fff;
            color: #222;
            border: none;
            border-radius: 0;
        }

        .form-control:focus {
            background-color: #fff;
            color: #222;
            border-color: #ffc107;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #ffc107;
            border: none;
            border-radius: 0;
        }

        .btn-primary:hover {
            background-color: #ff9800;
            border: none;
            border-radius: 0;
        }
    </style>
</head>

<body>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-4">
                <div class="card">

                    <div class="card-header text-center">
                        <p class="h1" style="border-bottom: 2px solid #ff9800">TaskLists</p>
                        <h4 class="m-0">Iniciar sesión</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session('error')): ?>
                            <div class="alert alert-danger">
                                <?= session('error') ?>
                            </div>
                        <?php endif ?>

                        <form action="/login" method="post">
                            <div class="form-group">
                                <label for="username">Nombre de usuario:</label>
                                <input type="text" name="username" class="form-control" value="<?= old('username') ?>">
                                <small class="text-small text-danger">
                                    <?php echo isset($error['username']) ? $error['username'] : "" ?>
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="pass">Contraseña:</label>
                                <input type="password" name="pass" class="form-control">
                                <small class="text-small text-danger">
                                    <?php echo isset($error['pass']) ? $error['pass'] : "" ?>
                                </small>
                            </div>
                            <a href="/register"><small>No tienes cuenta? Regístrate.</small></a>
                            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Importar los scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>