@extends('visitas.layout')
@section('content')
<h1>Nueva visita</h1>
<form method="POST" action="{{ route('visitas.store') }}">
    @csrf
    @include('visitas._form')
</form>
@endsection 