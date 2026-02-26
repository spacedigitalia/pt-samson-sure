<?php
session_start();

// Proteksi halaman: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/CompanyManagementController.php';
require_once __DIR__ . '/../header.php';

$active = 'company-managements';
$breadcrumbs = [
    ['label' => 'Company Management', 'href' => '/dashboard/company-managements'],
    ['label' => 'Edit Content', 'href' => '#'],
];

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /dashboard/company-managements');
    exit;
}

$controller = new CompanyManagementController($db);
$managementData = $controller->getById((int)$id);

if (!$managementData) {
    $_SESSION['error'] = 'Data tidak ditemukan.';
    header('Location: /dashboard/company-managements');
    exit;
}
?>
<div class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <main class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4 pb-4">
        <!-- Hamburger button fixed on mobile -->
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 left-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <!-- Top bar -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="lg:hidden w-10"></div> <!-- Spacer for fixed button on mobile -->
                <?php echo renderBreadcrumb($breadcrumbs); ?>
            </div>

            <a href="/dashboard/company-managements"
                class="flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-all">
                <i class='bx bx-arrow-back text-lg'></i>
                <span class="hidden sm:inline">Back to Company Management</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>

        <!-- Content -->
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <form action="process.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($managementData['id']); ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Position</label>
                        <input type="text" name="position" required
                            value="<?php echo htmlspecialchars($managementData['position']); ?>"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                        <input type="text" name="status" required
                            value="<?php echo htmlspecialchars($managementData['status']); ?>"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Image (Upload New)</label>
                    <?php if ($managementData['image']): ?>
                    <div class="mb-3 flex items-center gap-3 p-2 border border-slate-100 rounded-xl bg-slate-50">
                        <img src="../../<?php echo htmlspecialchars($managementData['image']); ?>"
                            class="w-12 h-12 rounded-lg object-cover shadow-sm border border-white"
                            onerror="this.src='https://via.placeholder.com/50?text=Error'">
                        <div class="text-[10px] text-slate-500 truncate">
                            Current image: <?php echo basename($managementData['image']); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <input type="file" name="image" accept="image/*"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                    <p class="mt-1 text-[10px] text-slate-500 italic">Leave empty to keep current image</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="6" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"><?php echo htmlspecialchars($managementData['description']); ?></textarea>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="flex-1 md:flex-none rounded-xl bg-slate-900 px-10 py-3.5 text-sm font-semibold text-white hover:bg-slate-800 transition-all shadow-sm">
                        <i class='bx bx-refresh mr-2'></i> Update Content
                    </button>
                    <a href="/dashboard/company-managements"
                        class="flex-1 md:flex-none text-center rounded-xl bg-slate-100 px-10 py-3.5 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="../js/toast.js"></script>
</body>

</html>