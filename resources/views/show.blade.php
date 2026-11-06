@extends('visitas.layout')
@section('content')
<h1>Visita #{{ $visita->id_visita }}</h1>
<dl class="row">
    <dt class="col-sm-3">Persona</dt><dd class="col-sm-9">{{ $visita->persona->nombre_completo }}</dd>
    <dt class="col-sm-3">Edificio</dt><dd class="col-sm-9">{{ $visita->edificio->nombre }}</dd>
    <dt class="col-sm-3">Entrada</dt><dd class="col-sm-9">{{ $visita->fecha_hora_entrada?->format('d/m/Y H:i') }}</dd>
    <dt class="col-sm-3">Salida</dt><dd class="col-sm-9">{{ $visita->fecha_hora_salida?->format('d/m/Y H:i') ?? 'Aún dentro' }}</dd>
    <dt class="col-sm-3">Motivo</dt><dd class="col-sm-9">{{ $visita->motivo }}</dd>
</dl>
<a href="{{ route('visitas.index') }}" class="btn btn-secondary">Volver</a>
@endsection