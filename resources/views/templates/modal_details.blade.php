<div class="row">
    <div class="col-lg-6">
        <p class="margin-show">Nome</p>
        <input class="form-control" value="{{ $finance->name }}" disabled>
    </div>
    <div class="col-lg-6">
        <p class="margin-show">Categoria</p>
        <input class="form-control" value="{{ $category->name }}" disabled>
    </div>
</div>
<div class="row mt-3">
    <div class="col-lg-4">
        <p class="margin-show">Valor</p>
        <input class="form-control" value="R$ {{ number_format($finance->value, 2, ',', '.') ?? '' }}" disabled>
    </div>
    <div class="col-lg-4">
        <p class="margin-show">Selecione uma data:</p>
        <input class="form-control" value="{{ $date }}" disabled>
    </div>
    <div class="col-lg-4">
        <p class="margin-show">Saldo disponível</p>
        <input class="form-control" value="R$ {{ number_format($diff, 2, ',', '.') }}" disabled>
    </div>
</div>
<div class="row mt-3">
    <div class="col-lg-12">
        <p class="margin-show">Descrição</p>
        <div class="form-control textarea-bg disable">{!! $finance->description !!}</div>
    </div>
</div>
