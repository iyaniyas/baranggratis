@extends('layouts.app')

@section('meta_title', 'Syarat & Ketentuan')

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const user = "kontak";
    const domain = "baranggratis.com";
    const email = user + "@" + domain;
    const emailEl = document.getElementById("email");
    if (emailEl) {
      emailEl.textContent = email;
    }
  });
</script>
@endpush

@section('content')
<div class="container py-4">
  <h1>Syarat &amp; Ketentuan</h1>
  <p>Halaman ini mengatur penggunaan layanan BarangGratis oleh pengguna. Dengan mengakses situs ini, Anda menyetujui seluruh ketentuan yang tercantum di bawah ini.</p>

  <h2>1. Ketentuan Umum</h2>
  <ol>
    <li>Anda setuju untuk menggunakan layanan ini sesuai hukum yang berlaku di Republik Indonesia.</li>
    <li>Jika Anda tidak menyetujui syarat ini, mohon untuk tidak menggunakan layanan kami.</li>
    <li>Kami berhak untuk mengubah Ketentuan ini sewaktu‑waktu. Perubahan akan berlaku sejak diumumkan.</li>
  </ol>

  <h2>2. Usia Pengguna</h2>
  <p>Anda harus berusia minimal 18 (delapan belas) tahun atau telah menikah. Jika belum, penggunaan layanan harus mendapatkan persetujuan dan pengawasan wali atau orang tua.</p>

  <h2>3. Akun & Keamanan</h2>
  <ol>
    <li>Anda bertanggung jawab menjaga keamanan akun dan informasi login Anda.</li>
    <li>Kami dapat menonaktifkan akun jika mendeteksi pelanggaran terhadap Ketentuan ini.</li>
  </ol>

  <h2>4. Penggunaan Layanan</h2>
  <ul>
    <li>BarangGratis didesain sebagai platform berbagi dan meminta barang/layanan secaragratif—tanpa jual-beli, barter, atau imbalan finansial.</li>
    <li>Setiap posting harus dibuat dengan itikad baik dan tidak menyalahi hukum.</li>
    <li>Dilarang melakukan spam, penipuan, intimidasi, atau manipulasi.</li>
  </ul>

  <h2>5. Hak Kekayaan Intelektual</h2>
  <p>Semua konten di situs—termasuk teks, gambar, logo, dan desain—merupakan milik BarangGratis atau pihak terkait. Anda tidak diperkenankan menyalin, mendistribusi ulang, atau memodifikasi tanpa izin tertulis.</p>

  <h2>6. Penafian & Batasan Tanggung Jawab</h2>
  <p>Situs dan kontennya disediakan "sebagaimana adanya" tanpa jaminan apapun, baik tersurat maupun tersirat. Kami tidak bertanggung jawab atas kerugian yang timbul dari penggunaan layanan ini.</p>

  <h2>7. Perubahan Layanan</h2>
  <p>Kami berhak mengubah, menunda, membatasi, atau bahkan menghentikan sebagian atau keseluruhan layanan kapan saja, tanpa pemberitahuan terlebih dahulu.</p>

  <h2>8. Hukum yang Berlaku</h2>
  <p>Setiap perselisihan yang timbul sehubungan dengan layanan ini akan diselesaikan berdasarkan hukum Republik Indonesia.</p>

  <h2>9. Perubahan Ketentuan</h2>
  <p>Kami dapat memperbarui Ketentuan ini sewaktu-waktu. Versi terbaru akan berlaku sejak dipublikasikan di situs.</p>

  <h2>10. Hubungi Kami</h2>
  <p>Jika Anda memiliki pertanyaan mengenai Syarat &amp; Ketentuan ini, silakan hubungi kami melalui alamat email resmi <span id="email" class="email">[email protected]</span>.</p>
</div>
@endsection

