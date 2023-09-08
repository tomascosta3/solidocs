<x-mail::message>
Estimado/a,

Le informamos que {{ $approver->first_name }} {{ $approver->last_name }} <strong>aprobó</strong>
tu solicitud de {{ $day_request->requested_days }} día/s por {{ $day_request->day->type }}.

El período de tiempo solicitado fue:

Desde: {{ $day_request->formatted_start_date_complete() }}<br>
Hasta: {{ $day_request->formatted_end_date_complete() }}

<x-mail::button :url="$request_link">
    Ver solicitud
</x-mail::button>

Atentamente,<br>
El equipo de Solido Connecting Solutions
</x-mail::message>
