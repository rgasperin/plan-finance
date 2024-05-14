@extends('templates.index')

@section('content')
    @php
        $formName = isset($finance) ? 'formEdit' : 'formCad';
        $actionUrl = isset($finance) ? url('despesa/' . $finance->id) : url('despesa');
        $method = isset($finance) ? 'PUT' : 'POST';
    @endphp
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-4 mb-4">
                    <h1 class="text-center">
                        @if (isset($finance))
                            Editar
                        @else
                            Novo
                        @endif
                    </h1>
                </div>
            </div>
            <form name="!! $formName }}" id="{{ $formName }}" method="post" action="{{ $actionUrl }}">
                @method($method)
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <p class="margin-show">Nome</p>
                        <input class="form-control" type="text" name="name" id="name"
                            value="{{ $finance->name ?? '' }}" placeholder="Nome da categoria" required>
                    </div>
                    <div class="col-lg-6">
                        <p class="margin-show">Categoria</p>
                        <select class="form-select" name="categories_id" id="categories_id" required>
                            <option value="{{ $finance->relCategory->id ?? '' }}">
                                {{ $finance->relCategory->name ?? 'Selecione uma categoria' }}
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-4">
                        <p class="margin-show">Valor</p>
                        <input class="form-control" type="text" id="value" name="value" placeholder="R$ 0,00"
                            value="{{ $finance->value ?? '' }}" required>
                    </div>
                    <div class="col-lg-4">
                        <p class="margin-show">Selecione uma data:</p>
                        <input class="form-control" type="date" id="date" name="date"
                            value="{{ $finance->date ?? $date->format('Y-m-d') }}">
                    </div>
                    <div class="col-lg-4">
                        <p class="margin-show">Saldo disponível</p>
                        @foreach ($availableMoneys as $availableMoney)
                            <input name="available_money_id" id="available_money_id" value="{{ $availableMoney->id }}"
                                hidden>
                            <span class="form-control disabled">R$
                                {{ number_format($availableMoney->to_spend, 2) ?? '' }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <p class="margin-show">Descrição</p>
                        <textarea class="form-control textarea-height" id="editor" placeholder="Mensagem..." name="description" required>{{ $finance->description ?? '' }}</textarea>
                    </div>
                </div>
                <div class="text-center p-3">
                    <input class="btn btn-primary" type="submit"
                        value="@if (isset($finance)) Editar @else Cadastrar @endif">
                </div>
            </form>
    </section>
@endsection
