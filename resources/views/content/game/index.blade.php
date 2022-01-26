@extends('layouts/contentLayoutMaster')

@section('title', 'Games')

@section('content')
<input type="hidden" id="filter" value="alphabetical">
@include('content.game.table')
@endsection
