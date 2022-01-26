@extends('layouts/contentLayoutMaster')

@section('title', 'Recent Games')

@section('content')
<input type="hidden" id="filter" value="recent">
@include('content.game.table')
@endsection
