<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/ServicesController.php';

$servicesController = new ServicesController($db);
$services = $servicesController->getAll();
?>
<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Explore our comprehensive range of business services designed to help your company grow and succeed in today's competitive market.">
    <meta name="keywords" content="business services, professional services, consulting, solutions, business growth">
    <meta name="author" content="PT. SAMSON SURVEY UJI RISET EVALUASI">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.surenusantara.com/services">
    <meta property="og:title" content="Our Services - PT. SAMSON SURVEY UJI RISET EVALUASI">
    <meta property="og:description"
        content="Explore our comprehensive range of business services designed to help your company grow and succeed in today's competitive market.">
    <meta property="og:image" content="https://www.surenusantara.com/assets/services.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.surenusantara.com/services">
    <meta property="twitter:title" content="Our Services - PT. SAMSON SURVEY UJI RISET EVALUASI">
    <meta property="twitter:description"
        content="Explore our comprehensive range of business services designed to help your company grow and succeed in today's competitive market.">
    <meta property="twitter:image" content="https://www.surenusantara.com/assets/services.png">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.surenusantara.com/services" />

    <title>Our Services - PT. SAMSON SURVEY UJI RISET EVALUASI</title>

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

<?php require_once __DIR__ . '/../layout/Header.php'; ?>
<!-- Hero Section -->
<div class="relative h-[50vh] md:h-[70vh] flex items-center justify-center bg-cover bg-center bg-no-repeat"
    style="background-image: url('/assets/bg.jpg'); background-attachment: fixed;">
    <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50 z-10"></div>
    <div class="container mx-auto text-center z-20" data-aos="fade-up">
        <h1 class="text-2xl md:text-4xl font-bold text-white leading-tight">OUR SERVICES<h1>
                <p class="text-sm md:text-lg text-white mt-4 max-w-2xl mx-auto px-2">
                    It is main priority of PT. SAMSON SURVEY UJI RISET EVALUASI to provide professional services to
                    the customers who would require quality, safety & in time as client’s requirement and needs, to
                    that respect we would try to create a good working relationship with our customer.
                </p>
    </div>
</div>

<section class="container min-h-full mx-auto py-10 px-4 sm:px-0">
    <?php if (!empty($services)): ?>
        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
            <?php foreach ($services as $service): ?>
                <div class="group relative block">
                    <!-- Decorative background shadow effect -->
                    <div
                        class="absolute inset-0 bg-blue-600 rounded-2xl transform translate-x-0 translate-y-0 transition-all duration-300 opacity-0 group-hover:translate-x-2 group-hover:translate-y-2 group-hover:opacity-10">
                    </div>

                    <div
                        class="relative bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 group-hover:border-blue-500/30 group-hover:shadow-lg flex flex-col overflow-hidden">
                        <!-- Service Image -->
                        <div class="relative h-64 overflow-hidden bg-slate-100" data-aos="zoom-out">
                            <?php if ($service['image']): ?>
                                <img src="/<?php echo htmlspecialchars($service['image']); ?>"
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
                            <h3 data-aos="fade-up" id="service-title-<?php echo $service['id']; ?>"
                                class="text-xl font-bold text-slate-900 mb-3 line-clamp-1"
                                title="<?php echo htmlspecialchars($service['title']); ?>">
                                <?php echo htmlspecialchars($service['title']); ?>
                            </h3>

                            <p data-aos="fade-up" id="service-desc-<?php echo $service['id']; ?>"
                                class="text-slate-600 leading-relaxed mb-4 flex-grow line-clamp-2 transition-all duration-300">
                                <?php echo nl2br(htmlspecialchars($service['description'])); ?>
                            </p>

                            <!-- Footer/Action -->
                            <div class="border-t border-slate-100 flex items-center justify-between mt-auto" data-aos="fade-up">
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
<?php require_once __DIR__ . '/../layout/Footer.php'; ?>
<!-- AOS Animation JS -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script src="/js/main.js"></script>
</body>

</html>