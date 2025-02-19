@extends('templates.index')

@section('content')
    <section>
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-6">
                    <div class="d-flex justify-content-center">
                        <h1 class="text-center">Receitas</h1>
                    </div>
                </div>
                <div class="col-lg-6">
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
            </div>
            <div class="row">
                <div class="col-lg-12 mt-3">
                    <div class="card p-0">
                        <table class="table table-bg">
                            <thead class="table-dark-bg">
                                <tr>
                                    <th class="padding-card">Nome</th>
                                    <th class="padding-card">Valor</th>
                                    <th class="padding-card">Data</th>
                                    <th class="padding-card text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($availableMoneys->isEmpty())
                                    <table>
                                        <p class="text-center">Nenhum resultado encontrado!</p>
                                    </table>
                                @else
                                    @foreach ($availableMoneys as $availableMoney)
                                        <tr>
                                            <td class="padding-table">
                                                <p class="mt-3">{{ $availableMoney->name ?? 'Sem nome' }}</p>
                                            </td>
                                            <td class="padding-table">
                                                <p class="mt-3">
                                                    R$ {{ number_format($availableMoney->to_spend, 2, ',', '.') }}
                                                </p>
                                            </td>
                                            <td class="padding-table">
                                                <p class="mt-3">{{ $availableMoney->formatted_date }}</p>
                                            </td>

                                            <td class="padding-table">
                                                <div class="mt-3 d-flex justify-content-end ">
                                                    <a class="text-decoration-none"
                                                        href="{{ url('entrada/' . $availableMoney->id) . '/edit' }}">
                                                        <button class="btn btn-secondary btn-view">
                                                            <i class="fi fi-rr-file-edit btn-icon"></i>
                                                        </button>
                                                    </a>
                                                    <button class="ms-2 btn btn-danger btn-view" type="button"
                                                        data-toggle="modal" data-target="#confirmDeleteModal"
                                                        id="delete-button-{{ $availableMoney->id }}">
                                                        <i class="fi fi-rr-trash btn-icon"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if ($availableMoneys->hasPages())
                            <div class="d-flex justify-content-center">
                                {{ $availableMoneys->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmação de exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja deletar este item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $(".btn-danger").click(function() {
                var buttonId = $(this).attr('id');
                var itemId = buttonId.split('-').pop();

                if (itemId) {
                    $("#deleteForm").attr('action', '/entrada/' + itemId);
                    $("#confirmDeleteModal").modal('show');
                } else {
                    console.error('ID do item não encontrado.');
                }
            });
        });
    </script>
@endsection
