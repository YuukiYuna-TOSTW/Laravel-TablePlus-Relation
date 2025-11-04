@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-50">
  <div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold text-gray-800 text-center mb-10">✨ Blog Terbaru ✨</h2>
    
    @if($blogs->isEmpty())
      <p class="text-center text-gray-500">Belum ada postingan blog yang tersedia.</p>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($blogs as $blog)
          <article class="bg-white rounded-2xl shadow hover:shadow-lg transition-shadow overflow-hidden">
            <!-- Gambar blog -->
            <div class="relative h-56 bg-gradient-to-r from-{{ $blog->color }}-400 to-{{ $blog->color }}-600">
              @if($blog->image)
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-full rounded-lg">
              @else
                <div class="absolute inset-0 flex items-center justify-center text-white text-4xl font-bold opacity-60">
                  {{ strtoupper(substr($blog->title, 0, 1)) }}
                </div>
              @endif

              <div class="absolute top-4 left-4">
                <span class="bg-{{ $blog->color }}-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                  {{ $blog->category }}
                </span>
              </div>
              <div class="absolute bottom-4 left-4">
                <span class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-medium">
                  {{ $blog->reading_time }} menit baca
                </span>
              </div>
            </div>

            <!-- Konten blog -->
            <div class="p-6">
              <div class="flex items-center text-gray-500 text-sm mb-2">
                <i class="far fa-calendar mr-1"></i> {{ $blog->date ?? now()->format('d M Y') }}
                <span class="mx-2">•</span>
                <i class="far fa-user mr-1"></i> {{ $blog->author ?? 'Anonim' }}
              </div>

              <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $blog->title }}</h3>
              <p class="text-gray-600 mb-4 leading-relaxed">
                {{ $blog->description }}
              </p>

              <div class="flex justify-between items-center">
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors flex items-center">
                  Baca Selengkapnya
                  <i class="fas fa-arrow-right ml-1 text-sm"></i>
                </a>
                <div class="flex items-center text-gray-500 text-sm">
                  <i class="far fa-comment mr-1"></i> {{ $blog->comments ?? 0 }}
                </div>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
