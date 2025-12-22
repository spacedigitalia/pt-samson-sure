<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Surenusantara</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style/globals.css">

    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
    <?php require_once __DIR__ . '/layout/Header.php'; ?>

    <main class="overflow-hidden px-4">
        <section class="container min-h-[70vh] flex flex-col items-center justify-center py-20 text-center">
            <div class="mb-8 relative" data-aos="fade-up">
                <div
                    class="text-[150px] font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#505CEE] to-[#8A2BE2] leading-none opacity-20 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 select-none">
                    404
                </div>
                <div class="relative z-10 bg-white p-6 rounded-full shadow-sm border border-slate-100">
                    <i class='bx bx-error-circle text-8xl text-[#505CEE]'></i>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold text-[#2C3A47] mb-4" data-aos="fade-up" data-aos-delay="100">
                Page Not Found
            </h1>

            <p class="text-lg text-[#64748B] max-w-lg mx-auto mb-10" data-aos="fade-up" data-aos-delay="200">
                Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman tersebut telah dipindahkan atau
                dihapus.
            </p>

            <div class="flex gap-4" data-aos="fade-up" data-aos-delay="300">
                <a href="/"
                    class="inline-flex items-center gap-2 px-8 py-3 rounded-lg bg-gradient-to-r from-[#505CEE] to-[#8A2BE2] text-white font-semibold text-base shadow-md hover:shadow-lg transition-all hover:scale-105">
                    <i class='bx bx-home-alt'></i> Kembali ke Beranda
                </a>
            </div>
        </section>
    </main>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <?php require_once __DIR__ . '/layout/Footer.php'; ?>