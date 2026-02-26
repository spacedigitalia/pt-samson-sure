<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/ContactController.php';

$controller = new ContactController($db);
$contacts = $controller->getAll();
?>
<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Get in touch with PT. SAMSON SURVEY UJI RISET EVALUASI. We are here to help you with your business needs. Contact us today.">
    <meta name="keywords" content="contact, PT. SAMSON SURVEY UJI RISET EVALUASI, business, services, help, support">
    <meta name="author" content="PT. SAMSON SURVEY UJI RISET EVALUASI">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.surenusantara.com/contact">
    <meta property="og:title" content="Contact Us - PT. SAMSON SURVEY UJI RISET EVALUASI">
    <meta property="og:description"
        content="Get in touch with PT. SAMSON SURVEY UJI RISET EVALUASI. We are here to help you with your business needs. Contact us today.">
    <meta property="og:image" content="https://www.surenusantara.com/assets/contact.jpg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.surenusantara.com/contact">
    <meta property="twitter:title" content="Contact Us - PT. SAMSON SURVEY UJI RISET EVALUASI">
    <meta property="twitter:description"
        content="Get in touch with PT. SAMSON SURVEY UJI RISET EVALUASI. We are here to help you with your business needs. Contact us today.">
    <meta property="twitter:image" content="https://www.surenusantara.com/assets/contact.jpg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.surenusantara.com/contact" />

    <title>Contact Us - PT. SAMSON SURVEY UJI RISET EVALUASI</title>

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
    <section class="container mx-auto py-10 px-4">
        <div class="overflow-hidden flex flex-col lg:flex-row">
            <!-- Image Side -->
            <div class="w-full rounded-3xl overflow-hidden lg:w-1/2 aspect-square relative" data-aos="zoom-out">
                <img src="/assets/contact.jpg" alt="The Plaza Office Tower"
                    class="absolute inset-0 w-full h-full object-cover">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent lg:bg-gradient-to-r lg:from-transparent lg:to-black/10">
                </div>
            </div>

            <!-- Content Side -->
            <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center bg-white">
                <div class="mb-8">
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight mb-2"
                        data-aos="fade-down">
                        PT. SAMSON SURVEY UJI RISET EVALUASI
                    </h1>
                    <h2 class="text-xl font-bold text-blue-600 tracking-wide" data-aos="fade-down">
                        (SAMSON SURE)
                    </h2>
                </div>

                <div class="space-y-8">
                    <!-- Address -->
                    <div class="flex items-start gap-4" data-aos="fade-up">
                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <i class='bx bx-map text-2xl text-blue-600'></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-1">Our Office</h3>
                            <p class="text-slate-600 leading-relaxed">
                                The Plaza Office Tower, 7th Floor,<br>
                                Jl. MH. Thamrin Kav. 28-30,<br>
                                Gondangdia, Menteng, Jakarta Pusat,<br>
                                Jakarta 10350, INDONESIA
                            </p>
                        </div>
                    </div>

                    <!-- Contact Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Phone -->
                        <div class="flex items-start gap-3" data-aos="fade-right">
                            <div
                                class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-phone text-xl text-slate-700'></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Phone</p>
                                <p class="text-slate-800 font-medium">(62) 21 5095 5000</p>
                            </div>
                        </div>

                        <!-- Fax -->
                        <div class="flex items-start gap-3" data-aos="fade-left">
                            <div
                                class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-printer text-xl text-slate-700'></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Fax</p>
                                <p class="text-slate-800 font-medium">(62) 21 8064 1000</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Maps Section -->
    <section class="container mx-auto py-4 px-4">
        <div class="" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-slate-900 mb-6 text-center">Find Us on Map</h2>
            <div class="rounded-2xl overflow-hidden shadow-lg">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.537340982221!2d106.822423!3d-6.192601!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f421229aaa1b%3A0x99d6f8a7abb690e2!2sGedung%20Perkantoran%20The%20Plaza!5e0!3m2!1sid!2sid!4v1768712326062!5m2!1sid!2sid"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Contact List Section -->
    <section class="bg-slate-50 py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Connect With Us</h2>
                <p class="text-slate-600 text-lg">We are available across various platforms. Choose the one that works
                    best for you.</p>
            </div>

            <?php if (!empty($contacts)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
                    <?php foreach ($contacts as $contact): ?>
                        <div class="group relative block">
                            <!-- Decorative background shadow effect -->
                            <div
                                class="absolute inset-0 bg-blue-600 rounded-2xl transform translate-x-0 translate-y-0 transition-all duration-300 opacity-0 group-hover:translate-x-2 group-hover:translate-y-2 group-hover:opacity-10">
                            </div>

                            <div
                                class="relative bg-white rounded-2xl border border-slate-200 p-8 shadow-sm transition-all duration-300 group-hover:border-blue-500/30 group-hover:shadow-lg flex flex-col">
                                <!-- Icon Header -->
                                <div class="flex items-start justify-between mb-6" data-aos="fade-in">
                                    <div
                                        class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                        <?php if (!empty($contact['image'])): ?>
                                            <img src="/<?php echo htmlspecialchars($contact['image']); ?>"
                                                alt="<?php echo htmlspecialchars($contact['title']); ?>"
                                                class="w-8 h-8 object-contain">
                                        <?php else: ?>
                                            <i class='bx bx-message-rounded-dots text-2xl'></i>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Content -->
                                <h3 data-aos="fade-in" id="title-<?php echo $contact['id']; ?>"
                                    class="text-xl font-bold text-slate-900 mb-3 line-clamp-1"
                                    title="<?php echo htmlspecialchars($contact['title']); ?>">
                                    <?php echo htmlspecialchars($contact['title']); ?>
                                </h3>
                                <p data-aos="fade-in" id="desc-<?php echo $contact['id']; ?>"
                                    class="text-slate-600 leading-relaxed mb-6 flex-grow line-clamp-2 transition-all duration-300">
                                    <?php echo nl2br(htmlspecialchars($contact['description'])); ?>
                                </p>

                                <!-- Footer/Action -->
                                <div class="pt-6 border-t border-slate-100 flex items-center justify-between overflow-hidden">
                                    <button data-aos="fade-right" onclick="toggleCard(<?php echo $contact['id']; ?>)"
                                        class="flex items-center text-slate-500 font-semibold text-sm hover:text-blue-600 transition-colors focus:outline-none">
                                        <span id="text-<?php echo $contact['id']; ?>">Learn More</span>
                                        <i id="icon-<?php echo $contact['id']; ?>"
                                            class='bx bx-chevron-down ml-1 text-xl transition-transform duration-300'></i>
                                    </button>

                                    <a href="<?php echo htmlspecialchars($contact['link']); ?>" target="_blank"
                                        data-aos="fade-left"
                                        class="flex items-center text-blue-600 font-semibold text-sm hover:text-blue-700 transition-colors">
                                        <span>Connect</span>
                                        <i class='bx bx-right-arrow-alt ml-1 text-xl'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <script>
                    function toggleCard(id) {
                        const desc = document.getElementById('desc-' + id);
                        const title = document.getElementById('title-' + id);
                        const icon = document.getElementById('icon-' + id);
                        const text = document.getElementById('text-' + id);

                        if (desc.classList.contains('line-clamp-2')) {
                            desc.classList.remove('line-clamp-2');
                            if (title) title.classList.remove('line-clamp-1');
                            text.textContent = 'Show Less';
                            icon.style.transform = 'rotate(180deg)';
                        } else {
                            desc.classList.add('line-clamp-2');
                            if (title) title.classList.add('line-clamp-1');
                            text.textContent = 'Learn More';
                            icon.style.transform = 'rotate(0deg)';
                        }
                    }
                </script>
            <?php else: ?>
                <div class="max-w-md mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 p-10 text-center">
                    <div
                        class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i class='bx bx-info-circle text-3xl'></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No Contact Channels</h3>
                    <p class="text-slate-500">We are currently updating our contact channels. Please check back soon or use
                        the office contact details above.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php require_once __DIR__ . '/../layout/Footer.php'; ?>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script src="/js/main.js"></script>
</body>

</html>