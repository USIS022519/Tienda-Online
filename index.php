<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1"); /* Con esto estamos asiendo consultas preparadas */
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="shortcut icon" href="./images/logo.jpeg" type="image/x-icon">
</head>

<body>

    <!-- Menu -->
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a href="#" class="navbar-brand">
                <img class="mb-2" src="./images/logo.png" alt="" width="100" height="100" class="img-circle">
                <strong>El Ingeniero</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Catalogo</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contacto</a>
                        </li>
                    </ul>
                    <a href="carrito.php" class="btn btn-warning">Carrito</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido -->
    <main class="flex-shrink-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                <?php foreach ($resultado as $row) { ?>
                    <div class="col mb-2">
                        <div class="card shadow-sm h-100">
                            <?php 
                                $id = $row['id'];
                                $imagen = "images/productos/" . $id . "/principal.jpg";

                                if(!file_exists($imagen)){
                                    $imagen = "images/no-foto.jpg";
                                }
                            ?>
                            <img src="<?php echo $imagen; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                <p class="card-text">$ <?php echo number_format($row['precio'], 2, '.', ','); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-info">Detalles</a>
                                    </div>
                                    <a href="" class="btn btn-success">Agregar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <!-- footer -->
    <footer class="pt-4 my-md-5 pt-md-5 border-top bg-primary navbar-dark">
    <div class="row">
    <h2 style="text-align: center;">Sé el primero en enterarte de las ofertas especiales <br> en nuestras redes sociales</h2>
      <div class="col-12 col-md">
        <img  class="mb-2" src="./images/logo.png" alt="" width="110" height="110">
        <small class="d-block mb-3 text-body-secondary">&copy; 2023</small>
      </div>
      <div class="col-6 col-md">
        <h5>¿Como podemos ayudarte?</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Accesorios para celulares</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Herramientas de red</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Contactanos</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Atención al cliente</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">+503 74187495</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Visita nuestras redes sociales</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Facebook</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Instagram</a></li>
        </ul>
      </div>
    </div>
  </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>