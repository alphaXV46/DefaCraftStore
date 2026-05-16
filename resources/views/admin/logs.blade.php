@extends('layouts.admin') {{-- Sesuaikan dengan nama layout admin kamu, misal 'layouts.app' --}}

@section('content')
<div class="container-fluid mt-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Log Aktivitas Sistem</h1>
        <p class="text-muted">Memantau setiap aksi yang dilakukan oleh Admin/User</p>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Jejak Digital Aktivitas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Waktu (WIB)</th>
                            <th>User ID</th>
                            <th>Aksi / Modul</th>
                            <th>Keterangan Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="align-middle">
                                <span class="badge badge-secondary">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i:s') }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-outline-primary">ID: {{ $log->user_id }}</span>
                            </td>
                            <td class="align-middle">
                                <span class="text-primary font-weight-bold">{{ $log->activity }}</span>
                            </td>
                            <td class="align-middle text-muted">
                                {{ $log->description }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <img src="https://illustrations.popsy.co/amber/no-results.svg" width="150" alt="No data"><br>
                                <span class="text-muted">Belum ada aktivitas yang tercatat hari ini.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection