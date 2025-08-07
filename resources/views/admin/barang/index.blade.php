@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Dashboard Admin – Daftar Barang</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
    <table class="table table-dark table-bordered align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Lokasi</th>
                <th>WA</th>
                <th>Tanggal</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $barang->judul }}</td>
                <td>{{ $barang->lokasi->nama ?? '-' }}</td>
                <td>{{ $barang->no_wa }}</td>
                <td>{{ $barang->created_at->format('d-m-Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.barang.edit', ['id' => $barang->id, 'token' => request('token')]) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
                <td>
                    <form action="{{ route('admin.barang.destroy', ['id' => $barang->id, 'token' => request('token')]) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    {{ $barangs->withQueryString()->links() }}
</div>
@endsection

