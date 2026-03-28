<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/AccountManagementController.php';

$active = 'managements-admin';
$breadcrumbs = [
    ['label' => 'Management Admins', 'href' => '/dashboard/managements-admin'],
];

$controller = new AccountManagementController($db);
$accounts = $controller->getAll();
$currentUserId = (int)($_SESSION['user']['id'] ?? 0);
?>
<div class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <main class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4 pb-4">
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 right-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-50 via-violet-50 to-purple-50 border border-indigo-100/50 shadow-lg mt-6">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-indigo-200/20 to-purple-200/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-violet-200/20 to-indigo-200/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
            </div>

            <div class="relative px-6 md:px-8 py-6 md:py-8">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between gap-4">
                    <div class="flex items-start gap-4 flex-1">
                        <div
                            class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 shadow-lg flex items-center justify-center">
                            <i class='bx bx-user-circle text-3xl text-white'></i>
                        </div>
                        <div class="min-w-0">
                            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Management Admins</h1>
                            <p class="text-sm text-slate-600 mt-1 max-w-2xl">
                                Kelola akun admin: tambah, ubah, atau hapus pengguna yang dapat mengakses dashboard.
                            </p>
                            <?php if (!empty($accounts)): ?>
                            <p class="text-xs text-slate-500 mt-2">
                                <i class='bx bx-list-ul text-indigo-500'></i>
                                <?php echo count($accounts); ?> akun terdaftar
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="/dashboard/managements-admin/create.php"
                        class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-3 text-sm font-semibold text-white hover:from-indigo-700 hover:to-violet-700 shadow-lg transition-all shrink-0">
                        <i class='bx bx-plus text-lg'></i>
                        <span>Tambah akun</span>
                    </a>
                </div>
            </div>
        </div>

        <?php if (empty($accounts)): ?>
        <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-12 text-center">
            <i class='bx bx-user-plus text-5xl text-slate-300'></i>
            <p class="mt-4 text-slate-600 font-medium">Belum ada akun selain yang terdaftar di database.</p>
            <a href="/dashboard/managements-admin/create.php"
                class="inline-flex mt-6 items-center gap-2 text-indigo-600 font-semibold text-sm hover:underline">
                Tambah akun pertama
            </a>
        </div>
        <?php else: ?>
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Nama</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Email</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Role</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Dibuat</th>
                            <th class="px-6 py-3 text-right font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($accounts as $acc): ?>
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                <?php echo htmlspecialchars($acc['fullname']); ?>
                                <?php if ((int)$acc['id'] === $currentUserId): ?>
                                <span class="ml-2 text-[10px] uppercase tracking-wide text-indigo-600 font-semibold">(Anda)</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-slate-600"><?php echo htmlspecialchars($acc['email']); ?></td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    <?php echo htmlspecialchars($acc['role']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <?php echo htmlspecialchars(date('d M Y, H:i', strtotime($acc['created_at']))); ?>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="/dashboard/managements-admin/edit.php?id=<?php echo (int)$acc['id']; ?>"
                                    class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-100">
                                    <i class='bx bx-edit-alt'></i> Edit
                                </a>
                                <?php if ((int)$acc['id'] !== $currentUserId): ?>
                                <form action="/dashboard/managements-admin/process.php" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus akun <?php echo htmlspecialchars(addslashes($acc['email'])); ?>?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo (int)$acc['id']; ?>">
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">
                                        <i class='bx bx-trash'></i> Hapus
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </main>
</div>

<!-- Sidebar Toggle -->
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
    sidebar.classList.toggle('lg:translate-x-0');
}
</script>
</body>

</html>
