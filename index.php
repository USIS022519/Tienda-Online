<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1"); /* Con esto estamos asiendo consultas preparadas */
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

//session_destroy();
//print_r($_SESSION);
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
    <link rel="shortcut icon" href="./images/logo.jpeg" type="image/x-icon">
</head>

<body>
    <div>
        <!-- Menu -->
        <header>
            <div class="navbar navbar-expand-lg navbar-dark bg-info">
                <div class="container">
                    <a href="index.php" class="navbar-brand">
                        <img class="mb-2 rounded-circle" src="./images/logo.png" alt="" width="70" height="70">
                        <strong>El ingeniero</strong>
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
                        <!-- <a href="checkout.php" class="btn btn-success">Carrito <span id="num_cart" class="badge bg-info"><?php echo $num_cart; ?></span></a> -->
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="flex-shrink-0">
            <div class="position-relative overflow-hidden p-3 p-md-0 m-md-0 text-center bg-body-tertiary">
                <div class="col-md-5 p-lg-12 mx-auto my-5 text-justify">
                <img src="images/logo1.png" alt="width="350" height="350 margin: -15px">
                    <h1 class="display-6 fw-normal p-lg-0">EL INGENIERO</h1>
                    <p class="lead fw-justify">"Es una tienda donde podrás encontrar diferentes artículos desde componentes electrónicos hasta accesorios para celulares como audífonos entre otros más accesorios, contamos con precios cómodos y envíos a todo el país"</p>
                </div>
                <div class="product-device shadow-sm d-none d-md-block"></div>
                <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
            </div>

            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                    <?php foreach ($resultado as $row) { ?>
                        <div class="col mb-2">
                            <div class="card shadow-sm h-100 cards bg-info">
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
                                            <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-success">Detalles</a>
                                        </div>
                                        <a class="btn btn-success" type="button" href="https://api.whatsapp.com/send?phone=+50374187495&text=Hola%20,Puedes%20realizar%20tu%20pedido%20por%20este%20medio%20electronico." target="_blank">Realizar pedido</a>
                                        <!--  <button class="btn btn-success" type="button" onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <hr>
            <!-- Footer -->
            <footer class="blog-footer" style="text-align: center;">
                <p> <strong> Bienvenido a </strong><a href="index.php">El Ingeniero</a> <strong>by</strong> <a href="index.php">@Negocios Electrónicos</a>.</p>
                <p>
                    <a href="#">Emprendimiento Estudiantil</a>
                   <?php include('visitas.php'); ?>
                </p>
            </footer>
            <hr>
        </main>
    </div>

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
                <p><a href="https://api.whatsapp.com/send?phone=+50374187495&text=Hola%20,Puedes%20realizar%20tu%20pedido%20por%20este%20medio%20electronico." target="_blank">Haz tu pedido por<br>whatssap</a></p>
            </li>
        </ul>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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