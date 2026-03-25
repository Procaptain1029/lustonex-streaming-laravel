@component('mail::message')

# ¡Solicitud Recibida!

Hola **{{ $user->name }}**,

Hemos recibido tu solicitud para convertirte en modelo en **Lustonex**.

Tu perfil está actualmente **bajo revisión**. Nuestro equipo verificación revisará tus documentos y datos personales
para asegurar que todo esté en orden.

Este proceso suele tomar entre **24 y 48 horas**.

Una vez que tu solicitud haya sido revisada, recibirás otro correo electrónico con el resultado.

Si tienes alguna pregunta, no dudes en contactarnos.

Saludos,<br>
{{ config('app.name') }}
@endcomponent