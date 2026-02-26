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
require_once __DIR__ . '/../../controllers/DataPerseroanController.php';

$active = 'data-perseroan';
$breadcrumbs = [
    ['label' => 'Data Perseroan', 'href' => 'data-perseroan'],
];

$controller = new DataPerseroanController($db);

// Get first data perseroan (single data)
$dataPerseroan = $controller->getFirst();
?>
<section class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <div class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4">
        <!-- Hamburger button fixed on mobile -->
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 right-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <!-- Data Perseroan Header -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border border-blue-100/50 shadow-lg">
            <!-- Decorative background elements -->
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-200/20 to-purple-200/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-indigo-200/20 to-blue-200/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
            </div>

            <div class="relative px-6 md:px-8 py-6 md:py-8">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between gap-4 md:gap-6">
                    <div class="flex items-start gap-4 flex-1">
                        <!-- Icon Container -->
                        <div
                            class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg flex items-center justify-center transform transition-transform hover:scale-105 hidden md:flex">
                            <i class='bx bx-building text-2xl md:text-3xl text-white'></i>
                        </div>

                        <!-- Title and Description -->
                        <div class="flex flex-col flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <h1 class="text-2xl md:text-4xl font-bold text-slate-900 tracking-tight">Data Perseroan
                                    Management</h1>
                                <span
                                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    <i class='bx bx-check-circle text-sm'></i>
                                    Active
                                </span>
                            </div>
                            <p class="text-sm md:text-base text-slate-600 leading-relaxed max-w-2xl">
                                Kelola data perseroan perusahaan. Buat, edit, dan hapus informasi
                                perseroan yang tersedia.
                            </p>

                            <!-- Stats (if data perseroan exist) -->
                            <?php if (!empty($dataPerseroan)): ?>
                                <div class="flex items-center gap-4 mt-3 pt-3 border-t border-blue-100/50">
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class='bx bx-check-circle text-blue-500'></i>
                                        <span class="font-medium">Data Available</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class='bx bx-time text-indigo-500'></i>
                                        <span>Last updated:
                                            <?php echo date('M d, Y', strtotime($dataPerseroan['created_at'])); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Button (only show if no data exists) -->
                    <?php if (empty($dataPerseroan)): ?>
                        <div class="flex-shrink-0">
                            <a href="/dashboard/data-perseroan/create.php"
                                class="group flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class='bx bx-plus text-lg group-hover:rotate-90 transition-transform duration-300'></i>
                                <span class="hidden sm:inline">Add New Data Perseroan</span>
                                <span class="sm:hidden">Add</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Data Perseroan Detail Card -->
        <?php if (!empty($dataPerseroan)): ?>
            <div class="rounded-3xl border border-slate-200 bg-white shadow-lg overflow-hidden">
                <!-- Image Header -->
                <?php if (!empty($dataPerseroan['image'])): ?>
                    <div class="relative h-64 md:h-80 bg-gradient-to-br from-blue-100 to-indigo-100 overflow-hidden">
                        <img src="../../<?php echo htmlspecialchars($dataPerseroan['image']); ?>"
                            class="w-full h-full object-cover"
                            onerror="this.style.display='none'"
                            alt="Data Perseroan Image">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                <?php endif; ?>

                <!-- Content Section -->
                <div class="p-6 md:p-8 space-y-6">
                    <!-- Header with Actions -->
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 pb-6 border-b border-slate-200">
                        <div class="flex-1">
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-2">
                                <?php echo htmlspecialchars($dataPerseroan['company_name'] ?? 'Data Perseroan'); ?>
                            </h2>
                            <?php if (!empty($dataPerseroan['president_director'])): ?>
                                <p class="text-sm text-slate-600">
                                    <i class='bx bx-user text-blue-500 mr-2'></i>
                                    President Director: <span class="font-semibold"><?php echo htmlspecialchars($dataPerseroan['president_director']); ?></span>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <a href="/dashboard/data-perseroan/edit.php?id=<?php echo $dataPerseroan['id']; ?>"
                                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors shadow-sm">
                                <i class='bx bx-edit'></i>
                                Edit Data
                            </a>
                            <form action="process.php" method="POST" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data perseroan ini?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $dataPerseroan['id']; ?>">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition-colors shadow-sm">
                                    <i class='bx bx-trash'></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Main Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <i class='bx bx-building text-blue-500'></i>
                                Informasi Perusahaan
                            </h3>
                            <div class="space-y-3">
                                <?php if (!empty($dataPerseroan['nib'])): ?>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">NIB</span>
                                        <span class="text-sm text-slate-900"><?php echo htmlspecialchars($dataPerseroan['nib']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($dataPerseroan['npwp'])): ?>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">NPWP</span>
                                        <span class="text-sm text-slate-900"><?php echo htmlspecialchars($dataPerseroan['npwp']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($dataPerseroan['deed_incorporation_number'])): ?>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Nomor Akta Pendirian</span>
                                        <span class="text-sm text-slate-900"><?php echo htmlspecialchars($dataPerseroan['deed_incorporation_number']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($dataPerseroan['investment_status'])): ?>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Status Investasi</span>
                                        <span class="text-sm text-slate-900"><?php echo htmlspecialchars($dataPerseroan['investment_status']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Address & Activities -->
                        <div class="space-y-4">
                            <?php if (!empty($dataPerseroan['address'])): ?>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2 mb-3">
                                        <i class='bx bx-map text-blue-500'></i>
                                        Alamat
                                    </h3>
                                    <p class="text-sm text-slate-700 leading-relaxed"><?php echo htmlspecialchars($dataPerseroan['address']); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php
                            $activities = $dataPerseroan['activities'] ?? [];
                            if (is_array($activities) && !empty($activities)):
                            ?>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2 mb-3">
                                        <i class='bx bx-list-ul text-blue-500'></i>
                                        Aktivitas (<?php echo count($activities); ?>)
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach ($activities as $activity): ?>
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-medium border border-blue-100">
                                                <?php echo htmlspecialchars($activity['title'] ?? ''); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <?php if (!empty($dataPerseroan['imd']) || !empty($dataPerseroan['imb']) || !empty($dataPerseroan['skd']) || !empty($dataPerseroan['skb'])): ?>
                        <div class="pt-6 border-t border-slate-200">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2 mb-4">
                                <i class='bx bx-file-blank text-blue-500'></i>
                                Dokumen
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                <?php if (!empty($dataPerseroan['imd'])): ?>
                                    <a href="../../<?php echo htmlspecialchars($dataPerseroan['imd']); ?>" target="_blank"
                                        class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors group">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                            <i class='bx bx-file text-blue-600 text-xl'></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-900">IMD</p>
                                            <p class="text-xs text-slate-500">View Document</p>
                                        </div>
                                        <i class='bx bx-link-external text-slate-400'></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($dataPerseroan['imb'])): ?>
                                    <a href="../../<?php echo htmlspecialchars($dataPerseroan['imb']); ?>" target="_blank"
                                        class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors group">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                            <i class='bx bx-file text-green-600 text-xl'></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-900">IMB</p>
                                            <p class="text-xs text-slate-500">View Document</p>
                                        </div>
                                        <i class='bx bx-link-external text-slate-400'></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($dataPerseroan['skd'])): ?>
                                    <a href="../../<?php echo htmlspecialchars($dataPerseroan['skd']); ?>" target="_blank"
                                        class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors group">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                            <i class='bx bx-file text-purple-600 text-xl'></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-900">SKD</p>
                                            <p class="text-xs text-slate-500">View Document</p>
                                        </div>
                                        <i class='bx bx-link-external text-slate-400'></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($dataPerseroan['skb'])): ?>
                                    <a href="../../<?php echo htmlspecialchars($dataPerseroan['skb']); ?>" target="_blank"
                                        class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors group">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                                            <i class='bx bx-file text-orange-600 text-xl'></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-900">SKB</p>
                                            <p class="text-xs text-slate-500">View Document</p>
                                        </div>
                                        <i class='bx bx-link-external text-slate-400'></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Metadata -->
                    <div class="pt-6 border-t border-slate-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-sm text-slate-600">
                            <div class="flex items-center gap-2">
                                <i class='bx bx-user-circle text-slate-400'></i>
                                <span>Created by: <span class="font-semibold text-slate-900"><?php echo htmlspecialchars($dataPerseroan['fullname'] ?? 'Unknown'); ?></span></span>
                                <span class="text-slate-400">•</span>
                                <span><?php echo htmlspecialchars($dataPerseroan['email'] ?? ''); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class='bx bx-time text-slate-400'></i>
                                <span><?php echo date('M d, Y', strtotime($dataPerseroan['created_at'])); ?> at <?php echo date('H:i', strtotime($dataPerseroan['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-12 text-center">
                <i class='bx bx-inbox text-6xl text-slate-300 mb-4 block'></i>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">No Content Available</h3>
                <p class="text-sm text-slate-500 mb-4">
                    Belum ada data perseroan. Klik "Add New" untuk membuat data pertama.
                </p>
                <a href="/dashboard/data-perseroan/create.php"
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