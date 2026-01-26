<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/AboutController.php';
require_once __DIR__ . '/../controllers/DataPerseroanController.php';


$aboutController = new AboutController($db);
$dataPerseroanController = new DataPerseroanController($db);
$aboutData = $aboutController->getFirst();
$dataPerseroan = $dataPerseroanController->getAll();
?>

<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Learn about the history and mission of Surenusantara. We are a trusted partner for comprehensive business solutions and services.">
    <meta name="keywords" content="about, surenusantara, business, services, help, support">
    <meta name="author" content="Surenusantara">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://surenusantara.com/about/">
    <meta property="og:title" content="About Us - Surenusantara">
    <meta property="og:description"
        content="Learn about the history and mission of Surenusantara. We are a trusted partner for comprehensive business solutions and services.">
    <meta property="og:image" content="https://surenusantara.com/assets/logo.jpg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://surenusantara.com/about">
    <meta property="twitter:title" content="About Us - Surenusantara">
    <meta property="twitter:description"
        content="Learn about the history and mission of Surenusantara. We are a trusted partner for comprehensive business solutions and services.">
    <meta property="twitter:image" content="https://surenusantara.com/assets/logo.jpg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://surenusantara.com/about/" />

    <title>About Us - Surenusantara</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Favicon -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/globals.css">

    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Breadcrumb Structured Data -->
    <script src="/js/breadchumb.js"></script>
</head>

<body>
    <?php require_once __DIR__ . '/../layout/Header.php'; ?>
    <!-- Static Company Info Section -->
    <section class="container min-h-full py-10 px-4">
        <?php if (!empty($aboutData)): ?>
            <!-- Main About Content - Two Columns -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center mb-16">
                <!-- Left Column - Text Content -->
                <div class="space-y-6 order-1 md:order-2" data-aos="fade-up">
                    <h2 class="text-3xl font-bold text-slate-900 mb-6">ABOUT US</h2>

                    <?php
                    // Split text by paragraphs if it contains newlines
                    $textContent = $aboutData['text'] ?? '';
                    if (!empty($textContent)) {
                        $paragraphs = preg_split('/\n\s*\n/', $textContent);
                        foreach ($paragraphs as $paragraph) {
                            $paragraph = trim($paragraph);
                            if (!empty($paragraph)) {
                                echo '<p class="text-lg text-[#64748B] leading-relaxed">' . htmlspecialchars($paragraph) . '</p>';
                            }
                        }
                    }
                    ?>

                    <!-- Learn More Button -->
                    <div class="pt-4" data-aos="fade-up">
                        <a href="/vision-mission"
                            class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-[#505CEE] to-[#8A2BE2] text-white font-bold text-base shadow-lg hover:shadow-xl transition-all">
                            Learn More About Us
                        </a>
                    </div>
                </div>

                <!-- Right Column - Image -->
                <div class="order-2 md:order-1" data-aos="fade-right">
                    <?php if ($aboutData['image']): ?>
                        <div class="rounded-3xl overflow-hidden shadow-2xl bg-slate-100 aspect-[4/3]">
                            <img src="<?php echo htmlspecialchars($aboutData['image']); ?>" alt="About Us"
                                class="w-full h-full object-cover"
                                onerror="this.src='https://via.placeholder.com/800x600?text=Image+Not+Found'">
                        </div>
                    <?php else: ?>
                        <div
                            class="rounded-3xl overflow-hidden shadow-2xl bg-gradient-to-br from-[#505CEE] to-[#8A2BE2] h-96 flex items-center justify-center">
                            <div class="text-white text-center p-8">
                                <i class='bx bx-image text-6xl mb-4 opacity-50'></i>
                                <p class="text-lg font-medium opacity-75">No Image Available</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                <i class='bx bx-inbox text-6xl text-slate-300 mb-4 block'></i>
                <h2 class="text-2xl font-semibold text-slate-700 mb-2">No About Content Available</h2>
                <p class="text-slate-500">
                    Konten about belum tersedia.
                </p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Data Perseroan Section -->
    <section class="container min-h-full pb-4 px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-[#2C3A47] mb-4">DATA PERSEROAN</h2>
            <p class="text-lg text-[#64748B] max-w-2xl mx-auto leading-relaxed">
                Informasi lengkap mengenai data perseroan perusahaan kami
            </p>
        </div>

        <?php if (!empty($dataPerseroan)): ?>
            <div class="space-y-8">
                <?php foreach ($dataPerseroan as $index => $data): ?>
                    <div class="bg-white rounded-3xl shadow-lg border border-slate-200 overflow-hidden" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                        <!-- Header Card -->
                        <div class="bg-gradient-to-r from-[#505CEE] to-[#8A2BE2] px-8 py-8 relative overflow-hidden">
                            <!-- Background Image -->
                            <?php if (!empty($data['image'])): ?>
                                <div class="absolute inset-0 opacity-20">
                                    <img src="<?php echo htmlspecialchars($data['image']); ?>"
                                        alt="Data Perseroan"
                                        class="w-full h-full object-cover"
                                        onerror="this.style.display='none'">
                                </div>
                            <?php endif; ?>

                            <!-- Content Overlay -->
                            <div class="relative z-10">
                                <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">
                                    <!-- Image Thumbnail -->
                                    <?php if (!empty($data['image'])): ?>
                                        <div class="flex-shrink-0">
                                            <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl overflow-hidden border-4 border-white/30 shadow-xl bg-white">
                                                <img src="<?php echo htmlspecialchars($data['image']); ?>"
                                                    alt="Data Perseroan"
                                                    class="w-full h-full object-cover"
                                                    onerror="this.src='https://via.placeholder.com/200?text=No+Image'">
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Text Content -->
                                    <div class="flex-1">
                                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">
                                            <?php echo htmlspecialchars($data['company_name'] ?? 'Nama Perusahaan'); ?>
                                        </h3>
                                        <?php if (!empty($data['president_director'])): ?>
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                    <i class='bx bx-user text-xl text-white'></i>
                                                </div>
                                                <p class="text-white/90 text-base font-medium">
                                                    <?php echo htmlspecialchars($data['president_director']); ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Card -->
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Activities -->
                                <?php
                                $activities = $data['activities'] ?? [];
                                if (is_array($activities) && !empty($activities)):
                                ?>
                                    <div class="md:col-span-2">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#505CEE] to-[#8A2BE2] flex items-center justify-center">
                                                <i class='bx bx-list-ul text-white text-xl'></i>
                                            </div>
                                            <h4 class="text-lg font-bold text-[#2C3A47]">Bidang Usaha</h4>
                                        </div>
                                        <div class="flex flex-wrap gap-3">
                                            <?php foreach ($activities as $activity): ?>
                                                <span class="inline-flex items-center px-4 py-2 rounded-xl bg-gradient-to-r from-[#505CEE]/10 to-[#8A2BE2]/10 text-[#505CEE] text-sm font-semibold border border-[#505CEE]/20">
                                                    <i class='bx bx-check-circle text-base mr-2'></i>
                                                    <?php echo htmlspecialchars($activity['title'] ?? ''); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- NIB -->
                                <?php if (!empty($data['nib'])): ?>
                                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-10 h-10 rounded-lg bg-[#505CEE]/10 flex items-center justify-center">
                                                <i class='bx bx-id-card text-xl text-[#505CEE]'></i>
                                            </div>
                                            <h4 class="text-sm font-bold text-[#2C3A47] uppercase tracking-wide">NIB</h4>
                                        </div>
                                        <p class="text-[#64748B] text-base font-medium"><?php echo htmlspecialchars($data['nib']); ?></p>
                                    </div>
                                <?php endif; ?>

                                <!-- NPWP -->
                                <?php if (!empty($data['npwp'])): ?>
                                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-10 h-10 rounded-lg bg-[#505CEE]/10 flex items-center justify-center">
                                                <i class='bx bx-receipt text-xl text-[#505CEE]'></i>
                                            </div>
                                            <h4 class="text-sm font-bold text-[#2C3A47] uppercase tracking-wide">NPWP</h4>
                                        </div>
                                        <p class="text-[#64748B] text-base font-medium"><?php echo htmlspecialchars($data['npwp']); ?></p>
                                    </div>
                                <?php endif; ?>

                                <!-- Deed Incorporation Number -->
                                <?php if (!empty($data['deed_incorporation_number'])): ?>
                                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-10 h-10 rounded-lg bg-[#505CEE]/10 flex items-center justify-center">
                                                <i class='bx bx-file-blank text-xl text-[#505CEE]'></i>
                                            </div>
                                            <h4 class="text-sm font-bold text-[#2C3A47] uppercase tracking-wide">Nomor Akta Pendirian</h4>
                                        </div>
                                        <p class="text-[#64748B] text-base font-medium"><?php echo htmlspecialchars($data['deed_incorporation_number']); ?></p>
                                    </div>
                                <?php endif; ?>

                                <!-- Investment Status -->
                                <?php if (!empty($data['investment_status'])): ?>
                                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-10 h-10 rounded-lg bg-[#505CEE]/10 flex items-center justify-center">
                                                <i class='bx bx-trending-up text-xl text-[#505CEE]'></i>
                                            </div>
                                            <h4 class="text-sm font-bold text-[#2C3A47] uppercase tracking-wide">Status Investasi</h4>
                                        </div>
                                        <p class="text-[#64748B] text-base font-medium"><?php echo htmlspecialchars($data['investment_status']); ?></p>
                                    </div>
                                <?php endif; ?>

                                <!-- Address -->
                                <?php if (!empty($data['address'])): ?>
                                    <div class="md:col-span-2 bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-10 h-10 rounded-lg bg-[#505CEE]/10 flex items-center justify-center">
                                                <i class='bx bx-map text-xl text-[#505CEE]'></i>
                                            </div>
                                            <h4 class="text-sm font-bold text-[#2C3A47] uppercase tracking-wide">Alamat</h4>
                                        </div>
                                        <p class="text-[#64748B] text-base leading-relaxed"><?php echo nl2br(htmlspecialchars($data['address'])); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center" data-aos="fade-up">
                <i class='bx bx-inbox text-6xl text-slate-300 mb-4 block'></i>
                <h3 class="text-xl font-semibold text-slate-700 mb-2">Data Perseroan Belum Tersedia</h3>
                <p class="text-slate-500">
                    Informasi data perseroan akan segera ditambahkan.
                </p>
            </div>
        <?php endif; ?>
    </section>

    <?php require_once __DIR__ . '/../layout/Footer.php'; ?>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script src="/js/main.js"></script>
</body>

</html>