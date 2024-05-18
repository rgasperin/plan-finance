@extends('templates.index')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{ $chart->options['chart_title'] }}</h1>
                    {!! $chart->renderHtml() !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    {!! $chart->renderChartJsLibrary() !!}
    {!! $chart->renderJs() !!}
@endsection
