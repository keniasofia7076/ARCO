@extends('visitas.layout')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Visitas</h1>
    <a href="{{ route('visitas.create') }}" class="btn btn-primary align-self-center">Nueva visita</a>
</div>

<table class="table table-striped">
    <thead>
        <tr><th>#</th><th>Persona</th><th>Edificio</th><th>Entrada</th><th>Salida</th><th>Motivo</th><th></th></tr>
    </thead>
    <tbody>
    @forelse ($visitas as $v)
        <tr>
            <td>{{ $v->id_visita }}</td>
            <td>{{ $v->persona->nombre_completo }}</td>
            <td>{{ $v->edificio->nombre }}</td>
            <td>{{ $v->fecha_hora_entrada?->format('d/m/Y H:i') }}</td>
            <td>
                @if ($v->fecha_hora_salida)
                    {{ $v->fecha_hora_salida->format('d/m/Y H:i') }}
                @else
                    <form method="POST" action="{{ route('visitas.salida', $v) }}" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-success">Registrar salida</button>
                    </form>
                @endif
            </td>
            <td>{{ $v->motivo }}</td>
            <td class="text-nowrap">
                <a href="{{ route('visitas.show', $v) }}" class="btn btn-sm btn-info">Ver</a>
                <a href="{{ route('visitas.edit', $v) }}" class="btn btn-sm btn-warning">Editar</a>
                <form method="POST" action="{{ route('visitas.destroy', $v) }}" class="d-inline"
                      onsubmit="return confirm('¿Eliminar esta visita?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center">Sin visitas registradas.</td></tr>
    @endforelse
    </tbody>
</table>

{{ $visitas->links() }}
@endsection