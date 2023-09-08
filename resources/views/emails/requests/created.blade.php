<x-mail::message>
Estimado/a,

Le informamos que {{ $request_user->first_name }} {{ $request_user->last_name }} ha solicitado días por {{ $day_request->day->type }}.

Detalles de la solicitud:
- **Tipo de día:** {{ $day_request->day->type }}
- **Fecha de inicio:** {{ $day_request->formatted_start_date_complete() }}
- **Fecha de finalización:** {{ $day_request->formatted_end_date_complete() }}

<x-mail::button :url="$request_link">
    Ver solicitud
</x-mail::button>

Atentamente,<br>
El equipo de Solido Connecting Solutions.
</x-mail::message>
