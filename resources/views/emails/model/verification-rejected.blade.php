@component('mail::message')
# Actualización sobre tu solicitud

Hola **{{ $user->name }}**,

Gracias por tu interés en unirte a **Lustonex**. Hemos revisado tu solicitud, pero lamentablemente no podemos aprobar tu
perfil en este momento.

### Motivo del rechazo:
@component('mail::panel')
{{ $reason }}
@endcomponent

No te desanimes, esto no es un "no" definitivo. Puedes corregir los problemas mencionados y volver a enviar tu
solicitud.

@component('mail::button', ['url' => route('model.onboarding.index'), 'color' => 'primary'])
Corregir y Reenviar Solicitud
@endcomponent

Si tienes dudas sobre el motivo del rechazo, puedes contactar a nuestro soporte.

Saludos,<br>
{{ config('app.name') }}
@endcomponent