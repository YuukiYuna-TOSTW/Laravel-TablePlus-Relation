<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AboutController;

// Halaman utama
Route::get('/', function () {
    return view('home');
});

// Static pages
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/contact', function () { return view('contact'); })->name('contact');

// Handle contact form submission - sends messages to admin message system
Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:200',
        'subject' => 'required|string|max:200',
        'message' => 'required|string|max:2000',
    ]);

    $messages = $request->session()->get('messages', []);
    $messages[] = [
        'name' => $validated['name'],
        'email' => $validated['email'],
        'subject' => $validated['subject'],
        'message' => $validated['message'],
        'time' => now()->toDateTimeString(),
        'read' => false,
        'image' => null,
        'source' => 'contact_form', // untuk membedakan sumber pesan
    ];
    $request->session()->put('messages', $messages);

    return response()->json(['status' => 'ok', 'message' => 'Pesan berhasil dikirim!']);
})->name('contact.send');

// Note: contact form messages are stored in the same session as /messages/send

// Accept messages from the /messages page and store to session
Route::post('/messages/send', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'message' => 'required|string|max:2000',
        'email' => 'nullable|email|max:200',
        'subject' => 'nullable|string|max:200',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $messages = $request->session()->get('messages', []);
    $imageUrl = null;
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $path = $request->file('image')->store('public/messages');
        $imageUrl = Storage::url($path);
    }
    $messages[] = [
        'name' => $validated['name'],
        'message' => $validated['message'],
        'email' => $validated['email'] ?? null,
        'subject' => $validated['subject'] ?? null,
        'time' => now()->toDateTimeString(),
        'read' => false,
        'image' => $imageUrl,
    ];
    $request->session()->put('messages', $messages);

    return response()->json(['status' => 'ok', 'messages' => $messages]);
})->name('messages.send');

Route::get('/messages', function (Request $request) {
    if (!$request->session()->get('is_admin')) {
        return redirect('/admin/login');
    }
    $messages = $request->session()->get('messages', []);
    return view('message', ['messages' => $messages]);
})->name('messages.index');

Route::delete('/messages/{index}', function (Request $request, $index) {
    if (!$request->session()->get('is_admin')) {
        return response()->json(['status' => 'unauthorized'], 401);
    }
    $messages = $request->session()->get('messages', []);
    if (isset($messages[$index])) {
        array_splice($messages, $index, 1);
        $request->session()->put('messages', $messages);
        return response()->json(['status' => 'deleted', 'messages' => $messages]);
    }
    return response()->json(['status' => 'not_found'], 404);
})->name('messages.delete');

Route::put('/messages/{index}', function (Request $request, $index) {
    if (!$request->session()->get('is_admin')) {
        return response()->json(['status' => 'unauthorized'], 401);
    }
    $messages = $request->session()->get('messages', []);
    if (!isset($messages[$index])) {
        return response()->json(['status' => 'not_found'], 404);
    }
    $messages[$index] = [
        'name' => $request->input('name', $messages[$index]['name']),
        'message' => $request->input('message', $messages[$index]['message']),
        'time' => now()->toDateTimeString(),
        'read' => $messages[$index]['read'] ?? false,
    ];
    $request->session()->put('messages', $messages);
    return response()->json(['status' => 'updated', 'messages' => $messages]);
})->name('messages.update');

// Mark a message as read - Admin only
Route::put('/messages/{index}/read', function (Request $request, $index) {
    if (!$request->session()->get('is_admin')) {
        return response()->json(['status' => 'unauthorized'], 401);
    }
    $messages = $request->session()->get('messages', []);
    if (!isset($messages[$index])) {
        return response()->json(['status' => 'not_found'], 404);
    }
    $messages[$index]['read'] = true;
    $request->session()->put('messages', $messages);
    return response()->json(['status' => 'marked_read', 'messages' => $messages]);
})->name('messages.markRead');

// Halaman Notes

Route::get('/notes', function (Request $request) {
    $notes = $request->session()->get('notes', []);
    return view('notes', ['serverNotes' => $notes]);
});

// Simpan note ke session (tanpa database)
Route::post('/notes', function (Request $request) {
    $notes = $request->session()->get('notes', []);
    $new = $request->input('note');
    if ($new) {
        $notes[] = $new;
        $request->session()->put('notes', $notes);
    }
    return response()->json(['status' => 'ok', 'notes' => $notes]);
});

// Hapus note berdasarkan index
Route::delete('/notes/{index}', function (Request $request, $index) {
    $notes = $request->session()->get('notes', []);
    if (isset($notes[$index])) {
        array_splice($notes, $index, 1);
        $request->session()->put('notes', $notes);
        return response()->json(['status' => 'deleted', 'notes' => $notes]);
    }
    return response()->json(['status' => 'not_found'], 404);
});

// API endpoint untuk mendapatkan data pesan terbaru (Admin only) - untuk real-time updates
Route::get('/api/messages/stats', function (Request $request) {
    if (!$request->session()->get('is_admin')) {
        return response()->json(['status' => 'unauthorized'], 401);
    }
    
    $messages = $request->session()->get('messages', []);
    $total = count($messages);
    $unread = 0;
    $fromContact = 0;
    $fromMessage = 0;
    
    foreach ($messages as $m) {
        if (empty($m['read'])) $unread++;
        
        $source = $m['source'] ?? 'message_page';
        if ($source === 'contact_form') {
            $fromContact++;
        } else {
            $fromMessage++;
        }
    }
    
    return response()->json([
        'status' => 'ok',
        'stats' => [
            'total' => $total,
            'unread' => $unread,
            'fromContact' => $fromContact,
            'fromMessage' => $fromMessage
        ],
        'recentMessages' => array_slice(array_reverse($messages), 0, 10) // 10 pesan terbaru
    ]);
});

// API endpoint untuk mendapatkan semua pesan (Admin only) - untuk halaman message
Route::get('/api/messages/all', function (Request $request) {
    if (!$request->session()->get('is_admin')) {
        return response()->json(['status' => 'unauthorized'], 401);
    }
    
    $messages = $request->session()->get('messages', []);
    $total = count($messages);
    $unread = 0;
    
    foreach ($messages as $m) {
        if (empty($m['read'])) $unread++;
    }
    
    return response()->json([
        'status' => 'ok',
        'messages' => $messages,
        'stats' => [
            'total' => $total,
            'unread' => $unread
        ]
    ]);
});

// Tampilkan halaman review pesan (akses dari navbar) - Admin only
Route::get('/messagesreview', function (Request $request) {
    if (!$request->session()->get('is_admin')) {
        return redirect('/admin/login');
    }
    $messages = $request->session()->get('messages', []);
    return view('messagesreview', ['messages' => $messages]);
});

// Admin dashboard - Admin only
Route::get('/admin', function (Request $request) {
    if (!$request->session()->get('is_admin')) {
        return redirect('/admin/login');
    }
    $messages = $request->session()->get('messages', []);
    return view('admin.index', ['messages' => $messages]);
})->name('admin.index');

// Admin auth: simple password-based session login (uses ADMIN_PASSWORD in .env)
Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::post('/admin/login', function (Request $request) {
    $pw = $request->input('password');
    $adminPw = env('ADMIN_PASSWORD', 'admin');
    if ($pw && hash_equals((string)$adminPw, (string)$pw)) {
        $request->session()->put('is_admin', true);
        return redirect('/admin');
    }
    return back()->withErrors(['password' => 'Password salah'])->withInput();
});

Route::post('/admin/logout', function (Request $request) {
    $request->session()->forget('is_admin');
    return redirect('/');
});


Route::get('/blog', [BlogController::class, 'index']);

