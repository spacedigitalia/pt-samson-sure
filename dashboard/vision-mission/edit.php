<?php

/**
 * Edit Visi/Misi
 */

session_start();

// Hanya admin yang bisa mengakses
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../../login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/VisiMisiController.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$controller = new VisiMisiController($db);

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    $_SESSION['error'] = 'ID tidak valid.';
    header('Location: index.php');
    exit;
}

// Ambil data yang ada
$item = $controller->getById((int)$id);
if (!$item) {
    $_SESSION['error'] = 'Data tidak ditemukan.';
    header('Location: index.php');
    exit;
}

$pageTitle = 'Edit ' . ($item['type'] === 'vision' ? 'Visi' : 'Misi');

require_once __DIR__ . '/../header.php';

$active = 'vision-mission';

$breadcrumbs = [
    ['label' => 'Dashboard', 'href' => '../index.php'],
    ['label' => 'Visi & Misi', 'href' => 'index.php'],
    ['label' => $pageTitle, 'href' => ''],
];

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

            <a href="index.php"
                class="flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-all">
                <i class='bx bx-arrow-back text-lg'></i>
                <span class="hidden sm:inline">Kembali ke Visi & Misi</span>
                <span class="sm:hidden">Kembali</span>
            </a>
        </div>

        <!-- Content -->
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-800"><?= htmlspecialchars($pageTitle) ?></h2>
                <p class="text-sm text-slate-500">Perbarui data <?= $item['type'] === 'vision' ? 'visi' : 'misi' ?> di
                    bawah</p>
            </div>

            <form action="process.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar (Unggah Baru)</label>
                    <?php if ($item['image']): ?>
                        <div class="mb-3 flex items-center gap-3 p-2 border border-slate-100 rounded-xl bg-slate-50">
                            <img src="../../<?php echo htmlspecialchars($item['image']); ?>"
                                class="w-12 h-12 rounded-lg object-cover shadow-sm border border-white"
                                onerror="this.src='https://via.placeholder.com/50?text=Error'">
                            <div class="text-[10px] text-slate-500 truncate">
                                Gambar saat ini: <?php echo basename($item['image']); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" accept="image/*"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                    <p class="mt-1 text-[10px] text-slate-500 italic">Biarkan kosong untuk mempertahankan gambar saat
                        ini</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="6" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"><?php echo htmlspecialchars($item['description']); ?></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="/dashboard/vision-mission"
                        class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                        <i class='bx bx-x mr-1'></i> Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <i class='bx bx-save mr-1'></i> Simpan Perubahan
                    </button>
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