<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/ServicesController.php';
require_once __DIR__ . '/controllers/CompanyManagementController.php';
require_once __DIR__ . '/controllers/AboutController.php';
require_once __DIR__ . '/controllers/StrukturOrganisasiController.php';

$homeController = new HomeController($db);
$homeData = $homeController->getFirst();

$aboutController = new AboutController($db);
$aboutData = $aboutController->getFirst();

$servicesController = new ServicesController($db);
$allServices = $servicesController->getAll();
$services = array_slice($allServices, 0, 6); // Limit to 6 services

$companyManagementController = new CompanyManagementController($db);
$managements = $companyManagementController->getAll();

$strukturOrganisasiController = new StrukturOrganisasiController($db);
$strukturOrganisasiData = $strukturOrganisasiController->getFirst();

?>

<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Surenusantara - Your trusted partner for comprehensive business solutions and services.">
    <meta name="keywords" content="Surenusantara, business solutions, consulting, professional services">
    <meta name="author" content="Surenusantara">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.samsonsure.co.id/">
    <meta property="og:title" content="Surenusantara - Business Solutions">
    <meta property="og:description" content="Your trusted partner for comprehensive business solutions and services.">
    <meta property="og:image" content="https://www.samsonsure.co.id/assets/logo.jpg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.samsonsure.co.id/">
    <meta property="twitter:title" content="Surenusantara - Business Solutions">
    <meta property="twitter:description"
        content="Your trusted partner for comprehensive business solutions and services.">
    <meta property="twitter:image" content="https://www.samsonsure.co.id/assets/logo.jpg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.samsonsure.co.id/" />

    <title>Surenusantara</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style/globals.css">

    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <!-- Breadcrumb Structured Data -->
    <script src="/js/breadchumb.js"></script>
</head>

<body>
    <?php require_once __DIR__ . '/layout/Header.php'; ?>
    <main class="overflow-hidden">
        <!-- Home -->
        <section class="container min-h-full py-20 flex flex-col px-4">
            <?php if ($homeData): ?>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <!-- Left Column - Content -->
                    <div class="space-y-8">
                        <!-- Title -->
                        <h1 class="text-4xl font-bold text-[#2C3A47] leading-tight" data-aos="fade-up">
                            <?php
                            // Function to highlight words in title (words wrapped in ** will be blue)
                            $title = $homeData['title'];
                            // Split by **text** pattern, process each part
                            $parts = preg_split('/(\*\*.*?\*\*)/', $title, -1, PREG_SPLIT_DELIM_CAPTURE);
                            foreach ($parts as $part) {
                                if (preg_match('/\*\*(.*?)\*\*/', $part, $matches)) {
                                    echo '<span class="text-[#505CEE]">' . htmlspecialchars($matches[1]) . '</span>';
                                } else {
                                    echo htmlspecialchars($part);
                                }
                            }
                            ?>
                        </h1>

                        <!-- Description -->
                        <p class="text-lg text-[#64748B] leading-relaxed" data-aos="fade-up" data-aos-delay="100">
                            <?php echo htmlspecialchars($homeData['description']); ?>
                        </p>

                        <!-- Additional Text -->
                        <?php if (!empty($homeData['text'])): ?>
                            <p class="text-lg text-[#64748B] leading-relaxed" data-aos="fade-up" data-aos-delay="100">
                                <?php echo htmlspecialchars($homeData['text']); ?>
                            </p>
                        <?php endif; ?>

                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="200">
                            <a href="/cosultant"
                                class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-[#505CEE] to-[#8A2BE2] text-white font-bold text-base shadow-lg hover:shadow-xl transition-all">
                                Explore Solutions <span class="text-xl">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right Column - Image -->
                    <div class="order-first lg:order-last" data-aos="fade-left">
                        <?php if ($homeData['image']): ?>
                            <div class="rounded-3xl overflow-hidden shadow-2xl bg-slate-100 aspect-[4/3]">
                                <img src="<?php echo htmlspecialchars($homeData['image']); ?>"
                                    alt="<?php echo htmlspecialchars($homeData['title']); ?>" class="w-full h-full object-cover"
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
                    <h2 class="text-2xl font-semibold text-slate-700 mb-2">No Content Available</h2>
                    <p class="text-slate-500">
                        Konten home belum tersedia.
                    </p>
                </div>
            <?php endif; ?>
        </section>

        <!-- Features -->
        <section class="container min-h-full py-12 px-4">
            <?php if (!empty($aboutData)): ?>
                <?php
                $items = $aboutData['items'] ?? [];
                if (!empty($items)):
                ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">
                        <?php
                        // Icons for features
                        $featureIcons = [
                            'bx-trophy',      // Industry Recognition
                            'bx-group',       // Expert Team
                            'bx-globe',       // Global Reach
                            'bx-trending-up', // Growth Leader
                            'bx-award',       // Additional icons
                            'bx-check-circle',
                            'bx-star',
                            'bx-briefcase'
                        ];
                        foreach ($items as $index => $item):
                            $icon = $featureIcons[$index] ?? 'bx-info-circle';
                        ?>
                            <div class="text-center space-y-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                                <div class="flex justify-center mb-4">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-[#505CEE] to-[#8A2BE2] flex items-center justify-center shadow-lg">
                                        <i class='bx <?php echo $icon; ?> text-3xl text-white'></i>
                                    </div>
                                </div>

                                <p class="text-sm text-[#64748B] leading-relaxed">
                                    <?php echo htmlspecialchars($item['description'] ?? ''); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

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

        <!-- Services -->
        <section class="container min-h-full py-12 px-4">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-lg font-semibold text-[#8A2BE2] mb-4">OUR SERVICES</h2>
                <h3 class="text-4xl md:text-5xl font-bold text-[#2C3A47] leading-tight">
                    Solutions That <span class="text-[#505CEE]">Drive Success</span>
                </h3>
                <p class="text-lg text-[#64748B] mt-4 max-w-2xl mx-auto">
                    Kami menyediakan berbagai layanan terbaik untuk memenuhi kebutuhan bisnis Anda
                </p>
            </div>

            <?php if (!empty($services)): ?>
                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
                    <?php foreach ($services as $index => $service): ?>
                        <div class="group relative block" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                            <!-- Decorative background shadow effect -->
                            <div
                                class="absolute inset-0 bg-blue-600 rounded-2xl transform translate-x-0 translate-y-0 transition-all duration-300 opacity-0 group-hover:translate-x-2 group-hover:translate-y-2 group-hover:opacity-10">
                            </div>

                            <div
                                class="relative bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 group-hover:border-blue-500/30 group-hover:shadow-lg flex flex-col overflow-hidden">
                                <!-- Service Image (Original Style) -->
                                <div class="relative h-64 overflow-hidden bg-slate-100">
                                    <?php if ($service['image']): ?>
                                        <img src="<?php echo htmlspecialchars($service['image']); ?>"
                                            alt="<?php echo htmlspecialchars($service['title']); ?>"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                            onerror="this.src='https://via.placeholder.com/400x300?text=Image+Not+Found'">
                                    <?php else: ?>
                                        <div
                                            class="w-full h-full bg-gradient-to-br from-[#505CEE] to-[#8A2BE2] flex items-center justify-center">
                                            <div class="text-white text-center p-8">
                                                <i class='bx bx-briefcase text-6xl mb-4 opacity-50'></i>
                                                <p class="text-lg font-medium opacity-75">No Image Available</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="p-6 flex flex-col flex-grow">
                                    <!-- Content -->
                                    <h3 id="service-title-<?php echo $service['id']; ?>"
                                        class="text-xl font-bold text-slate-900 mb-3 line-clamp-1"
                                        title="<?php echo htmlspecialchars($service['title']); ?>">
                                        <?php echo htmlspecialchars($service['title']); ?>
                                    </h3>
                                    <p id="service-desc-<?php echo $service['id']; ?>"
                                        class="text-slate-600 leading-relaxed mb-4 flex-grow line-clamp-2 transition-all duration-300">
                                        <?php echo nl2br(htmlspecialchars($service['description'])); ?>
                                    </p>

                                    <!-- Footer/Action -->
                                    <div class="border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <button onclick="toggleServiceCard(<?php echo $service['id']; ?>)"
                                            class="flex items-center text-slate-500 font-semibold text-sm hover:text-blue-600 transition-colors focus:outline-none">
                                            <span id="service-text-<?php echo $service['id']; ?>">Learn More</span>
                                            <i id="service-icon-<?php echo $service['id']; ?>"
                                                class='bx bx-chevron-down ml-1 text-xl transition-transform duration-300'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Learn More Button -->
                <div class="flex justify-center mt-8" data-aos="fade-up">
                    <a href="/services"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-gradient-to-r from-[#505CEE] to-[#8A2BE2] text-white font-semibold text-base shadow-md hover:shadow-lg transition-all hover:scale-105">
                        Learn More <span class="text-lg">→</span>
                    </a>
                </div>

            <?php else: ?>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                    <i class='bx bx-briefcase text-6xl text-slate-300 mb-4 block'></i>
                    <h2 class="text-2xl font-semibold text-slate-700 mb-2">No Services Available</h2>
                    <p class="text-slate-500">
                        Layanan belum tersedia.
                    </p>
                </div>
            <?php endif; ?>
        </section>

        <!-- Stuktur Organisasi -->
        <section class="relative py-8 md:py-12 lg:py-16">
            <div class="relative min-h-[60vh] md:min-h-[70vh] lg:min-h-screen flex flex-col justify-center items-center bg-cover bg-center bg-no-repeat px-4"
                style="background-image: url('../assets/bg.jpg'); background-attachment: fixed;">
                <!-- Overlay Background -->
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60"></div>

                <div class="relative z-10 text-center mb-8 md:mb-12 w-full max-w-6xl mx-auto px-4" data-aos="fade-up">
                    <h2 class="text-sm md:text-lg font-semibold text-white mb-2 md:mb-4">OUR STRUKTUR ORGANISASI</h2>
                    <h3 class="text-2xl md:text-4xl lg:text-5xl font-bold text-white leading-tight px-2">
                        Stuktur Organisasi <span class="text-white">Kami</span>
                    </h3>
                    <p class="text-sm md:text-lg text-white mt-3 md:mt-4 max-w-2xl mx-auto px-2">
                        Struktur organisasi yang menggerakkan perusahaan kami
                    </p>
                </div>

                <?php if ($strukturOrganisasiData && !empty($strukturOrganisasiData['image'])): ?>
                    <div class="relative z-10 w-full max-w-5xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                        <div>
                            <img src="<?php echo htmlspecialchars($strukturOrganisasiData['image']); ?>"
                                alt="Struktur Organisasi"
                                class="w-full h-auto object-contain rounded-md md:rounded-lg"
                                onerror="this.src='https://via.placeholder.com/1200x800?text=Image+Not+Found'">
                        </div>
                    </div>
                <?php else: ?>
                    <div class="relative z-10 w-full max-w-5xl mx-auto px-4 md:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="200">
                        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 lg:p-12 text-center">
                            <i class='bx bx-sitemap text-4xl md:text-6xl text-slate-300 mb-3 md:mb-4 block'></i>
                            <h3 class="text-lg md:text-xl font-semibold text-slate-700 mb-2">Struktur Organisasi Belum Tersedia</h3>
                            <p class="text-sm md:text-base text-slate-500">
                                Gambar struktur organisasi sedang dalam proses pembaruan.
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Job-Description Key Responsibilities -->
        <section class="container min-h-full py-12 px-4">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-lg font-semibold text-[#8A2BE2] mb-4">Job-Description Key Responsibilities</h2>
                <h3 class="text-4xl md:text-5xl font-bold text-[#2C3A47] leading-tight">
                    Job-Description <span class="text-[#505CEE]">Key Responsibilities</span>
                </h3>
                <p class="text-lg text-[#64748B] mt-4 max-w-2xl mx-auto">
                    Peran dan tanggung jawab utama dalam struktur perusahaan kami
                </p>
            </div>

            <!-- Row 1: QA Manager & Operation Manager -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8" data-aos="fade-up">
                <!-- QA Manager -->
                <div class="rounded-2xl overflow-hidden shadow-lg bg-[#C45C26]/90 text-white p-6">
                    <h4 class="text-xl font-bold text-white mb-3">Quality Assurance (QA) Manager</h4>
                    <p class="text-sm text-white/95 mb-4">Memastikan kualitas produk/layanan, keamanan, performa, dan pencegahan defect melalui monitoring, testing, dan audit.</p>
                    <p class="text-sm font-semibold mb-2">Key Responsibilities:</p>
                    <ul class="text-sm space-y-1 list-disc list-inside text-white/95">
                        <li>Testing & Inspection</li>
                        <li>Defect Tracking</li>
                        <li>Process Improvement</li>
                        <li>Documentation</li>
                        <li>Collaboration</li>
                        <li>Compliance</li>
                    </ul>
                </div>
                <!-- Operation Manager -->
                <div class="rounded-2xl overflow-hidden shadow-lg bg-[#1E3A5F]/90 text-white p-6">
                    <h4 class="text-xl font-bold text-white mb-3">Operation Manager</h4>
                    <p class="text-sm text-white/95 mb-4">Mengawasi aktivitas bisnis harian, efisiensi, produktivitas, dan mendorong profitabilitas lintas departemen.</p>
                    <p class="text-sm font-semibold mb-2">Key Responsibilities:</p>
                    <ul class="text-sm space-y-1 list-disc list-inside text-white/95">
                        <li>Strategy & Planning</li>
                        <li>Process Management</li>
                        <li>Resource & Budget</li>
                        <li>Staff Management</li>
                        <li>Quality & Compliance</li>
                        <li>Performance Monitoring</li>
                        <li>Interdepartmental Coordination</li>
                    </ul>
                </div>
            </div>

            <!-- Row 2: Business Manager -->
            <div class="mb-8" data-aos="fade-up">
                <div class="rounded-2xl overflow-hidden shadow-lg bg-[#E85D04]/95 text-white p-8">
                    <h4 class="text-2xl font-bold mb-4">Business Manager</h4>
                    <p class="text-white/95 mb-4">Mengawasi operasi harian, kinerja keuangan, dan perencanaan strategis untuk memastikan produktivitas dan pertumbuhan perusahaan. Tanggung jawab utama meliputi pengelolaan anggaran, memimpin staf, mengoptimalkan alur kerja, dan memastikan kepatuhan regulasi.</p>
                    <p class="text-sm font-semibold mb-2">Key Responsibilities:</p>
                    <ul class="text-sm space-y-2 list-disc list-inside text-white/95 mb-4">
                        <li>Operational Management: Mengarahkan aktivitas bisnis harian, mengoptimalkan workflow, dan menjaga lingkungan kerja yang aman dan efisien.</li>
                        <li>Financial Control: Mengawasi budgeting, forecasting pendapatan, mengelola pengeluaran, dan memantau profitabilitas.</li>
                        <li>Strategic Planning: Mengembangkan dan mengimplementasikan strategi untuk mencapai tujuan perusahaan.</li>
                        <li>Team Leadership: Merekrut, melatih, dan mengevaluasi staf, serta membangun lingkungan kerja positif.</li>
                        <li>Performance Analysis: Menganalisis KPI, menyiapkan laporan, dan menggunakan data untuk pengambilan keputusan.</li>
                        <li>Relationship Management: Mengelola hubungan dengan vendor, mitra, dan klien.</li>
                    </ul>
                    <p class="text-sm font-semibold mb-2">Common Performance Metrics:</p>
                    <ul class="text-sm space-y-1 list-disc list-inside text-white/95">
                        <li>Budget adherence</li>
                        <li>Operational efficiency metrics</li>
                        <li>Revenue growth</li>
                        <li>Employee performance and retention</li>
                    </ul>
                </div>
            </div>

            <!-- Row 3: Finance Manager -->
            <div data-aos="fade-up">
                <div class="rounded-2xl overflow-hidden shadow-lg bg-[#1E3A5F]/95 text-white p-8">
                    <h4 class="text-2xl font-bold mb-4">Finance Manager</h4>
                    <p class="text-white/95 mb-4">Mengawasi kesehatan keuangan organisasi melalui pengelolaan operasi akuntansi, laporan keuangan, analisis, dan kepatuhan regulasi. Tanggung jawab utama meliputi pengembangan anggaran, pengelolaan arus kas, dan pemberian saran keuangan strategis kepada manajemen senior untuk memaksimalkan profitabilitas.</p>
                    <p class="text-sm font-semibold mb-2">Key Responsibilities:</p>
                    <ul class="text-sm space-y-2 list-disc list-inside text-white/95">
                        <li>Financial Reporting and Analysis: Menyiapkan laporan keuangan bulanan, kuartalan, dan tahunan, serta menganalisis performa untuk memberikan insight kepada leadership.</li>
                        <li>Budgeting and Forecasting: Mengembangkan, mengimplementasikan, dan mengelola anggaran tahunan serta forecast keuangan.</li>
                        <li>Compliance and Risk Management: Memastikan kepatuhan terhadap regulasi keuangan, hukum, dan pajak, serta menjaga internal control.</li>
                        <li>Cash Flow Management: Memantau dan mengelola arus kas harian, perbankan, dan investasi.</li>
                        <li>Strategic Planning: Memberi saran kepada manajemen senior mengenai keputusan keuangan.</li>
                        <li>Team Leadership: Memimpin, mengawasi, dan membimbing tim akuntansi dan keuangan.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Company management -->
        <section class="container min-h-full py-12 px-4">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-lg font-semibold text-[#8A2BE2] mb-4">OUR TEAM</h2>
                <h3 class="text-4xl md:text-5xl font-bold text-[#2C3A47] leading-tight">
                    Company <span class="text-[#505CEE]">Management</span>
                </h3>
                <p class="text-lg text-[#64748B] mt-4 max-w-2xl mx-auto">
                    Meet the leaders driving our success
                </p>
            </div>

            <?php if (!empty($managements)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($managements as $index => $management): ?>
                        <div class="group" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                            <!-- Image -->
                            <div class="relative aspect-[3/4] w-full overflow-hidden rounded-2xl bg-slate-100 mb-6 shadow-md">
                                <?php if (!empty($management['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($management['image']); ?>"
                                        alt="<?php echo htmlspecialchars($management['fullname'] ?? 'Management'); ?>"
                                        class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
                                        onerror="this.src='https://ui-avatars.com/api/?name='+encodeURIComponent('<?php echo htmlspecialchars($management['fullname'] ?? 'User'); ?>')+'&background=505CEE&color=fff&size=400'">
                                <?php else: ?>
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-[#505CEE] to-[#8A2BE2] flex items-center justify-center">
                                        <div class="text-white text-center p-8">
                                            <i class='bx bx-user text-6xl mb-4 opacity-50'></i>
                                            <p class="text-lg font-medium opacity-75">No Photo</p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Overlay Gradient -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-[#2C3A47] mb-1">
                                    <?php echo htmlspecialchars($management['status'] ?? '-'); ?>
                                </h3>
                                <p class="text-[#505CEE] font-medium text-sm mb-3 uppercase tracking-wider">
                                    <?php echo htmlspecialchars($management['position']); ?>
                                </p>
                                <p class="text-[#64748B] leading-relaxed text-sm line-clamp-3">
                                    <?php echo htmlspecialchars($management['description']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                    <i class='bx bx-group text-6xl text-slate-300 mb-4 block'></i>
                    <h2 class="text-2xl font-semibold text-slate-700 mb-2">No Management Team</h2>
                    <p class="text-slate-500">
                        Data management belum tersedia.
                    </p>
                </div>
            <?php endif; ?>
        </section>

        <!-- Consultasi Banner -->
        <section class="container min-h-full py-12 px-4">
            <div
                class="rounded-3xl bg-gradient-to-r from-[#505CEE] to-[#8A2BE2] p-8 md:p-16 text-center shadow-2xl relative overflow-hidden">
                <!-- Decorative Elements -->
                <div
                    class="absolute top-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl translate-x-1/2 translate-y-1/2 pointer-events-none">
                </div>

                <div class="relative z-10 max-w-4xl mx-auto space-y-8">
                    <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight" data-aos="fade-down">
                        Need a Custom Solution?
                    </h2>

                    <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto leading-relaxed" data-aos="fade-down">
                        Our engineering team can design and build telecommunications products tailored to your specific
                        requirements and use cases.
                    </p>

                    <div class="flex flex-wrap justify-center gap-4 pt-4">
                        <a href="/cosultant" data-aos="fade-right"
                            class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-white text-[#505CEE] font-bold text-base shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                            Discuss Solutions <i class='bx bx-right-arrow-alt text-xl'></i>
                        </a>
                        <a href="/contact" data-aos="fade-left"
                            class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-white text-[#505CEE] font-bold text-base shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="js/main.js"></script>

    <?php require_once __DIR__ . '/layout/Footer.php'; ?>