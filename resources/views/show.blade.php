@extends('templates.index')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <a class="text-decoration-none" href="{{ url('despesa') }}">
                        <button class="btn btn-dark btn-view">
                            <i class="fi fi-rr-rectangle-xmark"></i>
                        </button>
                    </a>
                </div>
                <div class="col-lg-12 p-3">
                    <h1 class="text-center">{{ $finance->name }}</h1>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @php
                            $category = $finance->find($finance->id)->relCategory;
                            $availableMoney = $finance->find($finance->id)->relAvailableMoney;
                            $date = \Carbon\Carbon::parse($finance->date)->format('d/m/Y');
                        @endphp
                        <div class="col-lg-6">
                            <p class="margin-show">Categoria</p>
                            <input class="form-control" value="{{ $category->name }}" disabled>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <p class="margin-show">Valor</p>
                            <input class="form-control" value="R$ {{ number_format($finance->value, 2, '.', ',') ?? '' }}"
                                disabled>
                        </div>
                        <div class="col-lg-4">
                            <p class="margin-show">Selecione uma data:</p>
                            <input class="form-control" value="{{ $date }}" disabled>
                        </div>
                        <div class="col-lg-4">
                            <p class="margin-show">Saldo disponível</p>
                            <input class="form-control"
                                value="R$ {{ number_format($availableMoney->to_spend, 2, '.', ',') }}" disabled>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <p class="margin-show">Descrição</p>
                            <textarea class="form-control textarea-show" disabled>{{ $finance->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
