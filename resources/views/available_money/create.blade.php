@extends('templates.index')

@section('content')
    @php
        $formName = isset($availableMoney) ? 'formEdit' : 'formCad';
        $actionUrl = isset($availableMoney) ? url('entrada/' . $availableMoney->id) : url('entrada');
        $method = isset($availableMoney) ? 'PUT' : 'POST';
        $date = \Carbon\Carbon::now();
    @endphp
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-4 mb-4">
                    <h1 class="text-center">
                        @if (isset($availableMoney))
                            Editar Receita
                        @else
                            Nova Receita
                        @endif
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form name="{{ $formName }}" id="{{ $formName }}" method="post" action="{{ $actionUrl }}">
                        <div class="row">
                            @method($method)
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <span>{{ $errors->first() }}</span>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <p class="margin-show">Nome</p>
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ $availableMoney->name ?? '' }}" placeholder="Nome" required>
                            </div>
                            <div class="col-lg-4">
                                <p class="margin-show">Selecione uma data:</p>
                                <input class="form-control" type="date" id="date" name="date"
                                    value="{{ $availableMoney->date ?? $date->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <p class="margin-show">Valor</p>
                                <input class="form-control" type="text" name="to_spend" id="to_spend"
                                    value="{{ $availableMoney->to_spend ?? '' }}" placeholder="R$ 0,00" required>
                            </div>
                            <div class="text-center p-3">
                                <input class="btn btn-primary" type="submit"
                                    value="@if (isset($availableMoney)) Editar @else Cadastrar @endif">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@endsection
