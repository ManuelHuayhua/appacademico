
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container mt-5">
    <h3>Verificar Certificado</h3>
    <form method="POST" action="{{ route('certificados.buscar') }}">
        @csrf
        <div class="form-group">
            <label for="codigo">Código del Certificado:</label>
            <input type="text" name="codigo" id="codigo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Ver Certificado</button>
    </form>
</div>

