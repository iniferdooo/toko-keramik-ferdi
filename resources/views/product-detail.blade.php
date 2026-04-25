@extends('layouts.main')

@section('content')
    @livewire('product-detail', ['id' => $id])
@endsection