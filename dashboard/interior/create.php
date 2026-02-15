<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../header.php';

$active = 'interior';
$breadcrumbs = [
    ['label' => 'Interior', 'href' => 'interior'],
    ['label' => 'Tambah Gambar', 'href' => '#'],
];
?>
<div class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <main class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4 pb-4">
        <button onclick="toggleSidebar()"
            class="lg:hidden fixed top-4 left-4 z-40 h-10 w-10 rounded-xl bg-white/80 backdrop-blur-md border border-slate-200 shadow-sm grid place-items-center text-slate-600 hover:bg-slate-50 transition-all">
            <i class='bx bx-menu text-2xl'></i>
        </button>

        <div class="px-4 md:px-8 py-4">
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
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <form action="process.php" method="POST" enctype="multipart/form-data" class="space-y-6"
                onsubmit="return validateForm()">
                <script>
                    function validateForm() {
                        const image = document.querySelector('[name="image"]').files.length;
                        if (image === 0) {
                            toastr.error('Harap pilih gambar yang akan diupload');
                            return false;
                        }
                        return true;
                    }
                </script>
                <input type="hidden" name="action" value="create">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Interior</label>
                    <div class="relative group">
                        <input type="file" name="image" accept="image/*" required
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                    </div>
                    <p class="mt-1 text-[10px] text-slate-500 italic">Format: JPG, PNG, WEBP (Max 2MB)</p>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="flex-1 md:flex-none rounded-xl bg-slate-900 px-10 py-3.5 text-sm font-semibold text-white hover:bg-slate-800 transition-all shadow-sm">
                        <i class='bx bx-upload mr-2'></i> Upload Gambar
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="../js/toast.js"></script>
</body>

</html>
