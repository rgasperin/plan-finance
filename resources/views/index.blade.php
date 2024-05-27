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
                                        @php
                                            $date = $carbon::parse($finance->date);
                                        @endphp
                                        <tr>
                                            <td class="padding-table">
                                                <p class="mt-3"> {{ $finance->name }}</p>
                                            </td>
                                            <td class="padding-table">
                                                <p class="mt-3"> R$ {{ number_format($finance->value, 2, '.', ',') }} </p>
                                            </td>
                                            <td class="padding-table">
                                                <p class="mt-3"> {{ $date->format('d/m/Y') }} </p>
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
            </div>
        </div>
    </section>
@endsection
