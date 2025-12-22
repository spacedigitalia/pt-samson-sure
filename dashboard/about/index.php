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
require_once __DIR__ . '/../../controllers/AboutController.php';

$active = 'about';
$breadcrumbs = [
    ['label' => 'About', 'href' => 'about'],
];

$controller = new AboutController($db);

// Handle actions
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;
$editData = null;

if ($action === 'edit' && $id) {
    $editData = $controller->getById((int)$id);
}

// Get single home data (first one)
$aboutData = $controller->getFirst();
?>
<section class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <div class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4">
        <!-- Hamburger button fixed on mobile -->
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 right-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <!-- About Header -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50 border border-teal-100/50 shadow-lg">
            <!-- Decorative background elements -->
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-teal-200/20 to-blue-200/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-cyan-200/20 to-teal-200/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
            </div>

            <div class="relative px-6 md:px-8 py-6 md:py-8">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between gap-4 md:gap-6">
                    <div class="flex items-start gap-4 flex-1">
                        <!-- Icon Container -->
                        <div
                            class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 shadow-lg flex items-center justify-center transform transition-transform hover:scale-105 hidden md:flex">
                            <i class='bx bx-info-circle text-2xl md:text-3xl text-white'></i>
                        </div>

                        <!-- Title and Description -->
                        <div class="flex flex-col flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <h1 class="text-2xl md:text-4xl font-bold text-slate-900 tracking-tight">About
                                    Management</h1>
                                <span
                                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-100 text-teal-700 text-xs font-semibold">
                                    <i class='bx bx-check-circle text-sm'></i>
                                    Active
                                </span>
                            </div>
                            <p class="text-sm md:text-base text-slate-600 leading-relaxed max-w-2xl">
                                Kelola konten halaman about Buat, edit, dan hapus informasi
                                tentang perusahaan.
                            </p>

                            <!-- Stats (if aboutData exists) -->
                            <?php if ($aboutData): ?>
                            <div class="flex items-center gap-4 mt-3 pt-3 border-t border-teal-100/50">
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <i class='bx bx-check text-teal-500'></i>
                                    <span class="font-medium">Content Available</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <i class='bx bx-time text-cyan-500'></i>
                                    <span>Last updated:
                                        <?php echo date('M d, Y', strtotime($aboutData['updated_at'] ?? $aboutData['created_at'])); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <?php if (!$aboutData): ?>
                    <div class="flex-shrink-0">
                        <a href="/dashboard/about/create.php"
                            class="group flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-teal-600 to-cyan-600 px-5 py-3 text-sm font-semibold text-white hover:from-teal-700 hover:to-cyan-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class='bx bx-plus text-lg group-hover:rotate-90 transition-transform duration-300'></i>
                            <span class="hidden sm:inline">Add New Content</span>
                            <span class="sm:hidden">Add</span>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Content Preview (Card Style) -->
        <?php if ($aboutData): ?>
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-900">About Content Preview</h2>
                    <a href="/dashboard/about/edit.php?id=<?php echo $aboutData['id']; ?>"
                        class="inline-flex items-center gap-1 rounded-xl bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-200">
                        <i class='bx bx-edit'></i>
                        Edit Content
                    </a>
                </div>

                <?php if ($aboutData['image']): ?>
                <div class="mb-4 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
                    <img src="../../<?php echo htmlspecialchars($aboutData['image']); ?>" alt="About Image"
                        class="w-full h-48 md:h-80 object-cover"
                        onerror="this.src='https://via.placeholder.com/800x400?text=Image+Not+Found'">
                </div>
                <?php endif; ?>

                <div class="space-y-4">
                    <?php if (!empty($aboutData['text'])): ?>
                    <div class="pt-4 border-t border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Text Content</h3>
                        <p class="text-sm text-slate-700 leading-relaxed">
                            <?php echo htmlspecialchars($aboutData['text']); ?>
                        </p>
                    </div>
                    <?php endif; ?>

                    <?php
                        $items = $aboutData['items'] ?? [];
                        if (!empty($items)):
                        ?>
                    <div class="space-y-4">
                        <?php foreach ($items as $index => $item): ?>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-lg md:text-xl font-semibold text-slate-900 mb-2">
                                <?php echo htmlspecialchars($item['title'] ?? ''); ?>
                            </h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                <?php echo htmlspecialchars($item['description'] ?? ''); ?>
                            </p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-8 text-slate-500">
                        <p>Belum ada items yang ditambahkan.</p>
                    </div>
                    <?php endif; ?>

                    <div
                        class="flex flex-wrap items-center gap-4 pt-4 border-t border-slate-200 text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-user text-slate-400'></i>
                            <span>Created by:
                                <strong><?php echo htmlspecialchars($aboutData['fullname'] ?? 'Unknown'); ?></strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class='bx bx-calendar text-slate-400'></i>
                            <span><?php echo date('M d, Y', strtotime($aboutData['created_at'])); ?></span>
                        </div>
                        <?php if ($aboutData['updated_at'] !== $aboutData['created_at']): ?>
                        <div class="flex items-center gap-2">
                            <i class='bx bx-time text-slate-400'></i>
                            <span>Updated: <?php echo date('M d, Y', strtotime($aboutData['updated_at'])); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-12 text-center">
            <i class='bx bx-inbox text-6xl text-slate-300 mb-4 block'></i>
            <h3 class="text-lg font-semibold text-slate-700 mb-2">No Content Available</h3>
            <p class="text-sm text-slate-500 mb-4">
                Belum ada konten about. Klik "Add New" untuk membuat konten pertama.
            </p>
            <a href="/dashboard/about/create.php"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition-all">
                <i class='bx bx-plus text-lg'></i>
                Create First Content
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
</body>

</html>