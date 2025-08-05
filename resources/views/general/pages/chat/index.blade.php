@extends('general.layouts.main')

@section('container')
    <style>
        .drag-over {
            border: 2px dashed #007bff !important;
            background-color: rgba(0, 123, 255, 0.1) !important;
        }

        .file-message img {
            transition: transform 0.2s ease;
        }

        .file-message img:hover {
            transform: scale(1.05);
        }

        #file-preview {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #chat-box {
            background-image: url('/img/bg_livecht2.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            height: 450px;
            overflow-y: auto;
        }

        #chat-box::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6);
            z-index: 0;
        }

        #chat-box > * {
            position: relative;
            z-index: 1;
        }
    </style>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="text-primary fw-bold">Live Chat</h2>
            <p class="text-muted">Silakan tinggalkan pesan Anda. Kami akan segera merespons.</p>
        </div>

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-body p-4" id="chat-box">

                @if (isset($messages) && $messages->count() > 0)
                    @foreach ($messages as $message)
                        @if ($message->is_admin)
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

                                        @if ($message->file_path)
                                            <div class="file-message mb-2">
                                                @if ($message->file_type && str_starts_with($message->file_type, 'image/'))
                                                    <img src="{{ asset('storage/' . $message->file_path) }}"
                                                        class="img-fluid rounded"
                                                        style="max-width: 250px; max-height: 200px; cursor: pointer;"
                                                        onclick="window.open('{{ asset('storage/' . $message->file_path) }}', '_blank')">
                                                @else
                                                    <a href="{{ asset('storage/' . $message->file_path) }}"
                                                        class="text-decoration-none d-flex align-items-center p-2 border rounded bg-primary-subtle"
                                                        target="_blank">
                                                        <i class="bi 
                                                            @if ($message->file_type === 'application/pdf') bi-file-earmark-pdf
                                                            @elseif($message->file_type && str_contains($message->file_type, 'word')) bi-file-earmark-word
                                                            @elseif($message->file_type === 'text/plain') bi-file-earmark-text
                                                            @elseif($message->file_type && (str_contains($message->file_type, 'zip') || str_contains($message->file_type, 'rar'))) bi-file-earmark-zip
                                                            @else bi-file-earmark @endif me-2"></i>
                                                        <div>
                                                            <div class="fw-semibold">{{ $message->file_name }}</div>
                                                            @if ($message->file_size)
                                                                <div class="small text-muted">
                                                                    {{ $message->getFormattedFileSize() }}</div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif

                                        @if ($message->message)
                                            <div>{{ $message->message }}</div>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        @else
                            {{-- User Message --}}
                            <div class="d-flex mb-4 flex-row-reverse align-items-start message-item"
                                data-message-id="{{ $message->id }}">
                                <div class="ms-3">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-person-circle fs-4"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="bg-white border rounded px-3 py-2">
                                        <div class="small text-muted fw-semibold mb-1">{{ $message->user_name }}</div>

                                        @if ($message->file_path)
                                            <div class="file-message mb-2">
                                                @if ($message->file_type && str_starts_with($message->file_type, 'image/'))
                                                    <img src="{{ asset('storage/' . $message->file_path) }}"
                                                        class="img-fluid rounded"
                                                        style="max-width: 250px; max-height: 200px; cursor: pointer;"
                                                        onclick="window.open('{{ asset('storage/' . $message->file_path) }}', '_blank')">
                                                @else
                                                    <a href="{{ asset('storage/' . $message->file_path) }}"
                                                        class="text-decoration-none d-flex align-items-center p-2 border rounded bg-secondary-subtle"
                                                        target="_blank">
                                                        <i class="bi 
                                                            @if ($message->file_type === 'application/pdf') bi-file-earmark-pdf
                                                            @elseif($message->file_type && str_contains($message->file_type, 'word')) bi-file-earmark-word
                                                            @elseif($message->file_type === 'text/plain') bi-file-earmark-text
                                                            @elseif($message->file_type && (str_contains($message->file_type, 'zip') || str_contains($message->file_type, 'rar'))) bi-file-earmark-zip
                                                            @else bi-file-earmark @endif me-2"></i>
                                                        <div>
                                                            <div class="fw-semibold">{{ $message->file_name }}</div>
                                                            @if ($message->file_size)
                                                                <div class="small text-muted">
                                                                    {{ $message->getFormattedFileSize() }}</div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif

                                        @if ($message->message)
                                            <div>{{ $message->message }}</div>
                                        @endif
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
            <form id="chat-form" class="p-3 border-top bg-white" enctype="multipart/form-data">
                @csrf

                <!-- File Preview Area -->
                <div id="file-preview" class="mb-3" style="display: none;">
                    <div class="border rounded p-3 bg-light">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark me-2 text-primary"></i>
                                <div>
                                    <div id="file-name" class="fw-semibold"></div>
                                    <div id="file-size" class="small text-muted"></div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger" id="remove-file">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <img id="image-preview" class="mt-2 img-thumbnail" style="max-height: 200px; display: none;" />
                    </div>
                </div>

                <div class="input-group">
                    <input type="file" id="file-input" name="file" class="d-none"
                        accept="image/*,.pdf,.doc,.docx,.txt,.zip,.rar">
                    <button type="button" class="btn btn-outline-secondary" id="file-btn" title="Upload File">
                        <i class="bi bi-paperclip"></i>
                    </button>
                    <input type="text" id="message-input" name="message" class="form-control border-0 shadow-sm"
                        placeholder="Ketik pesan atau upload file..." aria-label="Pesan" maxlength="1000" autocomplete="off" required>
                    <button class="btn btn-primary rounded-end-pill px-4" type="submit" id="send-btn">
                        <i class="bi bi-send-fill me-1"></i> Kirim
                    </button>
                </div>
                <small class="text-muted">Pesan akan terhapus dalam 24 jam</small>
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
            const fileInput = document.getElementById('file-input');
            const fileBtn = document.getElementById('file-btn');
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const imagePreview = document.getElementById('image-preview');
            const removeFileBtn = document.getElementById('remove-file');

            let currentFile = null;

            // File input click handler
            fileBtn.addEventListener('click', function() {
                fileInput.click();
            });

            // File selection handler
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    if (validateFile(file)) {
                        currentFile = file;
                        showFilePreview(file);
                    } else {
                        this.value = '';
                    }
                }
            });

            // Remove file handler
            removeFileBtn.addEventListener('click', function() {
                removeFile();
            });

            // Validate file
            function validateFile(file) {
                const maxSize = 10 * 1024 * 1024; // 10MB
                const allowedTypes = [
                    'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                    'application/pdf', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'text/plain', 'application/zip', 'application/x-rar-compressed'
                ];

                if (file.size > maxSize) {
                    alert('File terlalu besar. Maksimal 10MB.');
                    return false;
                }

                if (!allowedTypes.includes(file.type)) {
                    alert('Tipe file tidak didukung. Gunakan gambar, PDF, DOC, TXT, ZIP, atau RAR.');
                    return false;
                }

                return true;
            }

            // Show file preview
            function showFilePreview(file) {
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);

                // Show image preview for images
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        // Change icon to image icon
                        const icon = filePreview.querySelector('.bi-file-earmark');
                        if (icon) {
                            icon.className = 'bi bi-image me-2 text-primary';
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    // Set appropriate icon based on file type
                    let iconClass = 'bi-file-earmark';
                    if (file.type === 'application/pdf') iconClass = 'bi-file-earmark-pdf';
                    else if (file.type.includes('word')) iconClass = 'bi-file-earmark-word';
                    else if (file.type === 'text/plain') iconClass = 'bi-file-earmark-text';
                    else if (file.type.includes('zip') || file.type.includes('rar')) iconClass =
                        'bi-file-earmark-zip';

                    const icon = filePreview.querySelector('.bi');
                    if (icon) {
                        icon.className = 'bi ' + iconClass + ' me-2 text-primary';
                    }
                }

                filePreview.style.display = 'block';
                messageInput.placeholder = 'Tambahkan keterangan file (opsional)...';
                messageInput.removeAttribute('required');
            }

            // Remove file
            function removeFile() {
                currentFile = null;
                fileInput.value = '';
                filePreview.style.display = 'none';
                imagePreview.style.display = 'none';
                messageInput.placeholder = 'Ketik pesan atau upload file...';
                messageInput.setAttribute('required', 'required');
            }

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Drag and drop handlers
            chatBox.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('drag-over');
            });

            chatBox.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('drag-over');
            });

            chatBox.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('drag-over');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const file = files[0];
                    if (validateFile(file)) {
                        currentFile = file;
                        // Create a new FileList with the dropped file
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        fileInput.files = dt.files;
                        showFilePreview(file);
                    }
                }
            });

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
                const sanitizedMessage = message.message ? sanitizeMessage(message.message) : '';
                const sanitizedUserName = sanitizeMessage(message.user_name);

                // Create file content if exists
                let fileContent = '';
                if (message.file_path) {
                    const fileUrl = '{{ asset('storage') }}/' + message.file_path;
                    const isImage = message.file_type && message.file_type.startsWith('image/');

                    if (isImage) {
                        fileContent = `
                            <div class="file-message mb-2">
                                <img src="${fileUrl}" class="img-fluid rounded" style="max-width: 250px; max-height: 200px; cursor: pointer;" onclick="window.open('${fileUrl}', '_blank')">
                            </div>
                        `;
                    } else {
                        let fileIcon = 'bi-file-earmark';
                        if (message.file_type === 'application/pdf') fileIcon = 'bi-file-earmark-pdf';
                        else if (message.file_type && message.file_type.includes('word')) fileIcon =
                            'bi-file-earmark-word';
                        else if (message.file_type === 'text/plain') fileIcon = 'bi-file-earmark-text';
                        else if (message.file_type && (message.file_type.includes('zip') || message.file_type
                                .includes('rar'))) fileIcon = 'bi-file-earmark-zip';

                        fileContent = `
                            <div class="file-message mb-2">
                                <a href="${fileUrl}" class="text-decoration-none d-flex align-items-center p-2 border rounded ${message.is_admin ? 'bg-primary-subtle' : 'bg-secondary-subtle'}" target="_blank">
                                    <i class="bi ${fileIcon} me-2"></i>
                                    <div>
                                        <div class="fw-semibold">${message.file_name}</div>
                                        <div class="small text-muted">${message.file_size ? formatFileSize(message.file_size) : ''}</div>
                                    </div>
                                </a>
                            </div>
                        `;
                    }
                }

                const messageContent = fileContent + (sanitizedMessage ? `<div>${sanitizedMessage}</div>` : '');

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
                                ${messageContent}
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
                                ${messageContent}
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

                // Check if we have either message or file
                if (!message && !currentFile) {
                    alert('Silakan ketik pesan atau pilih file untuk dikirim.');
                    return;
                }

                // Frontend XSS validation for message
                if (message && containsXSS(message)) {
                    alert(
                        'Pesan mengandung konten yang tidak diizinkan. Silakan hapus script atau kode HTML.');
                    return;
                }

                // Check message length
                if (message && message.length > 1000) {
                    alert('Pesan terlalu panjang. Maksimal 1000 karakter.');
                    return;
                }

                // Disable form during submission
                sendBtn.disabled = true;
                messageInput.disabled = true;
                fileBtn.disabled = true;
                sendBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Mengirim...';

                // Create form data
                const formData = new FormData();
                formData.append('_token', document.querySelector('input[name="_token"]').value);

                if (message) {
                    formData.append('message', message);
                }

                if (currentFile) {
                    formData.append('file', currentFile);
                }

                // Send message
                fetch('{{ route('general.live-chat.send') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Add message to chat immediately
                            addMessage(data.message);

                            // Clear form
                            messageInput.value = '';
                            messageInput.classList.remove('is-invalid');
                            removeFile();
                        } else {
                            alert(data.error || 'Gagal mengirim pesan. Silakan coba lagi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    })
                    .finally(() => {
                        // Re-enable form
                        sendBtn.disabled = false;
                        messageInput.disabled = false;
                        fileBtn.disabled = false;
                        sendBtn.innerHTML = '<i class="bi bi-send-fill me-1"></i> Kirim';
                        messageInput.focus();
                    });
            });

            // Listen for new messages via Laravel Echo
            if (window.Echo) {
                // Get session ID from backend-provided hidden input
                const currentSessionId = document.getElementById('current-session-id').value;
                console.log('Connecting to session:', currentSessionId);

                window.Echo.channel(`chat.${currentSessionId}`)
                    .listen('MessageSent', (e) => {
                        // Check if message is not already displayed
                        if (!document.querySelector(`[data-message-id="${e.id}"]`)) {
                            addMessage(e);
                        }
                    });
            }

            // Initial scroll to bottom
            scrollToBottom();
        });
    </script>
    </script>
@endsection
