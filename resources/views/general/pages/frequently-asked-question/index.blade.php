@extends('general.layouts.main')

@section('container')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-gradient">💬 Pertanyaan Umum (FAQ)</h2>
            <p class="text-muted">Kami siap menjawab pertanyaan umum Anda mengenai layanan kami.</p>
        </div>

        <div class="row g-4">
            @foreach ([
                ['Apa itu layanan perbaikan laptop?', 'Kami menyediakan layanan pengecekan, perbaikan hardware, dan instalasi software untuk semua jenis laptop.'],
                ['Berapa lama proses perbaikan?', 'Waktu perbaikan rata-rata 2 hingga 5 hari kerja tergantung tingkat kerusakan.'],
                ['Apakah saya bisa mengecek status perbaikan?', 'Tentu, cukup masukkan kode nota Anda pada halaman pelacakan layanan.'],
                ['Apakah ada garansi?', 'Kami memberikan garansi hingga 30 hari untuk perbaikan tertentu.']
            ] as $faq)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 faq-card">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="bi bi-patch-question-fill me-2 fs-4"></i> {{ $faq[0] }}
                            </h5>
                            <p class="card-text text-muted mt-2">{{ $faq[1] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .text-gradient {
            background: linear-gradient(135deg, #007bff, #6610f2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .faq-card {
            transition: all 0.3s ease-in-out;
        }

        .faq-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
    </style>
@endsection
