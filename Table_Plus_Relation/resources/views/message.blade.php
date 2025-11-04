@extends('layouts.app')

@section('title','Pesan Masuk - Aplikasi Sederhana')

@section('head')
    <style>
        .message-item { transition: all 0.2s ease; }
        .message-item:hover { background-color: #f9fafb; }
        .status-badge { font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 9999px; }
        .unread { background-color: #eff6ff; color: #1d4ed8; font-weight: 500; }
        .read { background-color: #f3f4f6; color: #6b7280; }
        .email-cell { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .message-preview { display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
@endsection

@section('content')
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-500 to-blue-600 text-white py-16">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold mb-4">Pesan Masuk</h1>
                        <p class="text-xl text-blue-100">Kelola dan lihat semua pesan yang dikirim melalui form kontak</p>
                    </div>
                    <div class="mt-6 md:mt-0 bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-4">
                        @php
                            $totalMessages = count($messages ?? []);
                            $unreadCount = collect($messages ?? [])->where('read', false)->count();
                        @endphp
                        <div class="flex items-center space-x-6">
                            <div class="flex flex-col items-center justify-center h-20 text-center">
                                <div id="totalMessagesCount" class="text-2xl font-bold">{{ $totalMessages }}</div>
                                <div class="text-blue-100 text-sm">Total Pesan</div>
                            </div>
                            <div class="flex flex-col items-center justify-center h-20 text-center">
                                <div id="unreadMessagesCount" class="text-2xl font-bold">{{ $unreadCount }}</div>
                                <div class="text-blue-100 text-sm">Belum Dibaca</div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Messages Section -->
        <section class="py-8 bg-white">
            <div class="container mx-auto px-4">
                <!-- Filters and Actions -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <div class="flex flex-wrap gap-2">
                        <button id="filterAll" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">
                            <i class="fas fa-inbox mr-2"></i> Semua Pesan
                        </button>
                        <button id="filterUnread" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-300 flex items-center">
                            <i class="fas fa-envelope mr-2"></i> Belum Dibaca
                        </button>
                    </div>
                </div>
                
                <!-- Messages List -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-8">
                    <!-- Table Header - Hidden on mobile, shown on medium screens and up -->
                    <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-200 font-medium text-gray-700">
                        <div class="col-span-1 text-center">
                        </div>
                        <div class="col-span-2">Pengirim</div>
                        <div class="col-span-3">Subjek</div>
                        <div class="col-span-1">Sumber</div>
                        <div class="col-span-2">Status</div>
                        <div class="col-span-2">Tanggal</div>
                        <div class="col-span-1 text-center">Aksi</div>
                    </div>
                    
                    <!-- Message Items -->
                    <div class="divide-y divide-gray-200">
                        @if(!empty($messages) && count($messages) > 0)
                            @foreach($messages as $index => $m)
                                @php
                                    $sender = $m['name'] ?? 'Pengirim';
                                    $email = $m['email'] ?? '';
                                    $subject = $m['subject'] ?? '—';
                                    $body = $m['message'] ?? '';
                                    $time = $m['time'] ?? '';
                                @endphp
                                <!-- Mobile View -->
                                <div class="md:hidden p-4 border-b border-gray-200 message-item min-h-[100px] flex flex-col justify-between" data-index="{{ $index }}" data-subject="{{ e($subject) }}" data-sender="{{ e($sender) }}" data-email="{{ e($email) }}" data-fullmessage="{{ e($body) }}" data-time="{{ e($time) }}" data-read="{{ !empty($m['read']) ? '1' : '0' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="font-medium text-gray-800 truncate flex-1 mr-2">{{ $sender }}</div>
                                        @if(!empty($m['read']))
                                            <span class="status-badge read text-xs">Sudah Dibaca</span>
                                        @else
                                            <span class="status-badge unread text-xs">Belum Dibaca</span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center mb-1">
                                        <div class="text-sm text-gray-500 email-cell">{{ $email }}</div>
                                        @php
                                            $source = $m['source'] ?? 'message_page';
                                            $sourceLabel = $source === 'contact_form' ? 'Kontak' : 'Message';
                                            $sourceIcon = $source === 'contact_form' ? 'fa-phone' : 'fa-comment';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $source === 'contact_form' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            <i class="fas {{ $sourceIcon }} mr-1"></i>
                                            {{ $sourceLabel }}
                                        </span>
                                    </div>
                                    <div class="font-medium text-gray-800 mb-2 truncate">{{ $subject }}</div>
                                    <p class="text-sm text-gray-500 message-preview mb-3">{{ \Illuminate\Support\Str::limit($body, 100) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500">{{ $time }}</span>
                                        <div class="flex space-x-2">
                                            <button class="text-blue-500 hover:text-blue-700 view-btn" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-red-500 hover:text-red-700 delete-btn" title="Hapus" data-index="{{ $index }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Desktop View -->
                                <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-4 message-item border-l-4 border-blue-500 items-stretch min-h-[88px]" data-index="{{ $index }}" data-subject="{{ e($subject) }}" data-sender="{{ e($sender) }}" data-email="{{ e($email) }}" data-fullmessage="{{ e($body) }}" data-time="{{ e($time) }}" data-read="{{ !empty($m['read']) ? '1' : '0' }}">
                                    <div class="col-span-1 flex items-center justify-center">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                            <i class="fas fa-envelope-open-text"></i>
                                        </div>
                                    </div>
                                    <div class="col-span-2 flex flex-col justify-center">
                                        <div class="font-medium text-gray-800 truncate">{{ $sender }}</div>
                                        <div class="text-sm text-gray-500 email-cell">{{ $email }}</div>
                                    </div>
                                    <div class="col-span-3 flex flex-col justify-center">
                                        <div class="font-medium text-gray-800 truncate">{{ $subject }}</div>
                                        <p class="text-sm text-gray-500 message-preview">{{ \Illuminate\Support\Str::limit($body, 120) }}</p>
                                    </div>
                                    <div class="col-span-1 flex items-center justify-center">
                                        @php
                                            $source = $m['source'] ?? 'message_page';
                                            $sourceLabel = $source === 'contact_form' ? 'Kontak' : 'Message';
                                            $sourceIcon = $source === 'contact_form' ? 'fa-phone' : 'fa-comment';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $source === 'contact_form' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            <i class="fas {{ $sourceIcon }} mr-1"></i>
                                            {{ $sourceLabel }}
                                        </span>
                                    </div>
                                    <div class="col-span-2 flex items-center justify-start">
                                        @if(!empty($m['read']))
                                            <span class="status-badge read">Sudah Dibaca</span>
                                        @else
                                            <span class="status-badge unread">Belum Dibaca</span>
                                        @endif
                                    </div>
                                    <div class="col-span-2 flex items-center justify-start text-sm text-gray-500">
                                        {{ $time }}
                                    </div>
                                    <div class="col-span-1 flex items-center justify-center space-x-2">
                                        <button class="text-blue-500 hover:text-blue-700 view-btn" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-red-500 hover:text-red-700 delete-btn" title="Hapus" data-index="{{ $index }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="px-6 py-12 text-center text-gray-600">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg">Tidak ada pesan</p>
                                <p class="text-sm mt-2">Pesan yang dikirim melalui form kontak akan muncul di sini</p>
                            </div>
                        @endif
                    </div>
                </div>
                

            </div>
        </section>

        <!-- Message Detail Modal -->
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden" id="messageModal">
            <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] flex flex-col">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 mr-4">
                            <h3 class="text-xl font-bold text-gray-800 break-words" id="modalSubject"></h3>
                            <div class="flex flex-wrap items-center mt-2 gap-2">
                                <div class="flex items-center">
                                    <span class="font-medium text-gray-700" id="modalSender"></span>
                                    <span class="text-gray-500 ml-2 break-all" id="modalEmail"></span>
                                </div>
                                <span class="status-badge" id="modalStatus"></span>
                            </div>
                        </div>
                        <button class="text-gray-500 hover:text-gray-700 flex-shrink-0" id="closeModal">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-6 overflow-auto flex-1">
                    <div class="mb-4">
                        <span class="text-sm text-gray-500" id="modalDate"></span>
                    </div>
                    
                    <div class="prose max-w-none whitespace-pre-line text-gray-700" id="modalMessage">
                    </div>
                </div>
                
                <div class="p-6 border-t border-gray-200 bg-gray-50 flex justify-end">
                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </main>

@endsection

<!-- Data for JavaScript -->
<script type="application/json" id="messages-data">
    {!! json_encode($messages ?? []) !!}
</script>

@section('scripts')
    <script>
        // Script untuk menampilkan modal detail pesan
        document.addEventListener('DOMContentLoaded', function() {
            const messageModal = document.getElementById('messageModal');
            const closeModal = document.getElementById('closeModal');
            const viewButtons = document.querySelectorAll('.view-btn');
            const deleteButtons = document.querySelectorAll('.delete-btn');

            // Track current filter state: false = all, true = unread-only
            let currentFilterUnreadOnly = false;

            // helper to update counters
            function updateCounters(deltaTotal, deltaUnread) {
                const totalEl = document.getElementById('totalMessagesCount');
                const unreadEl = document.getElementById('unreadMessagesCount');
                if (totalEl && typeof deltaTotal === 'number') {
                    totalEl.textContent = Math.max(0, parseInt(totalEl.textContent || '0') + deltaTotal);
                }
                if (unreadEl && typeof deltaUnread === 'number') {
                    unreadEl.textContent = Math.max(0, parseInt(unreadEl.textContent || '0') + deltaUnread);
                }
            }

            // Re-index message items after deletion so data-index matches new order
            function reindexMessageItems() {
                document.querySelectorAll('.message-item').forEach((el, idx) => {
                    el.setAttribute('data-index', String(idx));
                    // update delete button and any other button data-index
                    const del = el.querySelector('.delete-btn');
                    if (del) del.setAttribute('data-index', String(idx));
                });
            }

            // View button -> populate modal from data attributes and mark as read
            viewButtons.forEach(button => {
                button.addEventListener('click', async function() {
                    const row = this.closest('.message-item');
                    if (!row) return;
                    const sender = row.getAttribute('data-sender') || '';
                    const email = row.getAttribute('data-email') || '';
                    const subject = row.getAttribute('data-subject') || '';
                    const full = row.getAttribute('data-fullmessage') || '';
                    const time = row.getAttribute('data-time') || '';
                    const idx = row.getAttribute('data-index');

                    document.getElementById('modalSubject').textContent = subject;
                    document.getElementById('modalSender').textContent = sender;
                    document.getElementById('modalEmail').textContent = email;
                    document.getElementById('modalDate').textContent = time;
                    document.getElementById('modalMessage').textContent = full;

                    // If message is unread, mark as read via API
                    const isRead = row.getAttribute('data-read') === '1';
                    if (!isRead && idx) {
                        try {
                            const res = await fetch('/messages/' + idx + '/read', {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            });
                            if (res.ok) {
                                // update DOM badges and data-read
                                row.setAttribute('data-read', '1');
                                row.querySelectorAll('.status-badge').forEach(b => {
                                    b.classList.remove('unread');
                                    b.classList.add('read');
                                    b.textContent = 'Sudah Dibaca';
                                });

                                // decrement unread counter
                                updateCounters(0, -1);

                                // if current filter is unread-only, hide this row now that it's read
                                if (currentFilterUnreadOnly) {
                                    row.style.display = 'none';
                                }
                            }
                        } catch (e) {
                            console.warn('Mark read failed', e);
                        }
                    }

                    messageModal.classList.remove('hidden');
                });
            });

            // Filter buttons: show all or only unread
            const filterAllBtn = document.getElementById('filterAll');
            const filterUnreadBtn = document.getElementById('filterUnread');
            function setActiveButton(showUnreadOnly) {
                if (!filterAllBtn || !filterUnreadBtn) return;
                if (showUnreadOnly) {
                    // filterUnread active
                    filterUnreadBtn.classList.remove('bg-gray-200','text-gray-700');
                    filterUnreadBtn.classList.add('bg-blue-500','text-white');
                    filterUnreadBtn.setAttribute('aria-pressed','true');

                    filterAllBtn.classList.remove('bg-blue-500','text-white');
                    filterAllBtn.classList.add('bg-gray-200','text-gray-700');
                    filterAllBtn.setAttribute('aria-pressed','false');
                } else {
                    // filterAll active
                    filterAllBtn.classList.remove('bg-gray-200','text-gray-700');
                    filterAllBtn.classList.add('bg-blue-500','text-white');
                    filterAllBtn.setAttribute('aria-pressed','true');

                    filterUnreadBtn.classList.remove('bg-blue-500','text-white');
                    filterUnreadBtn.classList.add('bg-gray-200','text-gray-700');
                    filterUnreadBtn.setAttribute('aria-pressed','false');
                }
            }

            function applyFilter(showUnreadOnly) {
                currentFilterUnreadOnly = !!showUnreadOnly;
                document.querySelectorAll('.message-item').forEach(item => {
                    const isRead = item.getAttribute('data-read') === '1';
                    if (showUnreadOnly) {
                        if (isRead) item.style.display = 'none'; else item.style.display = '';
                    } else {
                        item.style.display = '';
                    }
                });
                setActiveButton(showUnreadOnly);
            }

            // initialize default filter (All active)
            if (filterAllBtn && filterUnreadBtn) {
                setActiveButton(false);
                filterAllBtn.addEventListener('click', () => applyFilter(false));
                filterUnreadBtn.addEventListener('click', () => applyFilter(true));
            }

            // Delete button -> call DELETE endpoint and remove row from DOM
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', async function () {
                    let idx = this.getAttribute('data-index');
                    if (typeof idx === 'undefined') return;
                    idx = String(idx);
                    if (!confirm('Hapus pesan ini?')) return;

                    try {
                        const res = await fetch('/messages/' + idx, {
                            method: 'DELETE',
                            headers: { 
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        });

                        if (!res.ok) throw new Error('Gagal menghapus pesan');

                        const data = await res.json();

                        // Determine read-state of the removed rows before removing
                        const rows = Array.from(document.querySelectorAll(`.message-item[data-index="${idx}"]`));
                        let removedCount = 0, removedUnread = 0;
                        rows.forEach(row => {
                            removedCount++;
                            if (row.getAttribute('data-read') !== '1') removedUnread++;
                            row.remove();
                        });

                        // Update counters
                        updateCounters(-removedCount, -removedUnread);

                        // Reindex remaining items so data-index stays consistent
                        reindexMessageItems();

                        // If current filter is unread-only, ensure any read items are hidden
                        if (currentFilterUnreadOnly) {
                            document.querySelectorAll('.message-item').forEach(item => {
                                if (item.getAttribute('data-read') === '1') item.style.display = 'none';
                            });
                        }

                        // Show placeholder if no messages left
                        const messageContainer = document.querySelector('.divide-y.divide-gray-200');
                        if (messageContainer && messageContainer.querySelectorAll('.message-item').length === 0) {
                            messageContainer.innerHTML = `
                                <div class="px-6 py-12 text-center text-gray-600">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg">Tidak ada pesan</p>
                                    <p class="text-sm mt-2">Pesan yang dikirim melalui form kontak akan muncul di sini</p>
                                </div>
                            `;
                        }

                    } catch (error) {
                        console.error('Error:', error);
                        alert('Gagal menghapus pesan. Silakan coba lagi.');
                    }
                });
            });
            
            // Tutup modal
            closeModal.addEventListener('click', function() {
                messageModal.classList.add('hidden');
            });
            
            // Tutup modal ketika klik di luar konten modal
            messageModal.addEventListener('click', function(e) {
                if (e.target === messageModal) {
                    messageModal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection