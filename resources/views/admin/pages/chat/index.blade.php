@extends('admin.layouts.main')

@section('container')
    <div class="container-fluid py-2 py-md-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fs-6 fs-md-5"><i class="bi bi-chat-dots me-1 me-md-2"></i>Live Chat Admin</h5>
                        <div class="d-flex align-items-center">
                            <!-- Mobile Menu Toggle -->
                            <button class="btn btn-sm btn-outline-light d-lg-none me-2" id="mobile-menu-toggle"
                                type="button">
                                <i class="bi bi-list"></i>
                            </button>
                            {{-- <button class="btn btn-sm btn-outline-light" onclick="clearAllChats()">
                                <i class="bi bi-trash me-1"></i>Clear All
                            </button> --}}
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row g-0" style="height: 70vh;">

                            <!-- Sessions Sidebar -->
                            <div class="col-lg-4 border-end mobile-sidebar" id="sessions-sidebar">
                                <div class="p-2 p-md-3 border-bottom bg-white">
                                    <h6 class="mb-0 fs-6"><i class="bi bi-people me-1 me-md-2"></i>Chat Sessions</h6>
                                    <small class="text-muted">{{ $sessions->count() }} active conversations</small>
                                </div>
                                <div class="sessions-list" style="height: calc(70vh - 70px); overflow-y: auto;">
                                    @if ($sessions->count() > 0)
                                        @foreach ($sessions as $session)
                                            <div class="session-item p-2 p-md-3 border-bottom cursor-pointer {{ $loop->first ? 'active' : '' }}"
                                                data-session-id="{{ $session->session_id }}"
                                                onclick="loadSession('{{ $session->session_id }}', this)">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-bold fs-6">Pengguna {{ $session->session_id }}
                                                        </h6>
                                                        <small class="text-muted d-block">Session:
                                                            {{ substr($session->session_id, 0, 8) }}...</small>
                                                        <small class="text-muted">{{ $session->message_count }}
                                                            messages</small>
                                                    </div>
                                                    <div class="text-end">
                                                        <small
                                                            class="text-muted d-block">{{ \Carbon\Carbon::parse($session->latest_message_time)->format('H:i') }}</small>
                                                        @if ($session->unread_count > 0)
                                                            <span
                                                                class="badge bg-danger">{{ $session->unread_count }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center p-3 p-md-4" id="no-sessions">
                                            <i class="bi bi-chat-dots display-4 text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada chat sessions</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Chat Messages Area -->
                            <div class="col-lg-8 d-flex flex-column chat-area">
                                <!-- Chat Header -->
                                <div class="p-2 p-md-3 border-bottom bg-white">
                                    <div class="d-flex align-items-center">
                                        <!-- Back button for mobile -->
                                        <button class="btn btn-sm btn-outline-secondary d-lg-none me-2"
                                            id="back-to-sessions">
                                            <i class="bi bi-arrow-left"></i>
                                        </button>
                                        <div class="me-2 me-md-3">
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 30px; height: 30px;">
                                                <i class="bi bi-person-circle fs-6"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fs-6" id="active-user-name">
                                                @if($firstSessionId)
                                                    Pengguna {{ $firstSessionId }}
                                                @else
                                                    Select Session
                                                @endif
                                            </h6>
                                            <small class="text-muted" id="active-session-id">
                                                @if($firstSessionId)
                                                    Session: {{ $firstSessionId }}
                                                @else
                                                    No active session
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Messages Container -->
                                <div class="flex-grow-1 p-2 p-md-4 bg-light overflow-auto" id="admin-chat-box"
                                    style="max-height: calc(70vh - 120px);">
                                    @if($messages->count() > 0)
                                        @foreach ($messages as $message)
                                            @if ($message->is_admin)
                                                {{-- Admin Message --}}
                                                <div class="d-flex mb-2 mb-md-3 flex-row-reverse align-items-start message-item"
                                                    data-message-id="{{ $message->id }}">
                                                    <div class="ms-2 ms-md-3">
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 30px; height: 30px;">
                                                            <i class="bi bi-shield-check" style="font-size: 12px;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="me-2 me-md-3" style="max-width: 75%;">
                                                        <div class="bg-primary text-white rounded px-2 px-md-3 py-2">
                                                            <div class="small text-white-50 fw-semibold mb-1">
                                                                {{ $message->user_name }}</div>
                                                            
                                                            {{-- File Display --}}
                                                            @if($message->file_path)
                                                                <div class="file-message mb-2">
                                                                    @if($message->file_type && str_starts_with($message->file_type, 'image/'))
                                                                        <img src="{{ asset('storage/' . $message->file_path) }}" 
                                                                             class="img-fluid rounded" 
                                                                             style="max-width: 200px; max-height: 150px; cursor: pointer;" 
                                                                             onclick="window.open('{{ asset('storage/' . $message->file_path) }}', '_blank')">
                                                                    @else
                                                                        <a href="{{ asset('storage/' . $message->file_path) }}" 
                                                                           class="text-decoration-none d-flex align-items-center p-2 border rounded bg-primary-subtle" 
                                                                           target="_blank" style="font-size: 12px;">
                                                                            <i class="bi 
                                                                                @if($message->file_type === 'application/pdf') bi-file-earmark-pdf
                                                                                @elseif($message->file_type && str_contains($message->file_type, 'word')) bi-file-earmark-word
                                                                                @elseif($message->file_type === 'text/plain') bi-file-earmark-text
                                                                                @elseif($message->file_type && (str_contains($message->file_type, 'zip') || str_contains($message->file_type, 'rar'))) bi-file-earmark-zip
                                                                                @else bi-file-earmark
                                                                                @endif me-2"></i>
                                                                            <div>
                                                                                <div class="fw-semibold">{{ $message->file_name }}</div>
                                                                                @if($message->file_size)
                                                                                    <div class="small text-muted">{{ $message->getFormattedFileSize() }}</div>
                                                                                @endif
                                                                            </div>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            
                                                            @if($message->message)
                                                                <div style="font-size: 14px;">{{ $message->message }}</div>
                                                            @endif
                                                        </div>
                                                        <small class="text-muted"
                                                            style="font-size: 11px;">{{ $message->created_at->format('H:i') }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- User Message --}}
                                                <div class="d-flex mb-2 mb-md-3 align-items-start message-item"
                                                    data-message-id="{{ $message->id }}">
                                                    <div class="me-2 me-md-3">
                                                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 30px; height: 30px;">
                                                            <i class="bi bi-person-circle" style="font-size: 12px;"></i>
                                                        </div>
                                                    </div>
                                                    <div style="max-width: 75%;">
                                                        <div class="bg-white border rounded px-2 px-md-3 py-2 shadow-sm">
                                                            <div class="small text-primary fw-semibold mb-1">
                                                                {{ $message->user_name }}</div>
                                                            
                                                            {{-- File Display --}}
                                                            @if($message->file_path)
                                                                <div class="file-message mb-2">
                                                                    @if($message->file_type && str_starts_with($message->file_type, 'image/'))
                                                                        <img src="{{ asset('storage/' . $message->file_path) }}" 
                                                                             class="img-fluid rounded" 
                                                                             style="max-width: 200px; max-height: 150px; cursor: pointer;" 
                                                                             onclick="window.open('{{ asset('storage/' . $message->file_path) }}', '_blank')">
                                                                    @else
                                                                        <a href="{{ asset('storage/' . $message->file_path) }}" 
                                                                           class="text-decoration-none d-flex align-items-center p-2 border rounded bg-secondary-subtle" 
                                                                           target="_blank" style="font-size: 12px;">
                                                                            <i class="bi 
                                                                                @if($message->file_type === 'application/pdf') bi-file-earmark-pdf
                                                                                @elseif($message->file_type && str_contains($message->file_type, 'word')) bi-file-earmark-word
                                                                                @elseif($message->file_type === 'text/plain') bi-file-earmark-text
                                                                                @elseif($message->file_type && (str_contains($message->file_type, 'zip') || str_contains($message->file_type, 'rar'))) bi-file-earmark-zip
                                                                                @else bi-file-earmark
                                                                                @endif me-2"></i>
                                                                            <div>
                                                                                <div class="fw-semibold">{{ $message->file_name }}</div>
                                                                                @if($message->file_size)
                                                                                    <div class="small text-muted">{{ $message->getFormattedFileSize() }}</div>
                                                                                @endif
                                                                            </div>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            
                                                            @if($message->message)
                                                                <div style="font-size: 14px;">{{ $message->message }}</div>
                                                            @endif
                                                        </div>
                                                        <small class="text-muted"
                                                            style="font-size: 11px;">{{ $message->created_at->format('H:i') }}</small>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <div class="text-center p-3">
                                                <i class="bi bi-chat-dots display-4 text-muted mb-3"></i>
                                                @if($sessions->count() > 0)
                                                    <h5 class="text-muted fs-6">Pilih session untuk memulai chat</h5>
                                                    <p class="text-muted small">Pilih salah satu session dari sidebar kiri</p>
                                                @else
                                                    <h5 class="text-muted fs-6">Belum ada chat sessions</h5>
                                                    <p class="text-muted small">Menunggu pengguna untuk memulai chat</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Admin Reply Form -->
                                <div class="border-top p-2 p-md-3 bg-white">
                                    <form id="admin-chat-form" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" id="current-session-id" value="{{ $firstSessionId ?? '' }}">
                                        
                                        <!-- File Preview Area -->
                                        <div id="admin-file-preview" class="mb-2" style="display: none;">
                                            <div class="border rounded p-2 bg-light">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-file-earmark me-2 text-primary"></i>
                                                        <div>
                                                            <div id="admin-file-name" class="fw-semibold small"></div>
                                                            <div id="admin-file-size" class="small text-muted"></div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" id="admin-remove-file">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                                <img id="admin-image-preview" class="mt-2 img-thumbnail" style="max-height: 150px; display: none;" />
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <input type="file" id="admin-file-input" name="file" class="d-none" accept="image/*,.pdf,.doc,.docx,.txt,.zip,.rar">
                                            <button type="button" class="btn btn-outline-secondary" id="admin-file-btn" title="Upload File">
                                                <i class="bi bi-paperclip"></i>
                                            </button>
                                            <input type="text" id="admin-message-input" name="message"
                                                class="form-control border-0 shadow-sm"
                                                placeholder="Ketik balasan atau upload file..." style="font-size: 14px;" 
                                                {{ $firstSessionId ? '' : 'disabled' }}>
                                            <button class="btn btn-primary rounded-end-pill px-3 px-md-4" type="submit"
                                                id="admin-send-btn" {{ $firstSessionId ? '' : 'disabled' }}>
                                                <i class="bi bi-send-fill"></i>
                                                <span class="d-none d-md-inline ms-1">Kirim</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobile-overlay"></div>

    <!-- Quick Replies Modal -->
    <div class="modal fade" id="quickRepliesModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Replies</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary text-start quick-reply"
                            data-message="Halo! Terima kasih telah menghubungi kami. Ada yang bisa kami bantu?">
                            <i class="bi bi-chat-left-text me-2"></i>Salam Pembuka
                        </button>
                        <button class="btn btn-outline-primary text-start quick-reply"
                            data-message="Silakan berikan detail masalah laptop Anda dan kode service jika ada.">
                            <i class="bi bi-laptop me-2"></i>Minta Detail Service
                        </button>
                        <button class="btn btn-outline-primary text-start quick-reply"
                            data-message="Baik, saya akan cek status service Anda. Mohon tunggu sebentar.">
                            <i class="bi bi-search me-2"></i>Cek Status
                        </button>
                        <button class="btn btn-outline-primary text-start quick-reply"
                            data-message="Terima kasih telah menghubungi kami. Jika ada pertanyaan lain, jangan ragu untuk bertanya.">
                            <i class="bi bi-hand-thumbs-up me-2"></i>Penutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])

    <style>
        .session-item {
            transition: background-color 0.2s;
            cursor: pointer;
        }

        .session-item:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }

        .session-item.active {
            background-color: rgba(0, 123, 255, 0.2);
            border-left: 4px solid #007bff;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 991.98px) {
            .mobile-sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 80%;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease;
                background: white;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .mobile-sidebar.show {
                left: 0;
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }

            .mobile-overlay.show {
                display: block;
            }

            .chat-area {
                width: 100%;
            }

            .sessions-list {
                height: calc(100vh - 70px) !important;
            }
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }

            .card {
                border-radius: 15px !important;
            }

            .message-item .bg-primary,
            .message-item .bg-white {
                font-size: 13px;
            }

            #admin-message-input {
                font-size: 14px;
            }
        }

        /* Session notification animations */
        .session-item {
            transition: background-color 0.3s ease;
        }

        .session-item .badge {
            animation: pulse 1s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(1.1);
            }
        }

        /* File upload styles */
        .file-message img {
            transition: transform 0.2s ease;
        }
        
        .file-message img:hover {
            transform: scale(1.05);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById('admin-chat-box');
            const chatForm = document.getElementById('admin-chat-form');
            const messageInput = document.getElementById('admin-message-input');
            const sendBtn = document.getElementById('admin-send-btn');
            const quickReplyButtons = document.querySelectorAll('.quick-reply');
            const currentSessionInput = document.getElementById('current-session-id');

            // File upload elements
            const fileInput = document.getElementById('admin-file-input');
            const fileBtn = document.getElementById('admin-file-btn');
            const filePreview = document.getElementById('admin-file-preview');
            const fileName = document.getElementById('admin-file-name');
            const fileSize = document.getElementById('admin-file-size');
            const imagePreview = document.getElementById('admin-image-preview');
            const removeFileBtn = document.getElementById('admin-remove-file');
            
            let currentFile = null;

            // Mobile elements
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const sessionsSidebar = document.getElementById('sessions-sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');
            const backToSessions = document.getElementById('back-to-sessions');

            // Echo channel tracking
            let currentEchoChannel = null;

            // File input click handler
            if (fileBtn) {
                fileBtn.addEventListener('click', function() {
                    fileInput.click();
                });
            }
            
            // File selection handler
            if (fileInput) {
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
            }
            
            // Remove file handler
            if (removeFileBtn) {
                removeFileBtn.addEventListener('click', function() {
                    removeFile();
                });
            }
            
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
                    else if (file.type.includes('zip') || file.type.includes('rar')) iconClass = 'bi-file-earmark-zip';
                    
                    const icon = filePreview.querySelector('.bi');
                    if (icon) {
                        icon.className = 'bi ' + iconClass + ' me-2 text-primary';
                    }
                }
                
                filePreview.style.display = 'block';
                messageInput.placeholder = 'Tambahkan keterangan file (opsional)...';
            }
            
            // Remove file
            function removeFile() {
                currentFile = null;
                fileInput.value = '';
                filePreview.style.display = 'none';
                imagePreview.style.display = 'none';
                messageInput.placeholder = 'Ketik balasan atau upload file...';
            }
            
            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Mobile menu handlers
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    sessionsSidebar.classList.add('show');
                    mobileOverlay.classList.add('show');
                });
            }

            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', function() {
                    sessionsSidebar.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                });
            }

            if (backToSessions) {
                backToSessions.addEventListener('click', function() {
                    sessionsSidebar.classList.add('show');
                    mobileOverlay.classList.add('show');
                });
            }

            // Auto scroll to bottom
            function scrollToBottom() {
                if (chatBox) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            }

            // Listen to chat channel
            function setupEchoChannel() {
                // Leave previous channel if exists
                if (currentEchoChannel) {
                    window.Echo.leave(currentEchoChannel);
                }

                if (window.Echo) {
                    // Listen to public chat channel for admin
                    currentEchoChannel = `chat`;
                    window.Echo.channel(currentEchoChannel)
                        .listen('MessageSent', (e) => {
                            console.log('New message received:', e);

                            // Check if this is a new session that doesn't exist in the sidebar
                            const existingSession = document.querySelector(`[data-session-id="${e.session_id}"]`);
                            if (!existingSession && e.session_id && !e.is_admin) {
                                // Add new session to the sidebar only for user messages
                                addNewSessionToSidebar(e);
                            }

                            // Check if message belongs to current active session
                            const activeSessionId = currentSessionInput ? currentSessionInput.value : null;
                            console.log('Active Session ID:', activeSessionId, e.session_id === activeSessionId, e);
                            if (e.session_id === activeSessionId) {
                                // Check if message is not already displayed
                                if (!document.querySelector(`[data-message-id="${e.id}"]`)) {
                                    addMessageToBox(e);
                                    scrollToBottom();
                                }
                            } else if (existingSession && !e.is_admin) {
                                // Update session info in sidebar for non-active sessions (only for user messages)
                                updateSessionInSidebar(e, existingSession);
                            }
                        });
                }
            }

            // Setup Echo channel
            setupEchoChannel();

            // Add new session to sidebar
            function addNewSessionToSidebar(message) {
                const sessionsList = document.querySelector('.sessions-list');
                document.getElementById('no-sessions').style.display = 'none';
                if (!sessionsList) return;

                const currentTime = new Date(message.created_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const newSessionHtml = `
                    <div class="session-item p-2 p-md-3 border-bottom cursor-pointer" 
                         data-session-id="${message.session_id}"
                         onclick="loadSession('${message.session_id}', this)">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold fs-6">Pengguna ${message.session_id}</h6>
                                <small class="text-muted d-block">Session: ${message.session_id.substring(0, 8)}...</small>
                                <small class="text-muted">1 messages</small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">${currentTime}</small>
                                <span class="badge bg-danger">1</span>
                            </div>
                        </div>
                    </div>
                `;

                // Add the new session at the top of the list
                sessionsList.insertAdjacentHTML('afterbegin', newSessionHtml);

                // Update session count
                const sessionCountElement = sessionsList.previousElementSibling?.querySelector('small');
                if (sessionCountElement) {
                    const currentCount = parseInt(sessionCountElement.textContent.match(/\d+/)?.[0] || 0);
                    sessionCountElement.textContent = `${currentCount + 1} active conversations`;
                }

                // Show notification or highlight the new session
                const newSessionElement = sessionsList.querySelector(`[data-session-id="${message.session_id}"]`);
                if (newSessionElement) {
                    newSessionElement.style.backgroundColor = '#e3f2fd';
                    setTimeout(() => {
                        newSessionElement.style.backgroundColor = '';
                    }, 3000);
                }

                // Show notification
                showNotification(`New chat session from ${message.user_name}`, 'info');
            }

            // Update existing session in sidebar
            function updateSessionInSidebar(message, sessionElement) {
                if (!sessionElement) return;

                const currentTime = new Date(message.created_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Update time
                const timeElement = sessionElement.querySelector('.text-end small');
                if (timeElement) {
                    timeElement.textContent = currentTime;
                }

                // Update unread count
                let badgeElement = sessionElement.querySelector('.badge');
                if (badgeElement) {
                    const currentCount = parseInt(badgeElement.textContent) || 0;
                    badgeElement.textContent = currentCount + 1;
                } else {
                    // Create badge if it doesn't exist
                    const textEndDiv = sessionElement.querySelector('.text-end');
                    if (textEndDiv) {
                        textEndDiv.insertAdjacentHTML('beforeend', '<span class="badge bg-danger">1</span>');
                    }
                }

                // Update message count
                const messageCountElement = sessionElement.querySelector('small.text-muted:last-of-type');
                if (messageCountElement && messageCountElement.textContent.includes('messages')) {
                    const currentCount = parseInt(messageCountElement.textContent.match(/\d+/)?.[0] || 0);
                    messageCountElement.textContent = `${currentCount + 1} messages`;
                }

                // Move session to top of the list
                const sessionsList = sessionElement.parentElement;
                if (sessionsList && sessionElement !== sessionsList.firstElementChild) {
                    sessionsList.insertBefore(sessionElement, sessionsList.firstElementChild);
                }

                // Briefly highlight the session
                sessionElement.style.backgroundColor = '#fff3cd';
                setTimeout(() => {
                    sessionElement.style.backgroundColor = '';
                }, 2000);

                // Show notification for new message
                showNotification(`New message from ${message.user_name}`, 'success');
            }

            // Show notification
            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `alert alert-${type === 'success' ? 'success' : 'info'} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-info-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                // Add to document
                document.body.appendChild(notification);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 5000);

                // Try to play notification sound (if supported)
                try {
                    // Create a simple beep sound using Web Audio API
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();
                    
                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);
                    
                    oscillator.frequency.value = 800;
                    oscillator.type = 'sine';
                    
                    gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
                    
                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 0.1);
                } catch (e) {
                    // Fallback: no sound if Web Audio API is not supported
                    console.log('Notification sound not available');
                }
            }

            // Load session messages
            window.loadSession = function(sessionId, element) {
                // Update active session in UI
                document.querySelectorAll('.session-item').forEach(item => {
                    item.classList.remove('active');
                });
                element.classList.add('active');

                // Clear unread badge for selected session
                const badgeElement = element.querySelector('.badge');
                if (badgeElement) {
                    badgeElement.remove();
                }

                // Update current session ID
                if (currentSessionInput) {
                    currentSessionInput.value = sessionId;
                }

                // Hide mobile sidebar after selection
                if (window.innerWidth < 992) {
                    sessionsSidebar.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                }

                // Fetch session messages
                fetch(`{{ url('/dashboard-admin/chat/session') }}/${sessionId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateChatBox(data.messages);

                            // Update header info
                            const firstMessage = data.messages.find(m => !m.is_admin);
                            const activeUserName = document.getElementById('active-user-name');
                            const activeSessionId = document.getElementById('active-session-id');
                            if (firstMessage) {
                                if (activeUserName) {
                                    activeUserName.textContent = firstMessage.user_name;
                                }
                                if (activeSessionId) {
                                    activeSessionId.textContent = `Session: ${sessionId}`;
                                }
                            } else {
                                if (activeUserName) {
                                    activeUserName.textContent = `Pengguna ${sessionId}`;
                                }
                                if (activeSessionId) {
                                    activeSessionId.textContent = `Session: ${sessionId}`;
                                }
                            }

                            // Enable form elements now that a session is active
                            enableChatForm();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            };

            // Enable form elements when a session is loaded
            function enableChatForm() {
                const messageInput = document.getElementById('admin-message-input');
                const fileInput = document.getElementById('admin-file-btn');
                const submitButton = document.querySelector('#admin-send-btn');
                
                if (messageInput) {
                    messageInput.disabled = false;
                    messageInput.placeholder = 'Type your message...';
                }
                if (fileInput) {
                    fileInput.disabled = false;
                }
                if (submitButton) {
                    submitButton.disabled = false;
                }
            }

            // Update chat box with messages
            function updateChatBox(messages) {
                
                if (!chatBox) {
                    console.log('no')
                    return;
                }

                chatBox.innerHTML = '';
                messages.forEach(message => {
                    addMessageToBox(message);
                });
                scrollToBottom();
            }

            // Add message to chat box
            function addMessageToBox(message) {
                if (!chatBox) return;

                const messageElement = document.createElement('div');
                messageElement.classList.add('message-item', 'd-flex', 'mb-2', 'mb-md-3', 'align-items-start');
                messageElement.setAttribute('data-message-id', message.id);

                const currentTime = new Date(message.created_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Create file content if exists
                let fileContent = '';
                if (message.file_path) {
                    const fileUrl = '{{ asset("storage") }}/' + message.file_path;
                    const isImage = message.file_type && message.file_type.startsWith('image/');
                    
                    if (isImage) {
                        fileContent = `
                            <div class="file-message mb-2">
                                <img src="${fileUrl}" class="img-fluid rounded" style="max-width: 200px; max-height: 150px; cursor: pointer;" onclick="window.open('${fileUrl}', '_blank')">
                            </div>
                        `;
                    } else {
                        let fileIcon = 'bi-file-earmark';
                        if (message.file_type === 'application/pdf') fileIcon = 'bi-file-earmark-pdf';
                        else if (message.file_type && message.file_type.includes('word')) fileIcon = 'bi-file-earmark-word';
                        else if (message.file_type === 'text/plain') fileIcon = 'bi-file-earmark-text';
                        else if (message.file_type && (message.file_type.includes('zip') || message.file_type.includes('rar'))) fileIcon = 'bi-file-earmark-zip';
                        
                        fileContent = `
                            <div class="file-message mb-2">
                                <a href="${fileUrl}" class="text-decoration-none d-flex align-items-center p-2 border rounded ${message.is_admin ? 'bg-primary-subtle' : 'bg-secondary-subtle'}" target="_blank" style="font-size: 12px;">
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

                const messageContent = fileContent + (message.message ? `<div style="font-size: 14px;">${message.message}</div>` : '');

                if (message.is_admin) {
                    messageElement.classList.add('flex-row-reverse');
                    messageElement.innerHTML = `
                        <div class="ms-2 ms-md-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 30px; height: 30px;">
                                <i class="bi bi-shield-check" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <div class="me-2 me-md-3" style="max-width: 75%;">
                            <div class="bg-primary text-white rounded px-2 px-md-3 py-2">
                                <div class="small text-white-50 fw-semibold mb-1">${message.user_name}</div>
                                ${messageContent}
                            </div>
                            <small class="text-muted" style="font-size: 11px;">${currentTime}</small>
                        </div>
                    `;
                } else {
                    messageElement.innerHTML = `
                        <div class="me-2 me-md-3">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 30px; height: 30px;">
                                <i class="bi bi-person-circle" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <div style="max-width: 75%;">
                            <div class="bg-white border rounded px-2 px-md-3 py-2 shadow-sm">
                                <div class="small text-primary fw-semibold mb-1">${message.user_name}</div>
                                ${messageContent}
                            </div>
                            <small class="text-muted" style="font-size: 11px;">${currentTime}</small>
                        </div>
                    `;
                }

                chatBox.appendChild(messageElement);
                scrollToBottom();
            }

            // Submit form handler
            if (chatForm) {
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const message = messageInput.value.trim();
                    const sessionId = currentSessionInput ? currentSessionInput.value : null;

                    // Check if we have either message or file
                    if (!message && !currentFile) {
                        alert('Silakan ketik pesan atau pilih file untuk dikirim.');
                        return;
                    }

                    if (!sessionId) {
                        alert('Silakan pilih session terlebih dahulu.');
                        return;
                    }

                    // Disable form during submission
                    sendBtn.disabled = true;
                    messageInput.disabled = true;
                    if (fileBtn) fileBtn.disabled = true;
                    sendBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Mengirim...';

                    // Create form data
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('input[name="_token"]').value);
                    formData.append('session_id', sessionId);
                    
                    if (message) {
                        formData.append('message', message);
                    }
                    
                    if (currentFile) {
                        formData.append('file', currentFile);
                    }

                    // Send message
                    fetch('{{ route('admin.chat.send') }}', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Add message to chat immediately
                                addMessageToBox(data.message);
                                scrollToBottom();

                                // Clear form
                                messageInput.value = '';
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
                            if (fileBtn) fileBtn.disabled = false;
                            sendBtn.innerHTML =
                                '<i class="bi bi-send-fill"></i><span class="d-none d-md-inline ms-1">Kirim</span>';
                        });
                });
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sessionsSidebar.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                }
            });

            // Quick reply handlers
            quickReplyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const message = this.getAttribute('data-message');
                    if (messageInput) {
                        messageInput.value = message;
                        messageInput.focus();
                    }
                });
            });

            // Clear all chats function
            window.clearAllChats = function() {
                if (confirm(
                        'Apakah Anda yakin ingin menghapus semua chat? Tindakan ini tidak dapat dibatalkan.')) {
                    fetch('{{ route('admin.chat.clear') }}', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload(); // Reload page to refresh sessions
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            };

            // Initialize Echo channel for the first active session (if any)
            const initialSessionId = currentSessionInput ? currentSessionInput.value : null;
            if (initialSessionId) {
                setupEchoChannel(initialSessionId);
            }

            // Initial scroll to bottom
            scrollToBottom();
        });
    </script>
@endsection
