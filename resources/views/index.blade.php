@extends('templates.index')

@section('content')
    <section class="p-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card p-0">
                        <div class="m-2">
                            <h1 class="text-center">Despesas</h1>
                        </div>
                        <table class="table table-bg ">
                            <thead class="table-dark-bg">
                                <tr>
                                    <th class="padding-card">Nome</th>
                                    <th class="padding-card">Valor</th>
                                    <th class="padding-card">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($finances->isEmpty())
                                    <table>
                                        <p class="text-center">Nenhum resultaho encontrado!</p>
                                    </table>
                                @else
                                    @foreach ($finances as $finance)
                                        <tr>
                                            <td class="padding-table">
                                                <p class="mt-3"> {{ $finance->name }}</p>
                                            </td>
                                            <td class="padding-table">
                                                <p class="mt-3"> R$ {{ number_format($finance->value, 2, ',', '.') }} </p>
                                            </td>
                                            <td class="padding-table">
                                                <p class="mt-3"> {{ $finance->formatted_date }} </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $finances->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card p-0">
                        <div class="m-2">
                            <h1 class="text-center">Entradas</h1>
                        </div>
                        <table class="table table-bg ">
                            <thead class="table-dark-bg">
                                <tr>
                                    <th class="padding-card">Nome</th>
                                    <th class="padding-card">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($available_moneys->isEmpty())
                                    <table>
                                        <p class="text-center">Nenhum resultaho encontrado!</p>
                                    </table>
                                @else
                                    @foreach ($available_moneys as $available_money)
                                        <tr>
                                            <td class="padding-table">
                                                <p class="mt-3"> {{ $available_money->name }}</p>
                                            </td>
                                            <td class="padding-table">
                                                <p class="mt-3"> R$
                                                    {{ number_format($available_money->to_spend, 2, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $available_moneys->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
