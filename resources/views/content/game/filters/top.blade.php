@extends('layouts/contentLayoutMaster')

@section('title', 'Top Games')

@section('content')
<input type="hidden" id="filter" value="top">
@include('content.game.table')
@endsection
