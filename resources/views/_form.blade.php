@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Persona</label>
    <select name="id_persona" class="form-select" required>
        <option value="">-- Selecciona --</option>
        @foreach ($personas as $p)
            <option value="{{ $p->id_persona }}"
                @selected(old('id_persona', $visita->id_persona ?? '') == $p->id_persona)>
                {{ $p->nombre_completo }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Edificio</label>
    <select name="id_edificio" class="form-select" required>
        <option value="">-- Selecciona --</option>
        @foreach ($edificios as $e)
            <option value="{{ $e->id_edificio }}"
                @selected(old('id_edificio', $visita->id_edificio ?? '') == $e->id_edificio)>
                {{ $e->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Fecha y hora de entrada</label>
    <input type="datetime-local" name="fecha_hora_entrada" class="form-control" required
           value="{{ old('fecha_hora_entrada', isset($visita) ? $visita->fecha_hora_entrada?->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
</div>

<div class="mb-3">
    <label class="form-label">Fecha y hora de salida</label>
    <input type="datetime-local" name="fecha_hora_salida" class="form-control"
           value="{{ old('fecha_hora_salida', isset($visita) ? $visita->fecha_hora_salida?->format('Y-m-d\TH:i') : '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Motivo</label>
    <input type="text" name="motivo" class="form-control" maxlength="255" required
           value="{{ old('motivo', $visita->motivo ?? '') }}">
</div>

<button class="btn btn-primary">Guardar</button>
<a href="{{ route('visitas.index') }}" class="btn btn-secondary">Cancelar</a>