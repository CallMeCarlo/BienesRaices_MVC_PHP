<div class="contenedor-anuncios descripcion-botones"> 
    <?php foreach($propiedades as $propiedad) { ?>
        <div class="anuncio">
            <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio" class="prop-vista-previa"> 
            <div class="contenido-anuncio">
                <?php 
                    $resumenTitulo = substr($propiedad->titulo, 0, 15);
                ?>
                <h3><?php echo $resumenTitulo . "..."; ?> </h3>
                <?php
                    // Generamos un resumen de la descripción para no sobrecargar el contenedor del anuncio  
                    $resumenDescripcion = substr($propiedad->descripcion, 0, 35);
                ?>
                <p class="descripcion"><?php echo $resumenDescripcion . "  ..."; ?></p>
                <p class="precio"> <?php echo number_format($propiedad->precio); ?> </p>
                <ul class="iconos-caracteristicas">
                    <li> 
                        <img class="icono" src="build/img/icono_wc.svg" alt="icono baño">
                        <p> <?php echo $propiedad->wc; ?> </p>
                    </li>
                    <li> 
                        <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono cuarto">
                        <p> <?php echo $propiedad->habitaciones; ?> </p>
                    </li>
                    <li> 
                        <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono cochera">
                        <p> <?php echo $propiedad->estacionamiento; ?> </p>
                    </li>
                </ul>
                <a class="boton boton-amarillo" href="propiedad?id=<?php echo $propiedad->id; ?>"> Ver Propiedad </a>
            </div> <!-- .contenido-anuncio -->
        </div>  <!-- anuncio -->
    <?php } ?>
</div>