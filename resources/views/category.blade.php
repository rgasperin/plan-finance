@extends('templates.index')

@section('content')
    <section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mt-4 mb-4">
                        <h1 class="text-center">Lista de Categorias</h1>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a class="text-decoration-none" href="{{ url('categoria/create') }}">
                            <button class="btn btn-primary btn-icon">
                                Criar categoria
                            </button>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table mt-5">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">ID</th>
                                    <th scope="col" class="text-center">Nome da Categoria</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category as $categories)
                                    <tr>
                                        <th class="text-center">#{{ $categories->id }}</th>
                                        <td class="text-center">{{ $categories->name }}</td>
                                        <td class="d-flex justify-content-center text-center">
                                            <a class="text-decoration-none"
                                                href="{{ url('categoria/' . $categories->id) . '/edit' }}">
                                                <button class="btn btn-primary btn-view">
                                                    <i class="fi fi-rr-file-edit btn-icon"></i>
                                                </button>
                                            </a>

                                            <form id="deleteForm" method="POST"
                                                action="{{ url('categoria/' . $categories->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class=" ms-2 btn btn-danger btn-view" type="submit">
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
        </section>
    @endsection
