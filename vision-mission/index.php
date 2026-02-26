<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/VisiMisiController.php';

$controller = new VisiMisiController($db);
$visions = $controller->getAll('vision');
$missions = $controller->getAll('mission');
?>
<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Learn about the Vision and Mission of Surenusantara. We strive to provide professional services with quality, safety, and timeliness.">
    <meta name="keywords" content="vision, mission, company values, surenusantara, goals, objectives">
    <meta name="author" content="Surenusantara">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.surenusantara.com/vision-mission">
    <meta property="og:title" content="Vision & Mission - Surenusantara">
    <meta property="og:description"
        content="Learn about the Vision and Mission of Surenusantara. We strive to provide professional services with quality, safety, and timeliness.">
    <meta property="og:image" content="https://www.surenusantara.com/assets/logo.jpg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.surenusantara.com/vision-mission">
    <meta property="twitter:title" content="Vision & Mission - Surenusantara">
    <meta property="twitter:description"
        content="Learn about the Vision and Mission of Surenusantara. We strive to provide professional services with quality, safety, and timeliness.">
    <meta property="twitter:image" content="https://www.surenusantara.com/assets/logo.jpg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.surenusantara.com/vision-mission" />

    <title>Vision & Mission - Surenusantara</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Favicon -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/globals.css">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Breadcrumb Structured Data -->
    <script src="/js/breadchumb.js"></script>
</head>

<body>
    <?php require_once __DIR__ . '/../layout/Header.php'; ?>
    <!-- Hero Section -->
    <div class="relative h-[50vh] md:h-[70vh] flex items-center justify-center bg-cover bg-center bg-no-repeat"
        style="background-image: url('../assets/bg.jpg'); background-attachment: fixed;">
        <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50 z-10"></div>
        <div class="container mx-auto text-center z-20 px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight uppercase tracking-wider"
                data-aos="fade-up">Vision &
                Mission</h1>
            <p class="text-lg text-white mt-4 max-w-2xl mx-auto font-light" data-aos="fade-up">
                Guiding our path towards excellence and professional service delivery.
            </p>
        </div>
    </div>

    <section class="container mx-auto py-16 px-4 sm:px-6 lg:px-8 space-y-24">
        <!-- Vision Section (Top) -->
        <div class="relative">
            <div class="text-center mb-12" data-aos="fade-up">
                <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm">Our Future</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Our Vision</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <?php if (!empty($visions)): ?>
                <div class="space-y-16">
                    <?php foreach ($visions as $index => $vision): ?>
                        <div class="flex flex-col md:flex-row items-center gap-8 lg:gap-16">
                            <!-- Image (Left) -->
                            <div class="flex-1 order-1 w-full" data-aos="fade-right">
                                <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                                    <div
                                        class="absolute inset-0 bg-blue-600/10 group-hover:bg-transparent transition-colors duration-300 z-10">
                                    </div>
                                    <?php if (!empty($vision['image'])): ?>
                                        <img src="/<?php echo htmlspecialchars($vision['image']); ?>" alt="Vision Image"
                                            class="w-full h-[300px] md:h-[400px] object-cover transform group-hover:scale-105 transition-transform duration-700">
                                    <?php else: ?>
                                        <div class="w-full h-[300px] md:h-[400px] bg-slate-100 flex items-center justify-center">
                                            <i class='bx bx-image text-6xl text-slate-300'></i>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Decorative Element -->
                                    <div
                                        class="absolute -top-6 -right-6 w-24 h-24 bg-blue-100 rounded-full blur-2xl opacity-60 z-0">
                                    </div>
                                </div>
                            </div>

                            <!-- Text Content (Right) -->
                            <div class="flex-1 order-2 space-y-6" data-aos="fade-left">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 mt-1">
                                        <i class='bx bx-show text-2xl'></i>
                                    </div>
                                    <div class="prose prose-lg text-slate-600 flex-1">
                                        <p class="leading-relaxed text-lg">
                                            <?php echo nl2br(htmlspecialchars($vision['description'])); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center p-12 bg-slate-50 rounded-3xl border border-slate-200">
                    <p class="text-slate-500 italic">Vision statement is currently being updated.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Mission Section (Bottom) -->
        <div class="relative">
            <div class="text-center mb-12" data-aos="fade-up">
                <span class="text-purple-600 font-semibold tracking-wider uppercase text-sm">Our Purpose</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Our Mission</h2>
                <div class="w-20 h-1 bg-purple-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <?php if (!empty($missions)): ?>
                <div class="space-y-16">
                    <?php foreach ($missions as $index => $mission): ?>
                        <div class="flex flex-col md:flex-row items-center gap-8 lg:gap-16">
                            <!-- Text Content (Left) -->
                            <div class="flex-1 order-2 md:order-1 space-y-6" data-aos="fade-right">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 mt-1">
                                        <i class='bx bx-target-lock text-2xl'></i>
                                    </div>
                                    <div class="prose prose-lg text-slate-600 flex-1">
                                        <p class="leading-relaxed text-lg">
                                            <?php echo nl2br(htmlspecialchars($mission['description'])); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Image (Right) -->
                            <div class="flex-1 order-1 md:order-2 w-full" data-aos="fade-left">
                                <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                                    <div
                                        class="absolute inset-0 bg-purple-600/10 group-hover:bg-transparent transition-colors duration-300 z-10">
                                    </div>
                                    <?php if (!empty($mission['image'])): ?>
                                        <img src="/<?php echo htmlspecialchars($mission['image']); ?>" alt="Mission Image"
                                            class="w-full h-[300px] md:h-[400px] object-cover transform group-hover:scale-105 transition-transform duration-700">
                                    <?php else: ?>
                                        <div class="w-full h-[300px] md:h-[400px] bg-slate-100 flex items-center justify-center">
                                            <i class='bx bx-image text-6xl text-slate-300'></i>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Decorative Element -->
                                    <div
                                        class="absolute -bottom-6 -left-6 w-24 h-24 bg-purple-100 rounded-full blur-2xl opacity-60 z-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center p-12 bg-slate-50 rounded-3xl border border-slate-200">
                    <p class="text-slate-500 italic">Mission statement is currently being updated.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-slate-900 py-16">
        <div class="container mx-auto px-4 text-center" data-aos="zoom-in">
            <h2 class="text-3xl font-bold text-white mb-6">Ready to work with us?</h2>
            <p class="text-slate-300 mb-8 max-w-2xl mx-auto">
                Join us in our journey to deliver excellence. Contact us today to learn more about our services.
            </p>
            <a href="../contact"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-600/30">
                Contact Us
            </a>
        </div>
    </section>

    <?php require_once __DIR__ . '/../layout/Footer.php'; ?>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script src="/js/main.js"></script>
</body>

</html>