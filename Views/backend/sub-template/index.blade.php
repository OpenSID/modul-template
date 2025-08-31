@extends('admin.layouts.index')

@section('title')
    <h1>
        Sub Template
    </h1>
@endsection

@section('breadcrumb')
    <li class="active">Sub Template</li>
@endsection

@section('content')
    @include('admin.layouts.components.notifikasi')

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Halaman Sub Template</h3>
        </div>
        <div class="box-body">
            <p>Ini adalah halaman sub template. Anda dapat menyesuaikan konten di sini sesuai kebutuhan Anda.</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {});
    </script>
@endpush
