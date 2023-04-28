<?php

$nombreArchivo = "ContadorDeVisitas.txt";
//reguntando si existe el archivo
if (!file_exists($nombreArchivo)) {
    touch($nombreArchivo);
}

$contenido = trim(file_get_contents($nombreArchivo)); //Obtengo la cantidadde vistas y elimino espacios en blanco

if ($contenido == "") { //Valido, si esta vacio igualamos a cero las visitas.
    $visitas = 0;
} else { //De lo contrario empiezo a sumar visitas en nuestro txt
    $visitas = intval($contenido);
}

# Ya sea que las visitas son 0 o las que hayamos leído, las aumentamos
$visitas++; //Incrementamos las visitas cada vez que entre un usuario a la web

file_put_contents($nombreArchivo, $visitas); //Escribirmos las visitas

echo '<h3 style="color:crimson;text-align:center; font-size:20px">
        <strong>'. $visitas.' Visitas</strong>
      </h3>';
 //Mostrando eltotal de visitas
?>