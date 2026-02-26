<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/InteriorController.php';
require_once __DIR__ . '/../header.php';

$active = 'interior';
$breadcrumbs = [
    ['label' => 'Interior', 'href' => 'interior'],
    ['label' => 'Edit Image', 'href' => '#'],
];

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /dashboard/interior');
    exit;
}

$controller = new InteriorController($db);
$interiorData = $controller->getById((int)$id);

if (!$interiorData) {
    $_SESSION['error'] = 'Data tidak ditemukan.';
    header('Location: /dashboard/interior');
    exit;
}
?>
<div class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <main class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4 pb-4">
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 left-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="lg:hidden w-10"></div>
                <?php echo renderBreadcrumb($breadcrumbs); ?>
            </div>

            <a href="/dashboard/interior"
                class="flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-all">
                <i class='bx bx-arrow-back text-lg'></i>
                <span class="hidden sm:inline">Back to Interior</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <form action="process.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($interiorData['id']); ?>">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Image (Upload New)</label>
                    <?php if (!empty($interiorData['image'])): ?>
                        <div class="mb-3 p-4 border border-slate-200 rounded-xl bg-slate-50">
                            <p class="text-xs text-slate-600 mb-2 font-semibold">Current Image:</p>
                            <div class="rounded-xl overflow-hidden bg-white border border-slate-200">
                                <img src="../../<?php echo htmlspecialchars($interiorData['image']); ?>"
                                    class="w-full h-auto object-contain max-h-[300px] mx-auto"
                                    onerror="this.src='https://via.placeholder.com/600x400?text=Error'">
                            </div>
                            <p class="mt-2 text-[10px] text-slate-500 truncate">
                                <?php echo basename($interiorData['image']); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" accept="image/*" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                    <p class="mt-1 text-[10px] text-slate-500 italic">Format: JPG, PNG, WEBP (Max 2MB)</p>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="flex-1 md:flex-none rounded-xl bg-slate-900 px-10 py-3.5 text-sm font-semibold text-white hover:bg-slate-800 transition-all shadow-sm">
                        <i class='bx bx-refresh mr-2'></i> Update Image
                    </button>
                    <a href="/dashboard/interior"
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
