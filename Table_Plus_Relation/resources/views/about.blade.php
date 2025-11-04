@extends('layouts.app')

@section('title','Portfolio - Aplikasi Sederhana')

@section('head')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }

        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); }

        .skill-bar { transition: width 1.5s ease-in-out; }

        .animate-on-scroll { opacity: 0; transform: translateY(30px); transition: all 0.6s ease; }
        .animate-on-scroll.animated { opacity: 1; transform: translateY(0); }

        .timeline-item { position: relative; padding-left: 2rem; }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.5rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #3b82f6;
        }
        .timeline-item::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 1.5rem;
            width: 2px;
            height: calc(100% - 1rem);
            background: #d1d5db;
        }
        .timeline-item:last-child::after { display: none; }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-16">
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#experience" class="bg-white text-blue-600 font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all">
                <i class="fas fa-briefcase mr-2"></i> Pengalaman
            </a>
            <a href="#skills" class="bg-transparent border-2 border-white text-white font-semibold py-3 px-6 rounded-lg hover:bg-white hover:bg-opacity-10 transition-all">
                <i class="fas fa-code mr-2"></i> Keterampilan
            </a>
            <a href="#projects" class="bg-transparent border-2 border-white text-white font-semibold py-3 px-6 rounded-lg hover:bg-white hover:bg-opacity-10 transition-all">
                <i class="fas fa-project-diagram mr-2"></i> Proyek
            </a>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Pengalaman</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Perjalanan profesional dan pengembangan karir saya</p>
            </div>

            <div class="max-w-4xl mx-auto">
                @foreach($experiences as $exp)
                    <div class="mb-12 animate-on-scroll">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/3 mb-4 md:mb-0">
                                <h3 class="text-xl font-bold">{{ $exp->title }}</h3>
                                <p class="text-gray-500">{{ $exp->company }}</p>
                                <p class="text-gray-400 text-sm">{{ $exp->period }}</p>
                            </div>
                            <div class="md:w-2/3 bg-gray-50 rounded-xl p-6 card-hover">
                                <p class="text-gray-700 mb-4">{{ $exp->description }}</p>
                                @if($exp->details)
                                    <ul class="text-gray-600 list-disc pl-5">
                                        @foreach(json_decode($exp->details) as $detail)
                                            <li>{{ $detail }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Keterampilan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Teknologi dan alat yang saya kuasai</p>
            </div>

            <div class="max-w-4xl mx-auto">
                @foreach($skills as $category => $skillGroup)
                    <div class="bg-white rounded-xl p-6 shadow-sm card-hover animate-on-scroll mb-8">
                        <h3 class="text-xl font-bold text-blue-700 mb-6">{{ $category }}</h3>
                        @foreach($skillGroup as $skill)
                            <div class="mb-4">
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-700">{{ $skill->name }}</span>
                                    <span class="text-gray-700">{{ $skill->level }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full skill-bar" style="width:0%" data-width="{{ $skill->level }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Proyek</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Beberapa proyek yang telah saya selesaikan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    <div class="bg-white rounded-xl overflow-hidden shadow-md card-hover animate-on-scroll">
                        <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                            <i class="{{ $project->icon }} text-white text-5xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $project->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ $project->description }}</p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach(json_decode($project->technologies) as $tech)
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">{{ $tech }}</span>
                                @endforeach
                            </div>
                            <div class="flex justify-between">
                                <a href="{{ $project->demo_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                    <i class="fas fa-external-link-alt mr-1"></i> Live Demo
                                </a>
                                <a href="{{ $project->source_code }}" target="_blank" class="text-gray-600 hover:text-gray-800 font-medium flex items-center">
                                    <i class="fab fa-github mr-1"></i> Source Code
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="/contact" class="bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:bg-blue-700 transition-all inline-flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i> Tertarik Bekerja Sama?
                </a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.animate-on-scroll');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');

                        // Animasi skill bars
                        if (entry.target.querySelector('.skill-bar')) {
                            const skillBars = entry.target.querySelectorAll('.skill-bar');
                            skillBars.forEach(bar => {
                                const width = bar.getAttribute('data-width');
                                setTimeout(() => { bar.style.width = width; }, 300);
                            });
                        }
                    }
                });
            }, { threshold: 0.1 });

            animatedElements.forEach(element => observer.observe(element));
        });
    </script>
@endsection
