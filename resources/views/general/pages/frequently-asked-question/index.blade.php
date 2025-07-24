@extends('general.layouts.main')

@section('container')
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="text-secondary">Frequently Asked Questions (FAQ)</h2>
            <p>Pertanyaan yang sering diajukan oleh pelanggan kami.</p>
        </div>

        <div class="accordion" id="faqAccordion">
            @foreach ([['Apa itu layanan perbaikan laptop?', 'Layanan kami mencakup pengecekan, perbaikan perangkat keras, dan instalasi software.'], ['Berapa lama proses perbaikan?', 'Biasanya memakan waktu 2-5 hari kerja tergantung tingkat kerusakan.'], ['Apakah saya bisa mengecek status perbaikan?', 'Ya, Anda bisa mengecek status perbaikan menggunakan kode nota.'], ['Apakah ada garansi?', 'Kami memberikan garansi 30 hari untuk perbaikan tertentu.']] as $index => [$question, $answer])
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $index }}">
                            {{ $question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}"
                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                        aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {{ $answer }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
