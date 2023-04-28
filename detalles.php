<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    echo 'Error al procesar la petición';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {

        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
        $sql->execute([$id]);

        if ($sql->fetchColumn() > 0) {

            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $dir_images = 'images/productos/' . $id . '/';

            $rutaImg = $dir_images . 'principal.jpg';

            if (!file_exists($rutaImg)) {
                $rutaImg = 'images/no-foto.jpg';
            }

            $imagenes = array();
            if (file_exists($dir_images)) {
                $dir = dir($dir_images);

                while (($archivo = $dir->read()) != false) {
                    if ($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
                        $imagenes[] = $dir_images . $archivo;
                    }
                }
                $dir->close();
            }
        }
        /*$resultado = $sql->fetchAll(PDO::FETCH_ASSOC); */
    } else {
        echo 'Error al procesar la petición';
    }
}

/* $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1"); /* Con esto estamos asiendo consultas preparadas */
/* $sql->execute();
          $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); */

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Ingeniero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
</head>

<body>

    <!-- Menu -->
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-info">
            <div class="container">
                <a href="index.php" class="navbar-brand">
                    <img src="images/logo.png" class="mg-2 rounded-circle" alt="" width="70" height="70">
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
                            <!-- <a href="#" class="nav-link">Contacto</a> -->
                        </li>
                    </ul>
                   <!-- <a href="checkout.php" class="btn btn-success">Carrito <span id="num_cart" class="badge bg-info"><?php echo $num_cart; ?></span></a> -->
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido -->
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $rutaImg; ?>" class="d-block w-100">
                            </div>

                            <?php foreach ($imagenes as $img) { ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $img; ?>" class="d-block w-100">
                                </div>
                            <?php }  ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $nombre; ?></h2>

                    <?php if ($descuento > 0) { ?>
                        <p><del><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></del></p>
                        <h2><?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?>
                            <small class="text-success"><?php echo $descuento; ?>% descuento</small>
                        </h2>
                    <?php } else { ?>
                        <h2><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>
                    <?php } ?>

                    <p class="lead"><?php echo $descripcion; ?></p>

                    <div class="d-grid gap-3 col-10 mx-auto">
                        <a class="btn btn-outline-success" type="button" href="https://api.whatsapp.com/send?phone=+50374187495&text=Hola%20,Puedes%20realizar%20tu%20pedido%20por%20este%20medio%20electronico." target="_blank">Realizar pedido</a>
                       <!-- <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo
                        $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button> -->
                    </div>
                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


    <script>
        function addProducto(id, token) {
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let elemento = document.getElementById("num_cart");
                        elemento.innerHTML = data.numero
                    }
                })
        }
    </script>
</body>

</html>