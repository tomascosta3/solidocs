<x-mail::message>
@if ($last_name !== null && $first_name !== null)
Querido {{ $first_name }} {{ $last_name }},
@else
Estimado,
@endif

¡Bienvenido al sistema Solido Connecting Solutions! Para completar el proceso de 
registro y asegurarnos de que tu cuenta sea válida, necesitamos verificar tu dirección 
de correo electrónico.

Por favor, haz clic en el siguiente botón para verificar tu correo electrónico.

<x-mail::button :url="$verification_link">
Verificar correo
</x-mail::button>

Si el botón no funciona, también puedes copiar y pegar la siguiente URL en tu navegador:

{{ $verification_link }}

Te recomendamos completar la verificación lo antes posible para poder acceder a todas las 
funciones y características del sistema.

Si no has solicitado esta verificación, por favor, ignora este correo electrónico. Es posible 
que alguien haya ingresado tu dirección de correo electrónico por error.

Si tienes alguna pregunta o necesitas ayuda, no dudes en ponerte en contacto con nuestro equipo 
de soporte. Estaremos encantados de asistirte.

Saludos cordiales,

{{ config('app.name') }}
</x-mail::message>
