@extends('layouts.app')

@section('title','Admin Dashboard')

@section('head')
    <style>
        /* minimal admin styling - keep consistent with existing theme */
        .stat { background: linear-gradient(90deg,#3b82f6,#2563eb); color:white }
    </style>
@endsection

@section('content')
    <section class="py-8 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Admin Dashboard</h1>
                <div class="flex items-center gap-4">
                    <a href="/" class="text-sm text-gray-600 hover:text-blue-600">Kembali ke situs</a>
                    <form action="/admin/logout" method="post" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Logout</button>
                    </form>
                </div>
            </div>

            @php
                $messages = session('messages', []);
                $messagesCollection = collect($messages);
                $total = count($messages);
                $unread = $messagesCollection->where('read', false)->count();
                $fromContact = $messagesCollection->where('source', 'contact_form')->count();
                $fromMessage = $messagesCollection->where('source', '!=', 'contact_form')->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="rounded-xl p-6 stat shadow-sm">
                    <div class="text-sm">Total Pesan</div>
                    <div class="text-3xl font-bold mt-2">{{ $total }}</div>
                </div>
                <div class="rounded-xl p-6 bg-green-100 shadow-sm">
                    <div class="text-sm text-green-700">Form Kontak</div>
                    <div class="text-3xl font-bold mt-2 text-green-800">{{ $fromContact }}</div>
                </div>
                <div class="rounded-xl p-6 bg-blue-100 shadow-sm">
                    <div class="text-sm text-blue-700">Halaman Message</div>
                    <div class="text-3xl font-bold mt-2 text-blue-800">{{ $fromMessage }}</div>
                </div>
                <div class="rounded-xl p-6 bg-red-100 shadow-sm">
                    <div class="text-sm text-red-700">Belum Dibaca</div>
                    <div class="text-3xl font-bold mt-2 text-red-800">{{ $unread }}</div>
                    <div class="mt-2">
                        <a href="/messages" class="inline-block bg-blue-500 text-white px-3 py-2 rounded-lg text-sm">Lihat Pesan</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100 font-medium">Recent Messages</div>
                <div class="overflow-auto max-h-72">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-left">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Pengirim</th>
                                <th class="px-4 py-2">Subjek</th>
                                <th class="px-4 py-2">Sumber</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_reverse($messages) as $i => $m)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $i+1 }}</td>
                                    <td class="px-4 py-2">{{ $m['name'] ?? '-' }}<div class="text-xs text-gray-500">{{ $m['email'] ?? '' }}</div></td>
                                    <td class="px-4 py-2">{{ $m['subject'] ?? '—' }}</td>
                                    <td class="px-4 py-2">
                                        @php
                                            $source = $m['source'] ?? 'message_page';
                                            $sourceLabel = $source === 'contact_form' ? 'Form Kontak' : 'Halaman Message';
                                        @endphp
                                        <span class="text-xs px-2 py-1 rounded {{ $source === 'contact_form' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $sourceLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">@if(!empty($m['read'])) <span class="text-sm text-gray-500">Sudah Dibaca</span> @else <span class="text-sm text-blue-600 font-medium">Belum</span> @endif</td>
                                    <td class="px-4 py-2">{{ $m['time'] ?? '' }}</td>
                                </tr>
                            @endforeach
                            @if(empty($messages))
                                <tr><td class="px-4 py-6 text-center text-gray-500" colspan="6">Tidak ada pesan</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh halaman setiap 30 detik
    setInterval(() => {
        window.location.reload();
    }, 30000);
    
    // Tambahkan indikator refresh
    const refreshIndicator = document.createElement('div');
    refreshIndicator.className = 'fixed bottom-4 right-4 z-50';
    refreshIndicator.innerHTML = `
        <div class="bg-blue-500 text-white px-3 py-2 rounded-lg shadow-lg text-xs">
            <i class="fas fa-sync-alt animate-spin"></i> Auto-refresh aktif
        </div>
    `;
    document.body.appendChild(refreshIndicator);
    
    // Sembunyikan indikator setelah 3 detik
    setTimeout(() => {
        refreshIndicator.style.opacity = '0.3';
    }, 3000);
});
</script>
@endsection
