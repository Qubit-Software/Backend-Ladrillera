Hola {{ $msg->receiver }}
Su cuenta de usuario fue creada exitosamente

Cuenta numero:{{ $accountsCounter }}

Values passed by With method:
 

Correo:{{ $msg->receiver }}
Contraseña:{{ $msg->password }}
 
Gracias.
{{ $msg->sender }}