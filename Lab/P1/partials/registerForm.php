<main>
	<h1>GestiÓn de Usuarios </h1>
	<form class="fom_usuario" action="?action=registrar" method="POST">

		<legend>Datos básicos</legend>
		<label for="nombre">Nombre</label>
		<br/>
		<input type="text" name="userName" class="item_requerid" size="20" maxlength="25" value="<?php print $userName ?>"
		 placeholder="Miguel Cervantes" />
		<br/>
		<label for="apellidos">Apellidos</label>
		<br/>
		<input type="text" name="apellidos" class="item_requerid" size="20" maxlength="25" value="<?php print $apellidos ?>"
		 placeholder="Miguel Cervantes" />
		<br/>
		<label for="email">Email</label>
		<br/>
		<input type="text" name="email" class="item_requerid" size="20" maxlength="25" value="<?php print $email ?>"
		 placeholder="kiko@ic.es" />
		<br/>
		<label for="dni">Dni</label>
		<br/>
		<input type="text" name="dni" class="item_requerid" size="20" maxlength="25" value="<?php print $dni ?>"
		 placeholder="00000000A" />
		<br/>
		<label for="passwd">Clave</label>
		<br/>
		<input type="password" name="passwd" class="item_requerid" size="8" maxlength="25" value="<?php print $passwd ?>"
		/>
		<br/>
		<label for="foto_file">Email</label>
		<br/>
		<input type="text" name="foto_file" class="item_requerid" size="20" maxlength="25" value="<?php print $foto_file ?>"
		 placeholder="algo.jpg" />
		<br/>
		<input type="submit" value="Enviar">
		<input type="reset" value="Deshacer">
	</form>
</main>