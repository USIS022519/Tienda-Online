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
    <div>
        <!-- Menu -->
        <header>
            <div class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container">
                    <a href="index.php" class="navbar-brand">
                        <img class="mb-2 rounded-circle" src="./images/logo.png">
                        <strong>El Ingeniero</strong>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarHeader">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a href="index.php" class="nav-link active">Catalogo</a>
                            </li>
                            <li class="nav-item">
                                <!--      <a href="#" class="nav-link">Contacto</a> -->
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

                                if (!file_exists($imagen)) {
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

        <hr>
        <!-- Footer -->
        <footer class="blog-footer" style="text-align: center;">
            <p> <strong> Bienvenido a </strong><a href="index.php">El Ingeniero</a> <strong>by</strong> <a href="index.php">@Negocios Electrónicos</a>.</p>
            <p>
                <a href="#">Emprendimiento Estudiantil</a>
            </p>
        </footer>
        <hr>


        <!--Botones flotante-->
        <div class="sticky-container">
            <ul class="sticky">
                <li>
                    <img src="social/facebook-circle.png" width="32" height="32">
                    <p><a href="https://www.facebook.com/INGENIEROS3?mibextid=LQQJ4d" target="_blank">Síguenos en<br>Facebook</a></p>
                </li>
                <li>
                    <img src="social/instagram-circle.png" width="32" height="32">
                    <p><a href="https://www.instagram.com/ING_mdd/" target="_blank">Síguenos en<br>Instagram</a></p>
                </li>
                <li>
                    <img src="social/whatssap-circle.png" width="32" height="32">
                    <p><a href="https://api.whatsapp.com/send?phone=+50374187495&text=Hola%20,te%20asesoramos%20por%20whatsapp%20gestiona%20tu%20compra%20por%20este%20canal." target="_blank">Haz tu consulta por<br>whatssap</a></p>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>