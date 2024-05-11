@extends('templates.index')

@section('content')
    <section>
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-12">
                    <h1 class="text-center">Despesas</h1>
                </div>
            </div>
            <div class="row mt-2 mb-2">
                <div class="col-lg-12 d-flex justify-content-center mt-3">
                    <p class="text-center">Orçamento mensal: R$ </p>
                    {{-- @foreach ($availableMoney as $availableMoneys)
                        <span class="text-center" id="valor">
                            {{ number_format($availableMoneys->total_value, 2) ?? '' }}
                        </span>
                    @endforeach --}}
                    <span>{{ number_format($diff, 2, '.', ',') }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <a class="text-decoration-none" href="{{ url('despesa/create') }}">
                        <button class="btn btn-secondary btn-icon">
                            Cadastrar
                        </button>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Data</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($finance as $finances)
                                @php
                                    $category = $finances->find($finances->id)->relCategory;
                                    $availableMoney = $finances->find($finances->id)->relAvailableMoney;
                                    $date = \Carbon\Carbon::parse($finances->date)->format('d/m/Y');
                                @endphp
                                <tr>
                                    <th>#{{ $finances->id }}</th>
                                    <td>{{ $finances->name }}</td>
                                    <td><i class="fi fi-rr-star"></i> {{ $category->name }}</td>
                                    <td>R$ {{ number_format($finances->value, 2, '.', ',') }}</td>
                                    <td>{{ $date }}</td>
                                    <td class="d-flex justify-content-end">
                                        <a class="text-decoration-none" href="{{ url('despesa/' . $finances->id) }}">
                                            <button class="btn btn-dark btn-view">
                                                <i class="fi fi-rr-eye btn-icon"></i>
                                            </button>
                                        </a>

                                        <a class="ms-2 text-decoration-none"
                                            href="{{ url('despesa/' . $finances->id) . '/edit' }}">
                                            <button class="btn btn-primary btn-view">
                                                <i class="fi fi-rr-file-edit btn-icon"></i>
                                            </button>
                                        </a>

                                        <form id="deleteForm" method="POST" action="{{ url('despesa/' . $finances->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="ms-2 btn btn-danger btn-view" type="submit">
                                                <i class="fi fi-rr-trash btn-icon"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
