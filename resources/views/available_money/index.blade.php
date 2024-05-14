@extends('templates.index')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-4 mb-4">
                    <h1 class="text-center">Receitas</h1>
                </div>
                <div class="d-flex justify-content-end">
                    <form class="ms-3 d-flex align-items-center" action="{{ url('entrada/search') }}" method="post">
                        @csrf
                        <input class="form-control" type="search" name="search" placeholder="Pesquisar...">
                        <button class="btn-off ms-2" type="submit">
                            <i class="fi fi-rr-search icon-style-search btn-icon-bg"></i>
                        </button>
                    </form>
                    <a class="ms-2 text-decoration-none" href="{{ url('entrada/create') }}">
                        <i class="fi fi-rr-plus-small icon-style btn-icon-bg"></i>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bg mt-3">
                        <thead class="table-dark-bg">
                            <tr>
                                <th class="padding-card">Nome</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th class="d-flex justify-content-end padding-card">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($availableMoneys->isEmpty())
                                <table>
                                    <p class="text-center">Nenhum resultado encontrado!</p>
                                </table>
                            @else
                                @foreach ($availableMoneys as $availableMoney)
                                    @php
                                        $date = $carbon::parse($availableMoney->date)->format('d/m/Y');
                                    @endphp
                                    <tr>
                                        <td class="padding-table">
                                            <p class="mt-3">{{ $availableMoney->name ?? 'Sem nome' }}</p>
                                        </td>
                                        <td class="padding-table">
                                            <p class="mt-3">
                                                R$ {{ number_format($availableMoney->to_spend, 2, '.') }}
                                            </p>
                                        </td>
                                        <td class="padding-table">
                                            <p class="mt-3">{{ $date }}</p>
                                        </td>

                                        <td class="d-flex justify-content-end padding-table">
                                            <p class="mt-3">
                                                <a class="text-decoration-none"
                                                    href="{{ url('entrada/' . $availableMoney->id) . '/edit' }}">
                                                    <button class="btn btn-primary btn-view">
                                                        <i class="fi fi-rr-file-edit btn-icon"></i>
                                                    </button>
                                                </a>
                                            </p>
                                            <form class="mt-3" id="deleteForm" method="POST"
                                                action="{{ url('entrada/' . $availableMoney->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class=" ms-2 btn btn-danger btn-view" type="submit">
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
    </section>
@endsection
