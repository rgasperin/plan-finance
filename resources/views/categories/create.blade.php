@extends('templates.index')

@section('content')
    @php
        $formName = isset($category) ? 'formEdit' : 'formCad';
        $actionUrl = isset($category) ? url('categoria/' . $category->id) : url('categoria');
        $method = isset($category) ? 'PUT' : 'POST';
    @endphp
    <section class="p-5">
        <div class="container">
            <div class="card p-4">
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
                <form name="{{ $formName }}" id="{{ $formName }}" method="post" action="{{ $actionUrl }}">
                    <div class="row">
                        @method($method)
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <span>{{ $errors->first() }}</span>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <p class="margin-show">Nome da categoria</p>
                            <input class="form-control form-control-bg" type="text" name="name" id="name"
                                value="{{ $category->name ?? '' }}" placeholder="Nome da categoria" required>
                        </div>
                        <div class="col-md-6">
                            <p class="margin-show">Cor da categoria</p>
                            <div class="d-flex align-items-center">
                                <div id="color-picker"></div>
                                <input type="hidden" id="color" name="color" value="{{ $category->color ?? '' }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end p-3">
                            <button class="btn btn-secondary btn-view" type="submit">
                                <i class="fi fi-rr-disk d-flex"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script>
        const pickr = Pickr.create({
            el: '#color-picker',
            theme: 'classic',
            default: '{{ isset($category) ? $category->color : '#7BF57B' }}',
            swatches: [
                '#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#00FFFF', '#FF00FF',
                '#C0C0C0', '#808080', '#800000', '#808000', '#008000', '#800080',
                '#008080', '#000080', '#FFA500', '#A52A2A', '#800080', '#008000',
            ],
            components: {
                preview: true,
                opacity: true,
                hue: true,
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        });

        pickr.on('change', (color) => {
            document.getElementById('color').value = color.toHEXA().toString();
        });
    </script>
@endsection
