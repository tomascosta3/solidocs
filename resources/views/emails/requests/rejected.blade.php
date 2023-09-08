<x-mail::message>
Estimado/a,

Le informamos que {{ $rejecter->first_name }} {{ $rejecter->last_name }} <strong>rechazó</strong>
tu solicitud de {{ $day_request->requested_days }} día/s por {{ $day_request->day->type }}.

El período de tiempo solicitado fue:

Desde: {{ $day_request->formatted_start_date_complete() }}<br>
Hasta: {{ $day_request->formatted_end_date_complete() }}

Para ver más información o consultar la razón del rechazo, podes acceder a la
solicitud presionando el siguiente botón:

<x-mail::button :url="$request_link">
    Ver solicitud
</x-mail::button>

Atentamente,<br>
El equipo de Solido Connecting Solutions
</x-mail::message>