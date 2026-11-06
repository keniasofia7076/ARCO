@extends('visitas.layout')
@section('content')
<h1>Editar visita #{{ $visita->id_visita }}</h1>
<form method="POST" action="{{ route('visitas.update', $visita) }}">
    @csrf @method('PUT')
    @include('visitas._form')
</form>
@endsection