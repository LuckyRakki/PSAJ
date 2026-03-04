@extends('layouts.admin') {{-- Sesuaikan dengan layout admin kamu --}}

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kelola Customer</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Customer</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $index => $cus)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $cus->name }}</div>
                            </td>
                            <td>{{ $cus->email }}</td>
                            <td>{{ $cus->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.chat', $cus->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-comments"></i> Chat
                                </a>
                                
                                <form action="{{ route('admin.customers.destroy', $cus->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus akun customer ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada customer yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection