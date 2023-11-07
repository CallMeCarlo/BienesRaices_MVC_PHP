<fieldset>
                <legend>informacion General</legend>

                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo s($propiedad->titulo); ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo s($propiedad->precio); ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
                <?php if($propiedad->imagen): ?>
                    <img src="/imagenes/<?php echo "$propiedad->imagen" ?>" class="imagen-small"
                <?php endif; ?>

                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" value="<?php echo s($descripcion); ?>"> <?php echo s($propiedad->descripcion); ?> </textarea>
            </fieldset>

            <fieldset>
                <legend> Informacion de la propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej. 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

                <label for="wc">Baños</label>
                <input type="number" id="wc" name="wc" placeholder="Ej. 1" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej. 2" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">


            </fieldset>

            <fieldset>
    <legend> Vendedor </legend>
    <label for="vendedor"> Vendedor </label>
    <select name="vendedores_id" id="vendedor">
        <option selected value="">--Seleccione--</option>
        <?php foreach($vendedores as $vendedor) { ?>
            <option 
            <?php echo $propiedad->vendedores_id === $vendedor->id ? "selected" : ""; ?>
            value="<?php echo s($vendedor->id); ?>">
            <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?></option>

        <?php } ?>
    </select>
</fieldset>