@extends('templates.index')

@section('content')
    @php
        $formName = isset($category) ? 'formEdit' : 'formCad';
        $actionUrl = isset($category) ? url('categoria/' . $category->id) : url('categoria');
        $method = isset($category) ? 'PUT' : 'POST';
    @endphp
    <section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mt-4 mb-4">
                        <h1 class="text-center">
                            @if (isset($category))
                                Editar Categoria
                            @else
                                Nova Categoria
                            @endif
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form name="{{ $formName }}" id="{{ $formName }}" method="post" action="{{ $actionUrl }}">
                            <div class="row">
                                @method($method)
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <span>{{ $errors->first() }}</span>
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <p class="margin-show">Nome da categoria</p>
                                    <input class="form-control" type="text" name="name" id="name"
                                        value="{{ $category->name ?? '' }}" placeholder="Nome da categoria" required>
                                </div>
                                <div class="text-center p-3">
                                    <input class="btn btn-primary" type="submit"
                                        value="@if (isset($category)) Editar @else Cadastrar @endif">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </section>
    @endsection
