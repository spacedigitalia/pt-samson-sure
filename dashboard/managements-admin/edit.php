<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/AccountManagementController.php';
require_once __DIR__ . '/../header.php';

$active = 'managements-admin';
$breadcrumbs = [
    ['label' => 'Management Admins', 'href' => '/dashboard/managements-admin'],
    ['label' => 'Edit akun', 'href' => '#'],
];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id < 1) {
    header('Location: /dashboard/managements-admin');
    exit;
}

$controller = new AccountManagementController($db);
$account = $controller->getById($id);
if (!$account) {
    $_SESSION['error'] = 'Akun tidak ditemukan.';
    header('Location: /dashboard/managements-admin');
    exit;
}
?>
<div class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <main class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4 pb-4">
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 right-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <div class="flex items-center justify-between mt-6 flex-wrap gap-3">
            <?php echo renderBreadcrumb($breadcrumbs); ?>
            <a href="/dashboard/managements-admin"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-200">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm max-w-2xl">
            <h2 class="text-lg font-bold text-slate-900 mb-2">Edit akun</h2>
            <p class="text-sm text-slate-500 mb-6"><?php echo htmlspecialchars($account['email']); ?></p>

            <form action="/dashboard/managements-admin/process.php" method="POST" class="space-y-5">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo (int)$account['id']; ?>">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama lengkap</label>
                    <input type="text" name="fullname" required minlength="2" maxlength="120"
                        value="<?php echo htmlspecialchars($account['fullname']); ?>"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        title="2–120 karakter; huruf, spasi, titik, apostrof, atau tanda hubung">
                    <p class="mt-1 text-xs text-slate-500">2–120 karakter; huruf (termasuk aksara daerah), spasi, serta . &apos; -. Nama tidak boleh sama dengan akun lain (tidak membedakan huruf besar/kecil).</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" required
                        value="<?php echo htmlspecialchars($account['email']); ?>"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Role</label>
                    <select name="role"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                        <option value="admin" <?php echo ($account['role'] === 'admin') ? 'selected' : ''; ?>>admin
                        </option>
                    </select>
                </div>

                <div class="rounded-xl bg-slate-50 border border-slate-100 p-4 space-y-4">
                    <p class="text-xs font-semibold text-slate-600 uppercase tracking-wide">Password (opsional)</p>
                    <p class="text-xs text-slate-500">Kosongkan jika tidak ingin mengubah password.</p>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Password baru</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password" autocomplete="new-password"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Minimal 6 karakter jika diisi">
                            <button type="button"
                                class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                                aria-label="Tampilkan password baru" data-label-show="Tampilkan password baru"
                                data-label-hide="Sembunyikan password baru">
                                <i class='bx bx-show text-xl icon-show'></i>
                                <i class='bx bx-hide text-xl icon-hide hidden'></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi password baru</label>
                        <div class="relative">
                            <input type="password" name="confirm_new_password" id="confirm_new_password"
                                autocomplete="new-password"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Ulangi password baru">
                            <button type="button"
                                class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                                aria-label="Tampilkan konfirmasi" data-label-show="Tampilkan konfirmasi"
                                data-label-hide="Sembunyikan konfirmasi">
                                <i class='bx bx-show text-xl icon-show'></i>
                                <i class='bx bx-hide text-xl icon-hide hidden'></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan perubahan
                    </button>
                    <a href="/dashboard/managements-admin"
                        class="rounded-xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-200">Batal</a>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('lg:translate-x-0');
    }

    document.querySelectorAll('.password-toggle').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var wrap = btn.closest('.relative');
            var input = wrap ? wrap.querySelector('input') : null;
            if (!input) return;
            var showIcon = btn.querySelector('.icon-show');
            var hideIcon = btn.querySelector('.icon-hide');
            var ls = btn.getAttribute('data-label-show') || 'Tampilkan password';
            var lh = btn.getAttribute('data-label-hide') || 'Sembunyikan password';
            if (input.type === 'password') {
                input.type = 'text';
                showIcon && showIcon.classList.add('hidden');
                hideIcon && hideIcon.classList.remove('hidden');
                btn.setAttribute('aria-label', lh);
            } else {
                input.type = 'password';
                showIcon && showIcon.classList.remove('hidden');
                hideIcon && hideIcon.classList.add('hidden');
                btn.setAttribute('aria-label', ls);
            }
        });
    });
</script>
</body>

</html>