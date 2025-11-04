@extends('layouts.app')

@section('title','Kontak - Aplikasi Sederhana')

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
        .form-input:focus { box-shadow: 0 0 0 3px rgba(59,130,246,0.1); border-color: #3b82f6; }
        
        /* Tambahan untuk feedback form */
        .form-success { 
            background-color: #d1fae5; 
            border: 1px solid #10b981; 
            color: #065f46; 
            padding: 1rem; 
            border-radius: 0.5rem; 
            margin-bottom: 1rem; 
        }
        .form-error { 
            background-color: #fee2e2; 
            border: 1px solid #ef4444; 
            color: #7f1d1d; 
            padding: 1rem; 
            border-radius: 0.5rem; 
            margin-bottom: 1rem; 
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-500 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Hubungi Kami</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Punya pertanyaan atau masukan? Kami senang mendengar dari Anda. 
                Kirim pesan dan kami akan merespons secepatnya.
            </p>
        </div>
    </section>

    <!-- Contact Form & Info Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <!-- Alert Message -->
            <div id="formAlert" class="hidden"></div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Contact Information -->
                <div class="lg:col-span-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-lg mr-4">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Alamat</h3>
                                <p class="text-gray-600 mt-1">Jl. Contoh No. 123, Kota Bandung, Jawa Barat 40123</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-green-100 text-green-600 p-3 rounded-lg mr-4">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Telepon</h3>
                                <p class="text-gray-600 mt-1">+62 123 4567 8900</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-purple-100 text-purple-600 p-3 rounded-lg mr-4">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Email</h3>
                                <p class="text-gray-600 mt-1">hello@simpleapp.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-lg mr-4">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Jam Operasional</h3>
                                <p class="text-gray-600 mt-1">Senin - Jumat: 09:00 - 17:00 WIB</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h3 class="font-semibold text-gray-800 mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-gray-100 text-gray-600 p-3 rounded-lg hover:bg-blue-500 hover:text-white transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="bg-gray-100 text-gray-600 p-3 rounded-lg hover:bg-blue-400 hover:text-white transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="bg-gray-100 text-gray-600 p-3 rounded-lg hover:bg-pink-500 hover:text-white transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="bg-gray-100 text-gray-600 p-3 rounded-lg hover:bg-gray-800 hover:text-white transition-colors">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-xl p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
                        <p class="text-gray-600 mb-8">Isi form di bawah ini dan kami akan merespons pesan Anda dalam 1-2 hari kerja.</p>
                        
                        <form id="contactForm" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap *</label>
                                    <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:border-blue-500" placeholder="Masukkan nama lengkap Anda" required>
                                    <div class="text-red-500 text-sm mt-1 hidden" id="nameError"></div>
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-700 font-medium mb-2">Alamat Email *</label>
                                    <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:border-blue-500" placeholder="nama@contoh.com" required>
                                    <div class="text-red-500 text-sm mt-1 hidden" id="emailError"></div>
                                </div>
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-gray-700 font-medium mb-2">Subjek *</label>
                                <input type="text" id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:border-blue-500" placeholder="Subjek pesan Anda" required>
                                <div class="text-red-500 text-sm mt-1 hidden" id="subjectError"></div>
                            </div>
                            
                            <div>
                                <label for="message" class="block text-gray-700 font-medium mb-2">Pesan *</label>
                                <textarea id="message" name="message" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:outline-none focus:border-blue-500" placeholder="Tulis pesan Anda di sini..." required></textarea>
                                <div class="text-red-500 text-sm mt-1 hidden" id="messageError"></div>
                            </div>
                            
                            <div class="flex items-start">
                                <input type="checkbox" id="consent" name="consent" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1" required>
                                <label for="consent" class="ml-2 text-gray-700 text-sm">
                                    Saya setuju dengan <a href="#" class="text-blue-600 hover:underline">kebijakan privasi</a> 
                                    dan <a href="#" class="text-blue-600 hover:underline">persyaratan layanan</a> *
                                </label>
                            </div>
                            <div class="text-red-500 text-sm mt-1 hidden" id="consentError"></div>
                            
                            <button type="submit" class="bg-blue-500 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg transition-all w-full md:w-auto flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Pertanyaan Umum</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Berikut adalah beberapa pertanyaan yang sering diajukan oleh pengguna</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white rounded-xl p-6 card-hover shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-question-circle text-blue-500 mr-2"></i>
                        Bagaimana cara menggunakan aplikasi ini?
                    </h3>
                    <p class="text-gray-600">Aplikasi ini sangat mudah digunakan. Cukup buat akun, lalu Anda dapat mulai membuat catatan dan mengirim pesan melalui halaman kontak.</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 card-hover shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-question-circle text-blue-500 mr-2"></i>
                        Apakah aplikasi ini gratis?
                    </h3>
                    <p class="text-gray-600">Ya, aplikasi ini sepenuhnya gratis untuk digunakan. Kami berkomitmen untuk menyediakan alat yang berguna tanpa biaya.</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 card-hover shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-question-circle text-blue-500 mr-2"></i>
                        Bagaimana jika saya lupa password?
                    </h3>
                    <p class="text-gray-600">Anda dapat menggunakan fitur "Lupa Password" di halaman login. Sistem akan mengirimkan link reset password ke email Anda.</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 card-hover shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-question-circle text-blue-500 mr-2"></i>
                        Apakah data saya aman?
                    </h3>
                    <p class="text-gray-600">Kami sangat serius dengan keamanan data pengguna. Semua data dienkripsi dan dilindungi dengan protokol keamanan terkini.</p>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <p class="text-gray-600">Tidak menemukan jawaban yang Anda cari?</p>
                <a href="#" class="inline-block mt-2 text-blue-600 font-semibold hover:underline">
                    Lihat dokumentasi lengkap <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('contactForm');
            const formAlert = document.getElementById('formAlert');
            
            // Fungsi untuk menampilkan pesan error
            function showError(field, message) {
                const errorElement = document.getElementById(field + 'Error');
                const inputElement = document.getElementById(field);
                
                if (errorElement && inputElement) {
                    errorElement.textContent = message;
                    errorElement.classList.remove('hidden');
                    inputElement.classList.add('border-red-500');
                }
            }
            
            // Fungsi untuk menghapus pesan error
            function clearErrors() {
                const errorElements = document.querySelectorAll('[id$="Error"]');
                const inputElements = document.querySelectorAll('.form-input');
                
                errorElements.forEach(element => {
                    element.classList.add('hidden');
                    element.textContent = '';
                });
                
                inputElements.forEach(element => {
                    element.classList.remove('border-red-500');
                });
                
                formAlert.classList.add('hidden');
            }
            
            // Fungsi untuk menampilkan alert
            function showAlert(message, type) {
                formAlert.textContent = message;
                formAlert.className = type === 'success' ? 'form-success' : 'form-error';
                formAlert.classList.remove('hidden');
                
                // Scroll ke alert
                formAlert.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                clearErrors();

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                // Disable submit button dan tampilkan loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...';
                submitBtn.classList.add('opacity-70');

                const formData = new FormData(form);

                try {
                    const response = await fetch('/contact', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Success
                        showAlert('Pesan berhasil dikirim! Kami akan merespons dalam 1-2 hari kerja.', 'success');
                        form.reset();
                    } else {
                        // Validation errors
                        if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                showError(field, data.errors[field][0]);
                            });
                            showAlert('Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.', 'error');
                        } else {
                            showAlert(data.message || 'Terjadi kesalahan saat mengirim pesan.', 'error');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
                } finally {
                    // Reset submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    submitBtn.classList.remove('opacity-70');
                }
            });

            // Clear errors when user starts typing
            const inputs = form.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const field = this.name;
                    const errorElement = document.getElementById(field + 'Error');
                    
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                        this.classList.remove('border-red-500');
                    }
                });
            });
        });
    </script>
@endsection