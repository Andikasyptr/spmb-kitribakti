@extends('layouts.app')
@include('components.sidebar-admin')
@section('title', 'Data Absensi Siswa')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Data Absensi Siswa</h1>
    @include('admin.absensi._table', ['absensis' => $absensis])
</div>
@endsection
