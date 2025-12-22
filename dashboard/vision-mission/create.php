<?php

/**
 * Create New Vision/Mission
 */

session_start();

// Hanya admin yang bisa mengakses
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

// Get type from query parameter (vision or mission)
$type = isset($_GET['type']) && in_array($_GET['type'], ['vision', 'mission'])
    ? $_GET['type']
    : '';

// Jika tipe tidak valid, tampilkan pilihan tipe
if (!in_array($type, ['vision', 'mission'])) {
    $pageTitle = 'Pilih Jenis Konten';
    require_once __DIR__ . '/../header.php';
?>
<div class="flex min-h-screen overflow-hidden">
    <?php require_once __DIR__ . '/../sidebar.php'; ?>

    <main class="flex-1 min-w-0 h-screen overflow-y-auto px-4 md:px-8 space-y-4 pb-4">
        <!-- Breadcrumb -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="lg:hidden w-10"></div>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="/dashboard"
                                class="inline-flex items-center text-sm font-medium text-slate-700 hover:text-blue-600">
                                <i class='bx bx-home-alt text-lg mr-2'></i>
                                Dashboard
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class='bx bx-chevron-right text-slate-400 mx-2'></i>
                                <span class="text-sm font-medium text-slate-500">Tambah Baru</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Pilihan Tipe -->
        <div class="max-w-2xl mx-auto mt-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Pilih Jenis Konten</h2>
                <p class="text-slate-500 mt-2">Pilih jenis konten yang ingin Anda tambahkan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="?type=vision"
                    class="group p-6 border-2 border-slate-200 rounded-2xl hover:border-blue-500 transition-colors">
                    <div
                        class="w-16 h-16 bg-blue-50 rounded-xl flex items-center justify-center mb-4 mx-auto group-hover:bg-blue-100 transition-colors">
                        <i class='bx bx-bulb text-3xl text-blue-600'></i>
                    </div>
                    <h3 class="text-lg font-semibold text-center text-slate-800 mb-2">Tambah Visi</h3>
                    <p class="text-sm text-slate-500 text-center">Tujuan dan arah jangka panjang perusahaan</p>
                </a>

                <a href="?type=mission"
                    class="group p-6 border-2 border-slate-200 rounded-2xl hover:border-green-500 transition-colors">
                    <div
                        class="w-16 h-16 bg-green-50 rounded-xl flex items-center justify-center mb-4 mx-auto group-hover:bg-green-100 transition-colors">
                        <i class='bx bx-target-lock text-3xl text-green-600'></i>
                    </div>
                    <h3 class="text-lg font-semibold text-center text-slate-800 mb-2">Tambah Misi</h3>
                    <p class="text-sm text-slate-500 text-center">Langkah-langkah untuk mencapai visi perusahaan</p>
                </a>
            </div>

            <div class="mt-8 text-center">
                <a href="/dashboard/vision-mission"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                    <i class='bx bx-arrow-back mr-2'></i> Kembali
                </a>
            </div>
        </div>
    </main>
</div>
<?php
    exit;
}

// Jika tipe valid, tampilkan form
$pageTitle = $type === 'vision' ? 'Tambah Visi' : 'Tambah Misi';

require_once __DIR__ . '/../header.php';

$active = 'vision-mission';

$breadcrumbs = [
    ['label' => 'Dashboard', 'href' => '/dashboard'],
    ['label' => 'Visi & Misi', 'href' => '/dashboard/vision-mission'],
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

            <a href="/dashboard/vision-mission"
                class="flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-all">
                <i class='bx bx-arrow-back text-lg'></i>
                <span class="hidden sm:inline">Kembali ke Daftar</span>
                <span class="sm:hidden">Kembali</span>
            </a>
        </div>

        <!-- Content -->
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-800"><?= htmlspecialchars($pageTitle) ?></h2>
                <p class="text-sm text-slate-500">Lengkapi form di bawah untuk menambahkan
                    <?= $type === 'vision' ? 'visi' : 'misi' ?> baru</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
            <?php endif; ?>

            <form action="process.php" method="post" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5" required
                        class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent"
                        placeholder="Masukkan deskripsi <?= $type === 'vision' ? 'visi' : 'misi' ?>"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>

                <!-- Gambar -->
                <div>
                    <label for="image" class="block text-sm font-medium text-slate-700 mb-1">
                        Gambar
                    </label>
                    <input type="file" id="image" name="image" accept="image/*" class="block w-full text-sm text-slate-500
                                  file:mr-4 file:py-2.5 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-slate-50 file:text-slate-700
                                  hover:file:bg-slate-100">
                    <p class="mt-1 text-xs text-slate-500">Ukuran maksimal 2MB. Format: JPG, PNG, GIF</p>
                    <div id="imagePreview" class="mt-2"></div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="/dashboard/vision-mission"
                        class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition-colors">
                        Simpan <?= $type === 'vision' ? 'Visi' : 'Misi' ?>
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<!-- Image Preview Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');

    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.innerHTML = `
                        <div class="mt-2 p-2 border border-slate-200 rounded-lg inline-block">
                            <img src="${e.target.result}" 
                                 alt="Preview" 
                                 class="h-40 object-cover rounded">
                            <p class="mt-1 text-xs text-slate-500">${file.name}</p>
                        </div>
                    `;
                };

                reader.readAsDataURL(file);
            } else {
                imagePreview.innerHTML = '';
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/../footer.php'; ?>