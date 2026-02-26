<?php
session_start();

// Proteksi halaman: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../header.php';

$active = 'data-perseroan';
$breadcrumbs = [
    ['label' => 'Data Perseroan', 'href' => '/dashboard/data-perseroan'],
    ['label' => 'Create Content', 'href' => '#'],
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

            <a href="/dashboard/data-perseroan"
                class="flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-all">
                <i class='bx bx-arrow-back text-lg'></i>
                <span class="hidden sm:inline">Back to Data Perseroan</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>

        <!-- Content -->
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <form action="/dashboard/data-perseroan/process.php" method="POST" enctype="multipart/form-data" class="space-y-6" id="dataPerseroanForm">
                <input type="hidden" name="action" value="create">

                <!-- Activities -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Activities</label>
                    <div id="activitiesContainer" class="space-y-3">
                        <div class="activity-item flex gap-2">
                            <input type="text" name="activities[]" required placeholder="Masukkan activity title..."
                                class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                            <button type="button" onclick="removeActivity(this)"
                                class="px-4 py-3 rounded-xl bg-red-100 text-red-700 hover:bg-red-200 transition-colors hidden">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="addActivity()"
                        class="mt-2 flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-all">
                        <i class='bx bx-plus text-lg'></i>
                        Add Activity
                    </button>
                    <p class="mt-1 text-[10px] text-slate-500 italic">Minimal 1 activity harus diisi</p>
                </div>

                <!-- Company Name -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Company Name</label>
                    <input type="text" name="company_name" placeholder="Masukkan nama perusahaan..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                </div>

                <!-- President Director -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">President Director</label>
                    <input type="text" name="president_director" placeholder="Masukkan nama direktur utama..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                </div>

                <!-- Deed Incorporation Number -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deed Incorporation Number</label>
                    <input type="text" name="deed_incorporation_number" placeholder="Masukkan nomor akta pendirian..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                </div>

                <!-- NIB -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIB (Nomor Induk Berusaha)</label>
                    <input type="text" name="nib" placeholder="Masukkan NIB..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                </div>

                <!-- NPWP -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NPWP</label>
                    <input type="text" name="npwp" placeholder="Masukkan NPWP..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Address</label>
                    <textarea name="address" rows="3" placeholder="Masukkan alamat perusahaan..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"></textarea>
                </div>

                <!-- Investment Status -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Investment Status</label>
                    <input type="text" name="investment_status" placeholder="Masukkan status investasi..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Image (Upload)</label>
                    <div class="relative group">
                        <input type="file" name="image" accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                    </div>
                    <p class="mt-1 text-[10px] text-slate-500 italic">Format: JPG, PNG, WEBP (Max 2MB)</p>
                </div>

                <!-- IMD -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">IMD (Upload)</label>
                    <div class="relative group">
                        <input type="file" name="imd" accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                    </div>
                    <p class="mt-1 text-[10px] text-slate-500 italic">Format: JPG, PNG, WEBP (Max 2MB)</p>
                </div>

                <!-- IMB -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">IMB (Upload)</label>
                    <div class="relative group">
                        <input type="file" name="imb" accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                    </div>
                    <p class="mt-1 text-[10px] text-slate-500 italic">Format: JPG, PNG, WEBP (Max 2MB)</p>
                </div>

                <!-- SKD -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">SKD (Upload)</label>
                    <div class="relative group">
                        <input type="file" name="skd" accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                    </div>
                    <p class="mt-1 text-[10px] text-slate-500 italic">Format: JPG, PNG, WEBP (Max 2MB)</p>
                </div>

                <!-- SKB -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">SKB (Upload)</label>
                    <div class="relative group">
                        <input type="file" name="skb" accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                    </div>
                    <p class="mt-1 text-[10px] text-slate-500 italic">Format: JPG, PNG, WEBP (Max 2MB)</p>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="flex-1 md:flex-none rounded-xl bg-slate-900 px-10 py-3.5 text-sm font-semibold text-white hover:bg-slate-800 transition-all shadow-sm">
                        <i class='bx bx-save mr-2'></i> Save Content
                    </button>
                    <a href="/dashboard/data-perseroan"
                        class="flex-1 md:flex-none text-center rounded-xl bg-slate-100 px-10 py-3.5 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    function addActivity() {
        const container = document.getElementById('activitiesContainer');
        const activityCount = container.children.length;

        const newActivity = document.createElement('div');
        newActivity.className = 'activity-item flex gap-2';
        newActivity.innerHTML = `
        <input type="text" name="activities[]" required placeholder="Masukkan activity title..."
            class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
        <button type="button" onclick="removeActivity(this)"
            class="px-4 py-3 rounded-xl bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
            <i class='bx bx-trash'></i>
        </button>
    `;
        container.appendChild(newActivity);

        // Show remove buttons if more than 1 activity
        if (activityCount >= 1) {
            const firstRemoveBtn = container.querySelector('.activity-item:first-child button');
            if (firstRemoveBtn) firstRemoveBtn.classList.remove('hidden');
        }
    }

    function removeActivity(button) {
        const container = document.getElementById('activitiesContainer');
        if (container.children.length > 1) {
            button.closest('.activity-item').remove();

            // Hide remove button if only 1 activity left
            if (container.children.length === 1) {
                const firstRemoveBtn = container.querySelector('.activity-item:first-child button');
                if (firstRemoveBtn) firstRemoveBtn.classList.add('hidden');
            }
        }
    }
</script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="../js/toast.js"></script>
</body>

</html>