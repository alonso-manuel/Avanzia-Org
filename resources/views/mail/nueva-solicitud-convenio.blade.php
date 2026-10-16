<x-mail::message>
# Nueva solicitud de convenio

**{{ $solicitud->institucion }}** ({{ $tipo }}, {{ $solicitud->pais }}) quiere establecer una alianza.

<x-mail::table>
| | |
|:--|:--|
| Representante | {{ $solicitud->representante }} ({{ $solicitud->cargo }}) |
| Correo | {{ $solicitud->correo }} |
| Teléfono | {{ $solicitud->telefono }} |
| Sitio web | {{ $solicitud->sitio_web ?: '—' }} |
| Interés | {{ $interes }} |
| Docentes (aprox.) | {{ $solicitud->docentes }} |
</x-mail::table>

@if ($solicitud->mensaje)
**Mensaje:**

{{ $solicitud->mensaje }}
@endif

Responde a este correo para contactar directamente al representante.
</x-mail::message>
