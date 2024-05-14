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
                    <table class="table table-bg table-hover">
                        <thead class="table-dark-bg">
                            <tr>
                                <th class="padding-card">Nome</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th class="d-flex justify-content-end padding-card">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($finances->isEmpty())
                                <table>
                                    <p class="text-center">Nenhum resultado encontrado!</p>
                                </table>
                            @else
                                @foreach ($finances as $finance)
                                    @php
                                        $category = $finance->find($finance->id)->relCategory;
                                        $availableMoney = $finance->find($finance->id)->relAvailableMoney;
                                        $date = $carbon::parse($finance->date)->format('d/m/Y');
                                    @endphp
                                    <tr>
                                        <td>{{ $finance->name }}</td>
                                        <td>
                                            <i class="fi fi-ss-circle me-1" style="color:{{ $category->color }}"></i>
                                            {{ $category->name ?? 'Sem Categoria' }}
                                        </td>
                                        <td>R$ {{ number_format($finance->value, 2, '.', ',') }}</td>
                                        <td>{{ $date }}</td>
                                        <td class="d-flex justify-content-end">
                                            <a class="text-decoration-none" href="{{ url('despesa/' . $finance->id) }}">
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
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
