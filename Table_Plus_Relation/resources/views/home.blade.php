@extends('layouts.app')

@section('title','Beranda - Aplikasi Sederhana')

@section('head')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); }
        .btn-primary { transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-outline { transition: all 0.3s ease; }
        .btn-outline:hover { transform: translateY(-2px); }
    </style>
@endsection

@section('content')
    <!-- Main Content -->
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-500 to-blue-600 text-white py-16">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Selamat Datang, <span class="text-yellow-300">YuukiYuna</span>! 🌷</h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto">
                    Aplikasi demo sederhana untuk mencatat ide-ide kecil dan menerima pesan. 
                    Cepat, ringan, dan mudah dikembangkan.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/contact" class="bg-transparent border-2 border-white text-white font-semibold py-3 px-6 rounded-lg hover:bg-white hover:bg-opacity-10 transition-all">
                        <i class="fas fa-envelope mr-2"></i> Kirim Pesan
                    </a>
                    <a href="/messages" class="bg-white text-blue-600 font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all">
                        <i class="fas fa-inbox mr-2"></i> Lihat Pesan
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Fitur Aplikasi</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Aplikasi ini dibuat dengan sederhana namun memiliki fungsi yang berguna</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-blue-50 rounded-xl p-6 card-hover border border-blue-100">
                        <div class="bg-blue-500 text-white w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-sticky-note text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-blue-700 mb-2">Navigasi Cepat</h3>
                        <p class="text-gray-600">Akses cepat ke semua fitur dan halaman aplikasi.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="bg-purple-50 rounded-xl p-6 card-hover border border-purple-100">
                        <div class="bg-purple-500 text-white w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-inbox text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-purple-700 mb-2">Pesan Masuk</h3>
                        <p class="text-gray-600">Terima pesan dari pengguna, termasuk gambar jika ada. Sederhana dan efisien.</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="bg-green-50 rounded-xl p-6 card-hover border border-green-100">
                        <div class="bg-green-500 text-white w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-code text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-green-700 mb-2">Mudah Dikembangkan</h3>
                        <p class="text-gray-600">Dasar yang baik untuk belajar framework web dengan struktur yang terorganisir.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Links -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Jelajahi Aplikasi</h2>
                    <p class="text-gray-600">Akses cepat ke semua halaman yang tersedia</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="/" class="bg-white rounded-xl p-6 text-center shadow-sm card-hover border border-blue-100">
                        <div class="bg-blue-100 text-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-home text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Beranda</h3>
                        <p class="text-gray-600 text-sm">Halaman utama aplikasi</p>
                    </a>
                    
                    <a href="/blog" class="bg-white rounded-xl p-6 text-center shadow-sm card-hover border border-green-100">
                        <div class="bg-green-100 text-green-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-blog text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Blog</h3>
                        <p class="text-gray-600 text-sm">Baca artikel terbaru</p>
                    </a>
                    
                    <a href="/contact" class="bg-white rounded-xl p-6 text-center shadow-sm card-hover border border-purple-100">
                        <div class="bg-purple-100 text-purple-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Kontak</h3>
                        <p class="text-gray-600 text-sm">Hubungi kami</p>
                    </a>
                    
                    <a href="/about" class="bg-white rounded-xl p-6 text-center shadow-sm card-hover border border-yellow-100">
                        <div class="bg-yellow-100 text-yellow-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-info-circle text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Tentang</h3>
                        <p class="text-gray-600 text-sm">Tentang aplikasi ini</p>
                    </a>
                    
                    <a href="/messages" class="bg-white rounded-xl p-6 text-center shadow-sm card-hover border border-blue-100">
                        <div class="bg-blue-100 text-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Pesan</h3>
                        <p class="text-gray-600 text-sm">Lihat semua pesan masuk</p>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection