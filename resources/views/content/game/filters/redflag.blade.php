@extends('layouts/contentLayoutMaster')

@section('title', 'Redflag Games')

@section('content')
<input type="hidden" id="filter" value="redflag">
@include('content.game.table')
@endsection
