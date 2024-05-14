@extends('templates.index')

@section('content')
    <section>
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-12">
                    <h1 class="text-center">Despesas</h1>
                </div>
                <div class="col-lg-12 d-flex justify-content-center mt-3">
                    <p class="text-center">Orçamento mensal: R$ {{ number_format($diff, 2, '.', ',') }}</p>
                </div>
                <div class="d-flex justify-content-end">
                    <form class="ms-3 d-flex align-items-center" action="{{ url('despesa/search') }}" method="post">
                        @csrf
                        <input class="form-control" type="search" name="search" placeholder="Pesquisar...">
                        <button class="btn-off ms-2" type="submit">
                            <i class="fi fi-rr-search icon-style-search btn-icon-bg"></i>
                        </button>
                    </form>
                    <a class="ms-2 text-decoration-none" href="{{ url('despesa/create') }}">
                        <i class="fi fi-rr-plus-small icon-style btn-icon-bg"></i>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-3">
                    <div class="card p-0">
                        <table class="table table-bg table-hover">
                            <thead class="table-dark-bg">
                                <tr>
                                    <th class="padding-card">Nome</th>
                                    <th class="padding-card">Categoria</th>
                                    <th class="padding-card">Valor</th>
                                    <th class="padding-card">Data</th>
                                    <th class="padding-card text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($finances->isEmpty())
                                    <table>
                                        <p class="text-center">Nenhum resultaho encontrado!</p>
                                    </table>
                                @else
                                    @foreach ($finances as $finance)
                                        @php
                                            $category = $finance->find($finance->id)->relCategory;
                                            $availableMoney = $finance->find($finance->id)->relAvailableMoney;
                                            $date = $carbon::parse($finance->date)->format('d/m/Y');
                                        @endphp
                                        <tr>
                                            <td class="padding-table">
                                                <p class="mt-3"> {{ $finance->name }}</p>
                                            </td>
                                            <td class="padding-table">
                                                <div class="d-flex align-items-center">
                                                    <i class="fi fi-ss-circle" style="color:{{ $category->color }}"></i>
                                                    <p class="ms-2 mt-3"> {{ $category->name ?? 'Sem Categoria' }} </p>
                                                </div>
                                            </td>
                                            <td class="padding-table">
                                                <p class="mt-3"> R$ {{ number_format($finance->value, 2, '.', ',') }} </p>
                                            </td>
                                            <td class="padding-table">
                                                <p class="mt-3"> {{ $date }} </p>
                                            </td>
                                            <td class="padding-table">
                                                <div class="mt-3 d-flex justify-content-end">
                                                    <a class="text-decoration-none"
                                                        href="{{ url('despesa/' . $finance->id) }}">
                                                        <button class="btn btn-dark btn-view">
                                                            <i class="fi fi-rr-eye btn-icon"></i>
                                                        </button>
                                                    </a>

                                                    <a class="ms-2 text-decoration-none"
                                                        href="{{ url('despesa/' . $finance->id) . '/edit' }}">
                                                        <button class="btn btn-primary btn-view">
                                                            <i class="fi fi-rr-file-edit btn-icon"></i>
                                                        </button>
                                                    </a>
                                                    <form id="deleteForm" method="POST"
                                                        action="{{ url('despesa/' . $finance->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="ms-2 btn btn-danger btn-view" type="submit">
                                                            <i class="fi fi-rr-trash btn-icon"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
