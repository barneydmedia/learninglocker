@extends('layouts.master')

@section('head')
  @parent
  <script>
    window.lrs = {
      key: '{{ $client->api['basic_key']}}',
      secret: '{{ $client->api['basic_secret'] }}'
    };
  </script>
  {!! Html::style('assets/css/exports.css')!!}
  {!! Html::style('assets/css/typeahead.css')!!}
@stop

@section('sidebar')
  @include('partials.lrs.sidebars.lrs')
@stop

@section('content')

  <div class="page-header">
    <h1>{{ Lang::get('exporting.title') }}</h1>
  </div>

  <div id="content"></div>

  <script data-main="/assets/js/exports/config" src="/assets/js/libs/require/require.js"></script>
@stop
