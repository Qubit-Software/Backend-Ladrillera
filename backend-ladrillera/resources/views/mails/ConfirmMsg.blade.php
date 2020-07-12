Hola <i>{{ $msg->userName}}</i>,
<p>Su cuenta de usuario fue creada exitosamente</p>
 
<div>
<p><b>Cuenta numero:</b>&nbsp;{{ $accountsCounter }}</p>
</div>
 
<div>
<p><b>Correo:</b>&nbsp;{{ $msg->receiver }}</p>
<p><b>Contraseña:</b>&nbsp;{{ $msg->password }}</p>
</div>
 
Gracias.
<br/>
<i>{{ $msg->sender }}</i>