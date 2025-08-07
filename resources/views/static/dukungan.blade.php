@extends('layouts.app')

@section('meta_title', 'Dukungan & Donasi | BarangGratis.com')
@section('meta_description', 'Bantu BarangGratis.com tetap online & gratis. Donasi kamu mendukung operasional, pengembangan, dan edukasi komunitas.')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0" style="background:#23272b; color:#fff;">
                <div class="card-body p-4">
                    <h2 class="mb-3 text-center text-warning">Dukungan & Donasi</h2>
                    <p class="lead text-center mb-4">
                        BarangGratis.com adalah gerakan berbagi barang tak terpakai secara gratis.<br>
                        Dukung kami agar platform ini tetap online, gratis, dan berkembang!
                    </p>
                    <div class="mb-4">
                        <h5 class="text-light">Mengapa Donasi Diperlukan?</h5>
                        <ul>
                            <li>Menjaga website tetap online dan gratis untuk semua</li>
                            <li>Mendukung pengembangan fitur & keamanan</li>
                            <li>Memperluas edukasi dan promosi komunitas</li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h5 class="text-light">Total Kebutuhan Dana: <span class="text-warning">Rp13.500.000 / tahun</span></h5>
                        <p>
                            Dana digunakan untuk server, pengembangan website, promosi komunitas, operasional, dan cadangan tak terduga.<br>
                            Setiap donasi, sekecil apapun, sangat berarti!
                        </p>
                    </div>
                    <div class="text-center my-4">
                        <a href="https://sociabuzz.com/baranggratis/tribe" target="_blank" class="btn btn-success btn-lg shadow rounded-pill px-5">
                            Donasi via Sociabuzz
                        </a>
                    </div>
                    <hr class="bg-secondary">
                    <div class="text-center text-light small mt-4">
                        Ingin bertanya atau ingin jadi relawan? Hubungi kami:<br>
                        <span style="user-select:none;">kontak@baranggratis.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

