@extends('layouts/contentLayoutMaster')

@section('title', 'Rugpull Games')

@section('content')
<input type="hidden" id="filter" value="rugpull">
@include('content.game.table')
@endsection
