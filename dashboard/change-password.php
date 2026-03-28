<?php
session_start();

// protect
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$auth = new AuthController($db);
$user = $_SESSION['user'];
$active = 'change-password';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $res = $auth->changePassword((int)$user['id'], $currentPassword, $newPassword, $confirmPassword);
    if ($res['success']) {
        // Simpan pesan sukses
        $_SESSION['success'] = $res['message'];
        // Langsung redirect ke halaman login setelah 3 detik
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Redirecting...</title>
            <meta http-equiv='refresh' content='3;url=../logout.php'>
            <link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap' rel='stylesheet'>
            <style>
                body {
                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    background-color: #f8fafc;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    color: #1e293b;
                }
                .redirect-container {
                    text-align: center;
                    background: white;
                    padding: 2.5rem;
                    border-radius: 1rem;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                    max-width: 400px;
                    width: 90%;
                    margin: 0 auto;
                }
                .spinner {
                    width: 50px;
                    height: 50px;
                    border: 4px solid #e2e8f0;
                    border-top: 4px solid #3b82f6;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                    margin: 0 auto 1.5rem;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                h1 {
                    font-size: 1.5rem;
                    font-weight: 600;
                    margin-bottom: 0.5rem;
                    color: #1e293b;
                }
                p {
                    color: #64748b;
                    margin-bottom: 1.5rem;
                    line-height: 1.5;
                }
                .countdown {
                    font-size: 0.875rem;
                    color: #64748b;
                    margin-top: 1rem;
                }
            </style>
        </head>
        <body>
            <div class='redirect-container'>
                <div class='spinner'></div>
                <h1>Password Berhasil Diubah!</h1>
                <p>Anda akan dialihkan ke halaman login dalam <span id='countdown'>3</span> detik...</p>
                <div class='countdown'>Harap login kembali dengan password baru Anda</div>
            </div>
            <script>
                // Countdown timer
                let seconds = 3;
                const countdownElement = document.getElementById('countdown');
                
                const countdown = setInterval(function() {
                    seconds--;
                    countdownElement.textContent = seconds; 
                    
                    if (seconds <= 0) {
                        clearInterval(countdown);
                        window.location.href = '../logout.php';
                    }
                }, 1000);
            </script>
        </body>
        </html>";
        exit;
    } else {
        $_SESSION['error'] = $res['message'];
        header('Location: change-password.php');
        exit;
    }
}

// GET -> render form
?>
<div class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <main class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-6 pb-4">
        <!-- Hamburger button fixed on mobile -->
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 right-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <!-- Page Header -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border border-blue-100/50 shadow-lg mt-6">
            <!-- Decorative background elements -->
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-200/20 to-purple-200/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-indigo-200/20 to-blue-200/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
            </div>

            <div class="relative px-6 md:px-8 py-6">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                        <i class='bx bx-lock-alt text-2xl text-white'></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Ubah Password</h1>
                        <p class="text-sm text-slate-600">Perbarui password akun Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="p-6">
                <form method="POST" action="change-password.php" class="space-y-5 max-w-2xl">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700">Password Saat Ini</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password"
                                class="block w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Masukkan password saat ini" required autocomplete="current-password" />
                            <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none focus:text-blue-600"
                                aria-label="Tampilkan password saat ini" data-label-show="Tampilkan password saat ini" data-label-hide="Sembunyikan password saat ini">
                                <i class='bx bx-show text-xl icon-show' aria-hidden="true"></i>
                                <i class='bx bx-hide text-xl icon-hide hidden' aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password"
                                class="block w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Masukkan password baru" required autocomplete="new-password" />
                            <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none focus:text-blue-600"
                                aria-label="Tampilkan password baru" data-label-show="Tampilkan password baru" data-label-hide="Sembunyikan password baru">
                                <i class='bx bx-show text-xl icon-show' aria-hidden="true"></i>
                                <i class='bx bx-hide text-xl icon-hide hidden' aria-hidden="true"></i>
                            </button>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Minimal 8 karakter, kombinasi huruf dan angka</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="block w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Konfirmasi password baru" required autocomplete="new-password" />
                            <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none focus:text-blue-600"
                                aria-label="Tampilkan konfirmasi password" data-label-show="Tampilkan konfirmasi password" data-label-hide="Sembunyikan konfirmasi password">
                                <i class='bx bx-show text-xl icon-show' aria-hidden="true"></i>
                                <i class='bx bx-hide text-xl icon-hide hidden' aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                        <a href="/dashboard/profile"
                            class="px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
// Initialize toastr
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    timeOut: 5000
};

// Show success message if exists
<?php if (isset($_SESSION['success'])): ?>
toastr.success('<?php echo addslashes($_SESSION['success']); ?>');
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

// Show error message if exists
<?php if (isset($_SESSION['error'])): ?>
toastr.error('<?php echo addslashes($_SESSION['error']); ?>');
<?php unset($_SESSION['error']); ?>
<?php endif; ?>
</script>

<script>
document.querySelectorAll('.password-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var wrap = btn.closest('.relative');
        var input = wrap ? wrap.querySelector('input') : null;
        if (!input || !input.name) return;
        var showIcon = btn.querySelector('.icon-show');
        var hideIcon = btn.querySelector('.icon-hide');
        var labelShow = btn.getAttribute('data-label-show') || 'Tampilkan password';
        var labelHide = btn.getAttribute('data-label-hide') || 'Sembunyikan password';
        if (input.type === 'password') {
            input.type = 'text';
            if (showIcon) showIcon.classList.add('hidden');
            if (hideIcon) hideIcon.classList.remove('hidden');
            btn.setAttribute('aria-label', labelHide);
        } else {
            input.type = 'password';
            if (showIcon) showIcon.classList.remove('hidden');
            if (hideIcon) hideIcon.classList.add('hidden');
            btn.setAttribute('aria-label', labelShow);
        }
    });
});
</script>

<!-- Sidebar Toggle -->
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
    sidebar.classList.toggle('lg:translate-x-0');
}
</script>