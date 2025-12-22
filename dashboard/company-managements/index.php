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
require_once __DIR__ . '/../../controllers/CompanyManagementController.php';

$active = 'company-managements';
$breadcrumbs = [
    ['label' => 'Company Management', 'href' => 'company-managements'],
];

$controller = new CompanyManagementController($db);

// Get all company management data
$managements = $controller->getAll();
?>
<section class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <div class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4">
        <!-- Hamburger button fixed on mobile -->
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 right-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <!-- Company Management Header -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 border border-amber-100/50 shadow-lg">
            <!-- Decorative background elements -->
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-amber-200/20 to-yellow-200/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-orange-200/20 to-amber-200/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
            </div>

            <div class="relative px-6 md:px-8 py-6 md:py-8">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between gap-4 md:gap-6">
                    <div class="flex items-start gap-4 flex-1">
                        <!-- Icon Container -->
                        <div
                            class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg flex items-center justify-center transform transition-transform hover:scale-105 hidden md:flex">
                            <i class='bx bx-buildings text-2xl md:text-3xl text-white'></i>
                        </div>

                        <!-- Title and Description -->
                        <div class="flex flex-col flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <h1 class="text-2xl md:text-4xl font-bold text-slate-900 tracking-tight">Company
                                    Management</h1>
                                <span
                                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                    <i class='bx bx-check-circle text-sm'></i>
                                    Active
                                </span>
                            </div>

                            <p class="text-sm md:text-base text-slate-600 leading-relaxed max-w-2xl">
                                Kelola konten company management Buat, edit, dan hapus
                                informasi manajemen perusahaan.
                            </p>

                            <!-- Stats (if managements exist) -->
                            <?php if (!empty($managements)): ?>
                            <div class="flex items-center gap-4 mt-3 pt-3 border-t border-amber-100/50">
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <i class='bx bx-list-ul text-amber-500'></i>
                                    <span class="font-medium"><?php echo count($managements); ?> Positions</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <i class='bx bx-time text-orange-500'></i>
                                    <span>Last updated:
                                        <?php echo date('M d, Y', strtotime($managements[0]['created_at'])); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="flex-shrink-0">
                        <a href="/dashboard/company-managements/create.php"
                            class="group flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-amber-600 to-orange-600 px-5 py-3 text-sm font-semibold text-white hover:from-amber-700 hover:to-orange-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class='bx bx-plus text-lg group-hover:rotate-90 transition-transform duration-300'></i>
                            <span class="hidden sm:inline">Add New Position</span>
                            <span class="sm:hidden">Add</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company Management Table -->
        <?php if (!empty($managements)): ?>
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Image</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Position</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Description</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Created By</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Created At</th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        <?php foreach ($managements as $management): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($management['image']): ?>
                                <img src="../../<?php echo htmlspecialchars($management['image']); ?>"
                                    alt="<?php echo htmlspecialchars($management['position']); ?>"
                                    class="w-16 h-16 rounded-lg object-cover border border-slate-200"
                                    onerror="this.src='https://via.placeholder.com/64?text=No+Image'">
                                <?php else: ?>
                                <div
                                    class="w-16 h-16 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center">
                                    <i class='bx bx-image text-2xl text-slate-400'></i>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-slate-900">
                                    <?php echo htmlspecialchars($management['position']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center gap-1 rounded-xl px-3 py-1.5 text-xs font-semibold <?php echo $management['status'] === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700'; ?>">
                                    <?php echo htmlspecialchars($management['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600 max-w-md line-clamp-2">
                                    <?php echo htmlspecialchars(mb_substr($management['description'], 0, 100)); ?>
                                    <?php if (mb_strlen($management['description']) > 100): ?>...<?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600">
                                    <?php echo htmlspecialchars($management['fullname'] ?? 'Unknown'); ?>
                                </div>
                                <div class="text-xs text-slate-500">
                                    <?php echo htmlspecialchars($management['email'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600">
                                    <?php echo date('M d, Y', strtotime($management['created_at'])); ?>
                                </div>
                                <div class="text-xs text-slate-500">
                                    <?php echo date('H:i', strtotime($management['created_at'])); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="/dashboard/company-managements/edit.php?id=<?php echo $management['id']; ?>"
                                        class="inline-flex items-center gap-1 rounded-xl bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-200 transition-colors">
                                        <i class='bx bx-edit'></i>
                                        Edit
                                    </a>
                                    <form action="process.php" method="POST" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus company management ini?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $management['id']; ?>">
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 rounded-xl bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200 transition-colors">
                                            <i class='bx bx-trash'></i>
                                            Delete
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
        <?php else: ?>
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-12 text-center">
            <i class='bx bx-inbox text-6xl text-slate-300 mb-4 block'></i>
            <h3 class="text-lg font-semibold text-slate-700 mb-2">No Content Available</h3>
            <p class="text-sm text-slate-500 mb-4">
                Belum ada konten company management. Klik "Add New" untuk membuat konten pertama.
            </p>
            <a href="/dashboard/company-managements/create.php"
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