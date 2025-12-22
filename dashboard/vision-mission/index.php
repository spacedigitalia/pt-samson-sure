<?php

/**
 * Daftar Visi & Misi
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

// Ambil filter tipe jika ada
$type = $_GET['type'] ?? '';
$typeFilter = in_array($type, ['vision', 'mission']) ? $type : '';

// Ambil semua data
$items = $controller->getAll($typeFilter);

$pageTitle = 'Daftar ' . ($typeFilter ? ucfirst($typeFilter) : 'Visi & Misi');

require_once __DIR__ . '/../header.php';

$active = 'vision-mission';

$breadcrumbs = [
    ['label' => 'Visi & Misi', 'href' => 'vision-mission'],
];

?>

<section class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <div class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4">
        <!-- Hamburger button fixed on mobile -->
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 right-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <!-- Header -->
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
                            <i class='bx bx-target-lock text-2xl md:text-3xl text-white'></i>
                        </div>

                        <!-- Title and Description -->
                        <div class="flex flex-col flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <h1 class="text-2xl md:text-4xl font-bold text-slate-900 tracking-tight">Visi & Misi
                                </h1>
                                <span
                                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    <i class='bx bx-check-circle text-sm'></i>
                                    Active
                                </span>
                            </div>
                            <p class="text-sm md:text-base text-slate-600 leading-relaxed max-w-2xl">
                                Kelola visi dan misi perusahaan. Tentukan arah dan tujuan jangka panjang organisasi
                                Anda.
                            </p>

                            <!-- Stats (if items exist) -->
                            <?php if (!empty($items)): ?>
                            <div class="flex items-center gap-4 mt-3 pt-3 border-t border-blue-100/50">
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <i class='bx bx-list-ul text-blue-500'></i>
                                    <span class="font-medium"><?php echo count($items); ?> Data</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <i class='bx bx-time text-indigo-500'></i>
                                    <span>Terakhir diperbarui:
                                        <?php echo date('d M Y', strtotime($items[0]['created_at'])); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex-shrink-0 flex flex-col sm:flex-row gap-3">
                        <a href="/dashboard/vision-mission/create.php"
                            class="group flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class='bx bx-plus text-lg group-hover:rotate-90 transition-transform duration-300'></i>
                            <span class="hidden sm:inline">Tambah Baru</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                No</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Jenis</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Dibuat</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        <?php foreach ($items as $index => $item): ?>
                        <tr class="hover:bg-slate-50 border-t border-slate-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <?php if (!empty($item['image'])): ?>
                                    <img src="../../<?= htmlspecialchars($item['image']) ?>" alt=""
                                        class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                    <?php endif; ?>
                                    <div class="text-xs text-slate-500 line-clamp-1">
                                        <?= htmlspecialchars($item['description']) ?></div>
                                </div>
                                <span
                                    class="px-2.5 py-1 text-xs font-medium rounded-full <?= $item['type'] === 'vision' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= $item['type'] === 'vision' ? 'Visi' : 'Misi' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                <?= date('d M Y', strtotime($item['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="/dashboard/vision-mission/edit.php?id=<?= $item['id'] ?>"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 transition-colors"
                                        title="Edit">
                                        <i class='bx bx-edit-alt text-lg'></i>
                                    </a>
                                    <form action="process.php" method="post" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus <?= $item['type'] === 'vision' ? 'visi' : 'misi' ?> ini?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 transition-colors"
                                            title="Hapus">
                                            <i class='bx bx-trash text-lg'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (empty($items)): ?>
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-12 text-center">
            <i class='bx bx-inbox text-6xl text-slate-300 mb-4 block'></i>
            <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Data</h3>
            <p class="text-sm text-slate-500 mb-4">
                Belum ada data visi & misi. Klik tombol di bawah untuk menambahkan data baru.
            </p>
            <a href="/dashboard/vision-mission/create.php"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-all">
                <i class='bx bx-plus text-lg'></i>
                Tambah Data
            </a>
        </div>
        <?php endif; ?>
</section>

</html>