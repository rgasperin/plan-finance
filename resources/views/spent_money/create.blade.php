@extends('templates.index')

@section('content')
    @php
        $formName = isset($finance) ? 'formEdit' : 'formCad';
        $actionUrl = isset($finance) ? url('despesa/' . $finance->id) : url('despesa');
        $method = isset($finance) ? 'PUT' : 'POST';
    @endphp
    <section class="p-5">
        <div class="container">
            <div class="card p-4">
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
                <form name="{{ $formName }}" id="{{ $formName }}" method="post" action="{{ $actionUrl }}">
                    @method($method)
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="margin-show">Nome</p>
                            <input class="form-control form-control-bg" type="text" name="name" id="name"
                                value="{{ $finance->name ?? '' }}" placeholder="Nome da categoria" required>
                        </div>
                        <div class="col-lg-5">
                            <p class="margin-show">Categoria</p>
                            <select class="form-select form-control-bg" name="categories_id" id="categories_id" required>
                                <option value="{{ $finance->relCategory->id ?? '' }}">
                                    {{ $finance->relCategory->name ?? 'Selecione uma categoria' }}
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <p class="margin-show">A pagar</p>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-4">
                            <p class="margin-show">Valor</p>
                            <input class="form-control form-control-bg" type="text" id="value" name="value"
                                placeholder="R$ 0,00" value="{{ $finance->value ?? '' }}" required>
                        </div>
                        <div class="col-lg-4">
                            <p class="margin-show">Selecione uma data:</p>
                            <input class="form-control form-control-bg" type="date" id="date" name="date"
                                value="{{ $finance->date ?? $date->format('Y-m-d') }}">
                        </div>
                        <div class="col-lg-4">
                            <p class="margin-show">Saldo disponível</p>
                            @foreach ($availableMoneys as $availableMoney)
                                <input name="available_money_id" value="{{ $availableMoney->id }}" hidden>
                            @endforeach
                            <span class="form-control form-control-bg">R$ {{ number_format($diff, 2) ?? '' }}</span>
                        </div>

                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <p class="margin-show">Descrição</p>
                            <textarea class="form-control textarea-height" id="editor" placeholder="Mensagem..." name="description" required>
                                    {!! $finance->description ?? '' !!}
                                </textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end p-3">
                        <button class="btn btn-secondary btn-view" type="submit">
                            <i class="fi fi-rr-disk d-flex"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
