<fieldset>
    <legend>informacion General</legend>

    <label for="Nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre del vendedor" value="<?php echo s( $vendedor->nombre ); ?>">

    <label for="Apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido del vendedor" value="<?php echo s( $vendedor->apellido ); ?>">

</fieldset>

<fieldset>
    <legend> Informacion Extra </legend>

    <label for="telefono"> Número de telefono: </label>
    <input type="number" id="telefono" name="vendedor[telefono]" placeholder="Numero de telefono del vendedor" value="<?php echo s( $vendedor->telefono ); ?>">

</fieldset>