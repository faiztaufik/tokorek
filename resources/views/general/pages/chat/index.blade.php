@extends('general.layouts.main')

@section('container')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="text-primary fw-bold">Live Chat</h2>
            <p class="text-muted">Silakan tinggalkan pesan Anda. Kami akan segera merespons.</p>
        </div>

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-body p-4 bg-light" id="chat-box" style="height: 450px; overflow-y: auto;">

                {{-- Admin Message --}}
                <div class="d-flex mb-4 align-items-start">
                    <div class="me-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 45px; height: 45px;">
                            <i class="bi bi-person-fill fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <div class="bg-primary text-white rounded px-3 py-2">
                            <div class="small text-white-50 fw-semibold mb-1">Admin</div>
                            Halo, silakan sebutkan kode nota Anda.
                        </div>
                    </div>
                </div>

                {{-- User Message --}}
                <div class="d-flex mb-4 flex-row-reverse align-items-start">
                    <div class="ms-3">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 45px; height: 45px;">
                            <i class="bi bi-person-circle fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <div class="bg-white border rounded px-3 py-2">
                            <div class="small text-muted fw-semibold mb-1">Anda</div>
                            Halo, saya ingin bertanya soal service laptop saya.
                        </div>
                    </div>
                </div>

                {{-- Admin Message --}}
                <div class="d-flex mb-4 align-items-start">
                    <div class="me-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 45px; height: 45px;">
                            <i class="bi bi-person-fill fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <div class="bg-primary text-white rounded px-3 py-2">
                            <div class="small text-white-50 fw-semibold mb-1">Admin</div>
                            Tentu, silakan berikan informasinya.
                        </div>
                    </div>
                </div>

                {{-- User Message --}}
                <div class="d-flex mb-4 flex-row-reverse align-items-start">
                    <div class="ms-3">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 45px; height: 45px;">
                            <i class="bi bi-person-circle fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <div class="bg-white border rounded px-3 py-2">
                            <div class="small text-muted fw-semibold mb-1">Anda</div>
                            Ini kodenya: <strong>RCP202507001</strong>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Chat Form --}}
            <form class="p-3 border-top bg-white">
                <div class="input-group">
                    <input type="text" class="form-control border-0 shadow-sm rounded-start-pill"
                           placeholder="Ketik pesan..." aria-label="Pesan">
                    <button class="btn btn-primary rounded-end-pill px-4" type="submit">
                        <i class="bi bi-send-fill me-1"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
