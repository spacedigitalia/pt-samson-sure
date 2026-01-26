<?php
session_start();

// Proteksi halaman: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/StrukturOrganisasiController.php';

$active = 'struktur-organisasi';
$breadcrumbs = [
    ['label' => 'Struktur Organisasi', 'href' => 'struktur-organisasi'],
];

$controller = new StrukturOrganisasiController($db);

// Handle actions
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;
$editData = null;

if ($action === 'edit' && $id) {
    $editData = $controller->getById((int)$id);
}

// Get single struktur organisasi data (first one)
$strukturData = $controller->getFirst();
?>
<section class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <div class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4">
        <!-- Hamburger button fixed on mobile -->
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 right-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <!-- Struktur Organisasi Header -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border border-blue-100/50 shadow-lg">
            <!-- Decorative background elements -->
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-200/20 to-indigo-200/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-purple-200/20 to-blue-200/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
            </div>

            <div class="relative px-6 md:px-8 py-6 md:py-8">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between gap-4 md:gap-6">
                    <div class="flex items-start gap-4 flex-1">
                        <!-- Icon Container -->
                        <div
                            class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg flex items-center justify-center transform transition-transform hover:scale-105 hidden md:flex">
                            <i class='bx bx-sitemap text-2xl md:text-3xl text-white'></i>
                        </div>

                        <!-- Title and Description -->
                        <div class="flex flex-col flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mb-2">
                                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 tracking-tight">
                                    Struktur Organisasi
                                </h1>
                                <span
                                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    <i class='bx bx-check-circle text-sm'></i>
                                    Active
                                </span>
                            </div>
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl">
                                Kelola gambar struktur organisasi perusahaan. Upload, edit, dan hapus gambar struktur organisasi.
                            </p>

                            <!-- Stats (if strukturData exists) -->
                            <?php if ($strukturData): ?>
                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-3 pt-3 border-t border-blue-100/50">
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class='bx bx-check text-blue-500'></i>
                                        <span class="font-medium">Image Available</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class='bx bx-time text-indigo-500'></i>
                                        <span>Last updated:
                                            <?php echo date('M d, Y', strtotime($strukturData['updated_at'] ?? $strukturData['created_at'])); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <?php if (!$strukturData): ?>
                        <div class="flex-shrink-0">
                            <a href="/dashboard/struktur-organisasi/create.php"
                                class="group flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class='bx bx-plus text-lg group-hover:rotate-90 transition-transform duration-300'></i>
                                <span class="hidden sm:inline">Upload Image</span>
                                <span class="sm:hidden">Upload</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Content Preview (Card Style) -->
        <?php if ($strukturData): ?>
            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-900">Struktur Organisasi Image</h2>
                        <div class="flex items-center gap-2">
                            <a href="/dashboard/struktur-organisasi/edit.php?id=<?php echo $strukturData['id']; ?>"
                                class="inline-flex items-center gap-1 rounded-xl bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-200">
                                <i class='bx bx-edit'></i>
                                Edit Image
                            </a>
                            <form action="process.php" method="POST" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar struktur organisasi ini?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $strukturData['id']; ?>">
                                <button type="submit"
                                    class="inline-flex items-center gap-1 rounded-xl bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">
                                    <i class='bx bx-trash'></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <?php if ($strukturData['image']): ?>
                        <div class="mb-4 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
                            <img src="../../<?php echo htmlspecialchars($strukturData['image']); ?>"
                                alt="Struktur Organisasi"
                                class="w-full h-auto object-contain max-h-[600px] mx-auto"
                                onerror="this.src='https://via.placeholder.com/800x600?text=Image+Not+Found'">
                        </div>
                    <?php endif; ?>

                    <div
                        class="flex flex-wrap items-center gap-4 pt-4 border-t border-slate-200 text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-user text-slate-400'></i>
                            <span>Created by:
                                <strong><?php echo htmlspecialchars($strukturData['fullname'] ?? 'Unknown'); ?></strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class='bx bx-calendar text-slate-400'></i>
                            <span><?php echo date('M d, Y', strtotime($strukturData['created_at'])); ?></span>
                        </div>
                        <?php if ($strukturData['updated_at'] !== $strukturData['created_at']): ?>
                            <div class="flex items-center gap-2">
                                <i class='bx bx-time text-slate-400'></i>
                                <span>Updated: <?php echo date('M d, Y', strtotime($strukturData['updated_at'])); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-12 text-center">
                <i class='bx bx-image text-6xl text-slate-300 mb-4 block'></i>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">No Image Available</h3>
                <p class="text-sm text-slate-500 mb-4">
                    Belum ada gambar struktur organisasi. Klik "Upload Image" untuk mengupload gambar pertama.
                </p>
                <a href="create.php"
                    class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition-all">
                    <i class='bx bx-upload text-lg'></i>
                    Upload First Image
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
</body>

</html>