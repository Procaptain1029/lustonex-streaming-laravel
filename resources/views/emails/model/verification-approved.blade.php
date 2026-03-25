@component('mail::message')
# ¡Felicidades! Tu perfil ha sido aprobado

Hola **{{ $user->name }}**,

Nos complace informarte que tu solicitud para ser modelo en **Lustonex** ha sido aprobada.

¡Ya eres parte oficial de nuestro equipo de creadores!

### ¿Qué puedes hacer ahora?
1. **Personalizar tu perfil**: Asegúrate de que tu biografía y fotos te representen.
2. **Subir contenido**: Comienza a compartir fotos y videos exclusivos.
3. **Establecer tus tarifas**: Configura el precio de tu suscripción mensual.
4. **Interactuar con fans**: Responde mensajes y comentarios.

@component('mail::button', ['url' => route('model.dashboard'), 'color' => 'success'])
Ir a mi Panel de Modelo
@endcomponent

Estamos emocionados de ver tu contenido y ayudarte a crecer.

Saludos,<br>
{{ config('app.name') }}
@endcomponent