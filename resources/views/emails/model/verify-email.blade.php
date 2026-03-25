@component('mail::message')
# ¡Bienvenida al Equipo Lustonex!

Hola **{{ $user->name }}**,

Estamos encantados de que hayas decidido unirte a **Lustonex** como creadora de contenido exclusivo. Estás a un solo
paso de comenzar a monetizar tu contenido y conectar con tus fans.

Para activar tu cuenta de modelo y comenzar a configurar tu perfil, por favor verifica tu dirección de correo
electrónico haciendo clic en el siguiente botón:

@component('mail::button', ['url' => $url, 'color' => 'red'])
Verificar Email de Modelo
@endcomponent

### ¿Qué sigue después?
1. **Verificación de Identidad**: Completa tu perfil y sube tu documento de identidad.
2. **Configura tus Tarifas**: Establece el precio de tu suscripción mensual.
3. **Sube Contenido**: Comienza a subir fotos y videos exclusivos.
4. **Gana Dinero**: Recibe pagos por suscripciones, propinas y mensajes privados.

Si no creaste esta cuenta, no es necesario realizar ninguna acción.

Saludos,<br>
{{ config('app.name') }}
@endcomponent