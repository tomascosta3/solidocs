<x-mail::message>
# ¡No te olvides tu próximo/a {{ $event->event_type->name }}!

El evento <strong>{{ $event->title }}</strong> está programado para comenzar el {{ $event->start }}.

<x-mail::button :url="$calendars_link">
Más información del evento.
</x-mail::button>


{{ config('app.name') }}
</x-mail::message>
