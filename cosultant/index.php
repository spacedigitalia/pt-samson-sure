<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/ConsultantsController.php';

// Initialize controller
try {
    $consultantsController = new ConsultantsController($db);

    // Get all consultants
    $consultants = $consultantsController->getAll();
} catch (Exception $e) {
    $error = 'Error loading consultants: ' . $e->getMessage();
    error_log($error);
    $consultants = [];
}
?>
<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Meet our team of expert consultants dedicated to helping your business grow and succeed with professional guidance and solutions.">
    <meta name="keywords"
        content="business consultants, professional consultants, business advisors, strategic consulting, management consultants">
    <meta name="author" content="PT. SAMSON SURVEY UJI RISET EVALUASI">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.surenusantara.com/cosultant">
    <meta property="og:title" content="Our Expert Consultants - PT. SAMSON SURVEY UJI RISET EVALUASI">
    <meta property="og:description"
        content="Meet our team of expert consultants dedicated to helping your business grow and succeed with professional guidance and solutions.">
    <meta property="og:image" content="https://www.surenusantara.com/assets/cosultant.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.surenusantara.com/cosultant">
    <meta property="twitter:title" content="Our Expert Consultants - PT. SAMSON SURVEY UJI RISET EVALUASI">
    <meta property="twitter:description"
        content="Meet our team of expert consultants dedicated to helping your business grow and succeed with professional guidance and solutions.">
    <meta property="twitter:image" content="https://www.surenusantara.com/assets/cosultant.png">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.surenusantara.com/cosultant" />

    <title>Our Expert Consultants - PT. SAMSON SURVEY UJI RISET EVALUASI</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Favicon -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/globals.css">

    <!-- Breadcrumb Structured Data -->
    <script src="/js/breadchumb.js"></script>

    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
    <?php require_once __DIR__ . '/../layout/Header.php'; ?>
    <!-- Hero Section -->
    <div class="relative h-[50vh] md:h-[70vh] flex items-center justify-center bg-cover bg-center bg-no-repeat"
        style="background-image: url('/assets/bg.jpg'); background-attachment: fixed;">
        <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50 z-10"></div>
        <div class="container mx-auto text-center z-20 px-4" data-aos="fade-up">
            <h1 class="text-2xl md:text-4xl md:text-5xl font-bold text-white leading-tight">MARITIME CONSULTANT</h1>
            <p class="text-sm md:text-lg md:text-xl text-white mt-4 max-w-2xl mx-auto">
                Meet our team of experienced professionals dedicated to your business success
            </p>
        </div>
    </div>

    <section class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <?php if (isset($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error text-red-500 text-2xl'></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <?php echo htmlspecialchars($error); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($consultants)): ?>
            <!-- Consultants Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
                <?php foreach ($consultants as $consultant): ?>
                    <div class="group relative block">
                        <!-- Decorative background shadow effect -->
                        <div
                            class="absolute inset-0 bg-blue-600 rounded-2xl transform translate-x-0 translate-y-0 transition-all duration-300 opacity-0 group-hover:translate-x-2 group-hover:translate-y-2 group-hover:opacity-10">
                        </div>

                        <div
                            class="relative bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 group-hover:border-blue-500/30 group-hover:shadow-lg flex flex-col overflow-hidden">
                            <!-- Consultant Image -->
                            <div class="relative h-72 overflow-hidden bg-gray-100" data-aos="zoom-out">
                                <?php if (!empty($consultant['image'])): ?>
                                    <img src="/<?php echo htmlspecialchars($consultant['image']); ?>"
                                        alt="<?php echo htmlspecialchars($consultant['title']); ?>"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                        onerror="this.src='https://ui-avatars.com/api/?name='+encodeURIComponent('<?php echo htmlspecialchars($consultant['title']); ?>')+'&background=505CEE&color=fff&size=400'">
                                <?php else: ?>
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center">
                                        <div class="text-white text-center p-8">
                                            <i class='bx bx-user text-6xl mb-4 opacity-50'></i>
                                            <p class="text-lg font-medium opacity-75">No Photo</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Consultant Details -->
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 data-aos="fade-up" id="consultant-title-<?php echo $consultant['id']; ?>"
                                    class="text-xl font-bold text-[#2C3A47] mb-3 line-clamp-1"
                                    title="<?php echo htmlspecialchars($consultant['title']); ?>">
                                    <?php echo htmlspecialchars($consultant['title']); ?>
                                </h3>

                                <p data-aos="fade-up" id="consultant-desc-<?php echo $consultant['id']; ?>"
                                    class="text-[#64748B] leading-relaxed text-sm flex-grow mb-2 line-clamp-2 transition-all duration-300">
                                    <?php echo nl2br(htmlspecialchars($consultant['description'])); ?>
                                </p>

                                <!-- Footer/Action -->
                                <div data-aos="fade-up"
                                    class="border-t border-slate-100 flex items-center justify-between mt-auto">
                                    <button onclick="toggleConsultantCard(<?php echo $consultant['id']; ?>)"
                                        class="flex items-center text-slate-500 font-semibold text-sm hover:text-blue-600 transition-colors focus:outline-none">
                                        <span id="consultant-text-<?php echo $consultant['id']; ?>">Learn More</span>
                                        <i id="consultant-icon-<?php echo $consultant['id']; ?>"
                                            class='bx bx-chevron-down ml-1 text-xl transition-transform duration-300'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                <i class='bx bx-user-x text-6xl text-slate-300 mb-4 block'></i>
                <h2 class="text-2xl font-semibold text-slate-700 mb-2">No Consultants Found</h2>
                <p class="text-slate-500 mb-4">
                    No consultants available at the moment. Please check back later.
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