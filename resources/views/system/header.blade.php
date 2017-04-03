<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  @section('head')
    <title>
      Learning Locker: an open source learning record store (LRS)
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {!! Html::style('assets/css/bootstrap.min.css')!!}
    {!! Html::style('assets/css/font-awesome.min.css')!!}

    @if(Auth::check())
      {!! Html::style('assets/css/morris.min.css')!!}
      {!! Html::style('assets/css/app.css')!!}
    @else
      {!! Html::style('assets/css/walledgarden.css')!!}
    @endif

    <!--[if lt IE 9]>
    <script src="vendors/html5shiv.js"></script>
    <![endif]-->
  @show
  
</head>
<body>