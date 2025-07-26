@extends('general.layouts.main')

@section('container')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="text-primary fw-bold">Live Chat</h2>
            <p class="text-muted">Silakan tinggalkan pesan Anda. Kami akan segera merespons.</p>
        </div>

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-body p-4 bg-light" id="chat-box" style="height: 450px; overflow-y: auto;">

                @if(isset($messages) && $messages->count() > 0)
                    @foreach($messages as $message)
                        @if($message->is_admin)
                            {{-- Admin Message --}}
                            <div class="d-flex mb-4 align-items-start message-item" data-message-id="{{ $message->id }}">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 45px; height: 45px;">
                                        <i class="bi bi-person-fill fs-4"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="bg-primary text-white rounded px-3 py-2">
                                        <div class="small text-white-50 fw-semibold mb-1">{{ $message->user_name }}</div>
                                        {{ $message->message }}
                                    </div>
                                    <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        @else
                            {{-- User Message --}}
                            <div class="d-flex mb-4 flex-row-reverse align-items-start message-item" data-message-id="{{ $message->id }}">
                                <div class="ms-3">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 45px; height: 45px;">
                                        <i class="bi bi-person-circle fs-4"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="bg-white border rounded px-3 py-2">
                                        <div class="small text-muted fw-semibold mb-1">{{ $message->user_name }}</div>
                                        {{ $message->message }}
                                    </div>
                                    <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    {{-- Admin Welcome Message --}}
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
                                Halo! Selamat datang di layanan chat kami. Silakan tinggalkan pesan Anda.
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Chat Form --}}
            <form id="chat-form" class="p-3 border-top bg-white">
                @csrf
                <div class="input-group">
                    <input type="text" id="message-input" class="form-control border-0 shadow-sm rounded-start-pill"
                           placeholder="Ketik pesan..." aria-label="Pesan" required maxlength="1000">
                    <button class="btn btn-primary rounded-end-pill px-4" type="submit" id="send-btn">
                        <i class="bi bi-send-fill me-1"></i> Kirim
                    </button>
                </div>
                <small class="text-muted">Pesan akan ditampilkan sebagai "{{ 'Pengguna ' . substr($currentSessionId, -6) }}" | Session: {{ substr($currentSessionId, 0, 8) }}...</small>
                <input type="hidden" id="current-session-id" value="{{ $currentSessionId }}">
            </form>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById('chat-box');
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');
            const sendBtn = document.getElementById('send-btn');

            // Auto scroll to bottom
            function scrollToBottom() {
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            // XSS Protection - Frontend validation
            function containsXSS(message) {
                const xssPatterns = [
                    /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi,
                    /<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi,
                    /javascript:/i,
                    /vbscript:/i,
                    /on\w+\s*=/i,
                    /<object\b[^<]*(?:(?!<\/object>)<[^<]*)*<\/object>/mi,
                    /<embed\b[^<]*(?:(?!<\/embed>)<[^<]*)*<\/embed>/mi,
                    /<form\b[^<]*(?:(?!<\/form>)<[^<]*)*<\/form>/mi,
                    /expression\s*\(/i,
                    /url\s*\(/i,
                    /@import/i,
                ];

                return xssPatterns.some(pattern => pattern.test(message));
            }

            // Sanitize message for display
            function sanitizeMessage(message) {
                // Create a temporary div to safely encode HTML
                const div = document.createElement('div');
                div.textContent = message;
                return div.innerHTML;
            }

            // Add new message to chat
            function addMessage(message) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('message-item');
                messageElement.setAttribute('data-message-id', message.id);

                const currentTime = new Date(message.created_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Sanitize message content for display
                const sanitizedMessage = sanitizeMessage(message.message);
                const sanitizedUserName = sanitizeMessage(message.user_name);

                if (message.is_admin) {
                    messageElement.classList.add('d-flex', 'mb-4', 'align-items-start');
                    messageElement.innerHTML = `
                        <div class="me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 45px; height: 45px;">
                                <i class="bi bi-person-fill fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <div class="bg-primary text-white rounded px-3 py-2">
                                <div class="small text-white-50 fw-semibold mb-1">${sanitizedUserName}</div>
                                ${sanitizedMessage}
                            </div>
                            <small class="text-muted">${currentTime}</small>
                        </div>
                    `;
                } else {
                    messageElement.classList.add('d-flex', 'mb-4', 'flex-row-reverse', 'align-items-start');
                    messageElement.innerHTML = `
                        <div class="ms-3">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 45px; height: 45px;">
                                <i class="bi bi-person-circle fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white border rounded px-3 py-2">
                                <div class="small text-muted fw-semibold mb-1">${sanitizedUserName}</div>
                                ${sanitizedMessage}
                            </div>
                            <small class="text-muted">${currentTime}</small>
                        </div>
                    `;
                }

                chatBox.appendChild(messageElement);
                scrollToBottom();
            }

            // Input validation on typing
            messageInput.addEventListener('input', function() {
                const message = this.value;
                
                // Check for XSS patterns
                if (containsXSS(message)) {
                    this.setCustomValidity('Pesan mengandung konten yang tidak diizinkan.');
                    this.classList.add('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                }
            });

            // Submit form handler
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const message = messageInput.value.trim();

                if (!message) {
                    alert('Silakan ketik pesan.');
                    return;
                }

                // Frontend XSS validation
                if (containsXSS(message)) {
                    alert('Pesan mengandung konten yang tidak diizinkan. Silakan hapus script atau kode HTML.');
                    return;
                }

                // Check message length
                if (message.length > 1000) {
                    alert('Pesan terlalu panjang. Maksimal 1000 karakter.');
                    return;
                }

                // Disable send button
                sendBtn.disabled = true;
                sendBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Mengirim...';

                // Send message
                fetch('{{ route("general.live-chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                       document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add message to chat immediately
                        addMessage(data.message);
                        
                        // Clear message input
                        messageInput.value = '';
                        messageInput.classList.remove('is-invalid');
                    } else {
                        alert(data.error || 'Gagal mengirim pesan. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                })
                .finally(() => {
                    // Re-enable send button
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = '<i class="bi bi-send-fill me-1"></i> Kirim';
                });
            });

            // Listen for new messages via Laravel Echo
            if (window.Echo) {
                // Get session ID from backend-provided hidden input
                const currentSessionId = document.getElementById('current-session-id').value;
                console.log('Connecting to session:', currentSessionId);
                
                // Listen to session-specific channel
                window.Echo.channel(`chat.${currentSessionId}`)
                    .listen('MessageSent', (e) => {
                        // Check if message is not already displayed and belongs to current session
                        if (!document.querySelector(`[data-message-id="${e.id}"]`) && e.session_id === currentSessionId) {
                            addMessage(e);
                        }
                    });
            }

            // Initial scroll to bottom
            scrollToBottom();
        });
    </script>
@endsection
