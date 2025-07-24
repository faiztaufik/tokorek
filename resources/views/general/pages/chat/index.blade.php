@extends('general.layouts.main')

@section('container')
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="text-secondary">Live Chat</h2>
            <p>Silakan tinggalkan pesan Anda, kami akan segera membalas.</p>
        </div>

        <div class="card shadow border-0">
            <div class="card-body p-4" style="height: 450px; overflow-y: auto;" id="chat-box">

                <!-- Admin Message (LEFT) -->
                <div class="d-flex mb-4 align-items-start">
                    <div class="me-3">
                        <i class="bi bi-person-fill fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="bg-primary text-white rounded p-3">
                            <strong class="d-block mb-1 text-white-50">Admin</strong>
                            Halo, silakan sebutkan kode nota Anda.
                        </div>
                    </div>
                </div>

                <!-- Customer Message (RIGHT) -->
                <div class="d-flex mb-4 flex-row-reverse align-items-start text-end">
                    <div class="ms-3">
                        <i class="bi bi-person-circle fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="bg-light rounded p-3">
                            <strong class="d-block mb-1 text-muted">Anda</strong>
                            Halo, saya ingin bertanya soal service laptop saya.
                        </div>
                    </div>
                </div>

                <!-- Admin Message -->
                <div class="d-flex mb-4 align-items-start">
                    <div class="me-3">
                        <i class="bi bi-person-fill fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="bg-primary text-white rounded p-3">
                            <strong class="d-block mb-1 text-white-50">Admin</strong>
                            Tentu, silakan berikan informasinya.
                        </div>
                    </div>
                </div>

                <!-- Customer Message -->
                <div class="d-flex mb-4 flex-row-reverse align-items-start text-end">
                    <div class="ms-3">
                        <i class="bi bi-person-circle fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="bg-light rounded p-3">
                            <strong class="d-block mb-1 text-muted">Anda</strong>
                            Ini kodenya: RCP202507001
                        </div>
                    </div>
                </div>

            </div>

            <form class="p-3 border-top bg-light">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ketik pesan...">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-send-fill me-1"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
