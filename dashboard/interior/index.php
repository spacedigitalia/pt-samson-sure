<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/InteriorController.php';

$active = 'interior';
$breadcrumbs = [
    ['label' => 'Interior', 'href' => '/dashboard/interior'],
];

$controller = new InteriorController($db);
$interiorList = $controller->getAll();
?>
<section class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <div class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4">
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 right-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 border border-amber-100/50 shadow-lg">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-amber-200/20 to-orange-200/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-yellow-200/20 to-amber-200/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
            </div>

            <div class="relative px-6 md:px-8 py-6 md:py-8">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between gap-4 md:gap-6">
                    <div class="flex items-start gap-4 flex-1">
                        <div
                            class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg flex items-center justify-center transform transition-transform hover:scale-105 hidden md:flex">
                            <i class='bx bx-building text-2xl md:text-3xl text-white'></i>
                        </div>

                        <div class="flex flex-col flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mb-2">
                                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 tracking-tight">
                                    Interior
                                </h1>
                                <span
                                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                    <i class='bx bx-check-circle text-sm'></i>
                                    Galeri
                                </span>
                            </div>
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl">
                                Kelola galeri gambar interior perusahaan. Upload, edit, dan hapus gambar interior.
                            </p>

                            <?php if (count($interiorList) > 0): ?>
                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-3 pt-3 border-t border-amber-100/50">
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class='bx bx-images text-amber-500'></i>
                                        <span class="font-medium"><?php echo count($interiorList); ?> gambar</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex-shrink-0">
                        <a href="/dashboard/interior/create.php"
                            class="group flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-amber-600 to-orange-600 px-5 py-3 text-sm font-semibold text-white hover:from-amber-700 hover:to-orange-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class='bx bx-plus text-lg group-hover:rotate-90 transition-transform duration-300'></i>
                            <span class="hidden sm:inline">Tambah Gambar</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if (count($interiorList) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <?php foreach ($interiorList as $item): ?>
                    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="aspect-video bg-slate-100">
                            <?php if (!empty($item['image'])): ?>
                                <img src="../../<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="Interior"
                                    class="w-full h-full object-cover"
                                    onerror="this.src='https://via.placeholder.com/800x450?text=Image+Not+Found'">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <i class='bx bx-image text-5xl'></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs text-slate-500">
                                    <?php echo date('d M Y', strtotime($item['created_at'])); ?>
                                </span>
                                <div class="flex items-center gap-2">
                                    <a href="/dashboard/interior/edit.php?id=<?php echo (int)$item['id']; ?>"
                                        class="inline-flex items-center gap-1 rounded-xl bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                        <i class='bx bx-edit'></i>
                                        Edit
                                    </a>
                                    <form action="process.php" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus gambar interior ini?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>">
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 rounded-xl bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">
                                            <i class='bx bx-trash'></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <i class='bx bx-user text-slate-400'></i>
                                <span><?php echo htmlspecialchars($item['fullname'] ?? 'Unknown'); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-12 text-center">
                <i class='bx bx-building-house text-6xl text-slate-300 mb-4 block'></i>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Gambar Interior</h3>
                <p class="text-sm text-slate-500 mb-4">
                    Klik "Tambah Gambar" untuk mengupload gambar interior pertama.
                </p>
                <a href="/dashboard/interior/create.php"
                    class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition-all">
                    <i class='bx bx-upload text-lg'></i>
                    Tambah Gambar
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
</body>

</html>