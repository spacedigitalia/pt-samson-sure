<?php
// Get current page path
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
$currentPath = parse_url($currentPath, PHP_URL_PATH);

// Function to check if link is active
function isActive($path, $currentPath)
{
    if ($path === '/' && $currentPath === '/') {
        return true;
    }
    if ($path !== '/' && strpos($currentPath, $path) === 0) {
        return true;
    }
    return false;
}

$contactPhoneTel = '+62816738272';
$contactWhatsAppDigits = '62816738272';
$contactEmail = 'Malik@surenusantara.com ';
?>

<div class="text-xs sm:text-sm px-4">
    <div class="container mx-auto">
        <div class="flex items-center justify-between py-2 min-h-[40px]">
            <div class="flex items-center gap-2">
                <i class='bx bx-envelope text-[#505CEE] text-base'></i>
                <a href="mailto:operation@surenusantara.com"
                    class="text-[#333] underline hover:text-[#505CEE] transition-colors">operation@surenusantara.com</a>
            </div>

            <div class="flex items-center gap-2">
                <i class='bx bx-map-pin text-[#505CEE] text-base'></i>
                <span class="text-[#333]">Menteng, Jakarta Pusat</span>
                <a href="https://maps.app.goo.gl/X27jv2V31XysCqqi8?g_st=aw"
                    target="_blank"
                    class="text-[#505CEE] underline font-medium hover:text-[#505CEE] transition-colors">Change</a>
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<header id="main-nav">
    <div class="bg-white sticky top-0 z-[1000] transition-all duration-300 ease-in-out px-4">
        <div class="container mx-auto">
            <div class="flex items-center justify-between h-20 min-h-[80px]">
                <div class="flex items-center justify-center gap-2">
                    <img src="/assets/logo.jpg" alt="PT Samson Sure" class="h-10 w-10 object-cover rounded-xl">
                    <span class="text-xl font-bold">Samson Sure</span>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-6">
                    <ul class="flex items-center gap-6 text-sm">
                        <li> <a href="/"
                                class="<?php echo isActive('/', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors">Home</a>
                        </li>
                        <li> <a href="/about"
                                class="<?php echo isActive('/about', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors">About</a>
                        </li>
                        <li> <a href="/vision-mission"
                                class="<?php echo isActive('/vision-mission', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors">Vision
                                Mission</a>
                        </li>
                        <li> <a href="/services"
                                class="<?php echo isActive('/services', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors">Services</a>
                        </li>
                        <li> <a href="/cosultant"
                                class="<?php echo isActive('/cosultant', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors">Consultants</a>
                        </li>
                        <li> <a href="/contact"
                                class="<?php echo isActive('/contact', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors">Contact</a>
                        </li>
                    </ul>
                </nav>

                <!-- Hamburger Button (Mobile) -->
                <button id="hamburger-btn"
                    class="lg:hidden text-[#333] hover:text-orange-500 transition-colors focus:outline-none">
                    <i class='bx bx-menu text-3xl'></i>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Navigation Menu -->
<div id="mobile-menu"
    class="fixed inset-0 z-[1001] bg-white transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden">
    <div class="flex flex-col h-full">
        <!-- Mobile Menu Header -->
        <div class="flex items-center justify-between px-4 py-4 border-b border-[#e5e5e5]">
            <div class="flex items-center gap-2">
                <img src="/assets/logo.jpg" alt="Samson Sure" class="h-10 w-10 object-cover rounded-xl">
                <span class="text-xl font-bold">Samson Sure</span>
            </div>
            <button id="close-mobile-menu"
                class="text-[#333] hover:text-orange-500 transition-colors focus:outline-none">
                <i class='bx bx-x text-3xl'></i>
            </button>
        </div>

        <!-- Mobile Menu Navigation -->
        <nav class="flex-1 px-4 py-6">
            <ul class="flex flex-col gap-4">
                <li>
                    <a href="/"
                        class="block text-lg <?php echo isActive('/', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors py-2">Home</a>
                </li>
                <li>
                    <a href="/about"
                        class="block text-lg <?php echo isActive('/about', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors py-2">About</a>
                </li>
                <li>
                    <a href="/vision-mission"
                        class="block text-lg <?php echo isActive('/vision-mission', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors py-2">Vision
                        Mission</a>
                </li>
                <li>
                    <a href="/services"
                        class="block text-lg <?php echo isActive('/services', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors py-2">Services</a>
                </li>
                <li>
                    <a href="/cosultant"
                        class="block text-lg <?php echo isActive('/cosultant', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors py-2">Consultants</a>
                </li>
                <li>
                    <a href="/contact"
                        class="block text-lg <?php echo isActive('/contact', $currentPath) ? 'text-[#505CEE] font-semibold' : 'text-[#333] font-normal'; ?> no-underline hover:text-[#505CEE] transition-colors py-2">Contact</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Mobile Menu Backdrop -->
<div id="mobile-menu-backdrop"
    class="fixed inset-0 bg-black/50 z-[1000] hidden opacity-0 transition-opacity duration-300 lg:hidden"></div>

<!-- Mobile bottom contact bar: hidden at top of page; slide + fade in after scroll (see main.js) -->
<nav id="mobile-contact-bar"
    class="sm:hidden fixed bottom-0 left-0 right-0 z-[998] bg-white shadow-[0_-4px_14px_rgba(0,0,0,0.08)] border-t border-[#eee] pb-[env(safe-area-inset-bottom)] translate-y-full opacity-0 pointer-events-none transition-all duration-300 ease-in-out"
    aria-label="Kontak cepat"
    aria-hidden="true">
    <div class="flex items-center justify-between gap-2 px-2 py-2 max-w-lg mx-auto min-h-[3.25rem]">
        <a href="https://wa.me/<?php echo htmlspecialchars($contactWhatsAppDigits); ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="flex flex-1 flex-col items-center gap-0.5 min-w-0 py-1 text-[#333] no-underline hover:text-[#505CEE] active:opacity-80">
            <i class="bx bxl-whatsapp text-lg leading-none"></i>
            <span class="text-[10px] leading-tight font-medium">Whatsapp</span>
        </a>
        <a href="tel:<?php echo htmlspecialchars($contactPhoneTel); ?>"
            class="flex flex-1 flex-col items-center gap-0.5 min-w-0 py-1 text-[#333] no-underline hover:text-[#505CEE] active:opacity-80">
            <i class="bx bx-mobile text-lg leading-none"></i>
            <span class="text-[10px] leading-tight font-medium">Telepon</span>
        </a>
        <button type="button"
            id="mobile-contact-bar-scroll-top"
            class="flex flex-col items-center justify-center shrink-0 mx-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#505CEE] focus-visible:ring-offset-2 rounded-xl"
            aria-label="Gulir ke atas">
            <span
                class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#505CEE] text-white shadow-md hover:bg-[#3d47c4] active:scale-95 transition-transform">
                <i class="bx bx-chevron-up text-lg leading-none"></i>
            </span>
        </button>
        <a href="mailto:<?php echo htmlspecialchars($contactEmail); ?>"
            class="flex flex-1 flex-col items-center gap-0.5 min-w-0 py-1 text-[#333] no-underline hover:text-[#505CEE] active:opacity-80">
            <i class="bx bx-envelope text-lg leading-none"></i>
            <span class="text-[10px] leading-tight font-medium">Email</span>
        </a>
        <a href="/contact"
            class="flex flex-1 flex-col items-center gap-0.5 min-w-0 py-1 text-[#333] no-underline hover:text-[#505CEE] active:opacity-80">
            <i class="bx bx-message-dots text-lg leading-none"></i>
            <span class="text-[10px] leading-tight font-medium">Permintaan</span>
        </a>
    </div>
</nav>

<!-- sm+ (640px): kotak kontak & tombol atas terpisah (dots/permintaan tidak digabung dengan chevron) -->
<aside
    class="hidden sm:flex flex-col fixed right-4 top-1/2 -translate-y-1/2 z-[998] w-[4.25rem] gap-2 transition-all duration-300 ease-in-out"
    aria-label="Kontak cepat">
    <div
        class="flex flex-col rounded-xl border border-[#e5e5e5] bg-white shadow-md overflow-hidden">
        <a href="https://wa.me/<?php echo htmlspecialchars($contactWhatsAppDigits); ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="flex flex-col items-center justify-center gap-1.5 py-3 px-1.5 text-center text-[#333] no-underline border-b border-[#eee] hover:bg-slate-50 transition-colors">
            <i class="bx bxl-whatsapp text-lg leading-none text-[#25D366]"></i>
            <span class="text-[11px] font-medium leading-tight">Whatsapp</span>
        </a>
        <a href="tel:<?php echo htmlspecialchars($contactPhoneTel); ?>"
            target="_blank"
            class="flex flex-col items-center justify-center gap-1.5 py-3 px-1.5 text-center text-[#333] no-underline border-b border-[#eee] hover:bg-slate-50 transition-colors">
            <i class="bx bx-mobile text-lg leading-none text-[#333]"></i>
            <span class="text-[11px] font-medium leading-tight">Telepon</span>
        </a>
        <a href="mailto:<?php echo htmlspecialchars($contactEmail); ?>"
            target="_blank"
            class="flex flex-col items-center justify-center gap-1.5 py-3 px-1.5 text-center text-[#333] no-underline border-b border-[#eee] hover:bg-slate-50 transition-colors">
            <i class="bx bx-envelope text-lg leading-none text-orange-500"></i>
            <span class="text-[11px] font-medium leading-tight">Email</span>
        </a>
    </div>
    <button type="button"
        id="desktop-contact-rail-scroll-top"
        class="flex flex-col items-center justify-center gap-0.5 py-2.5 px-1.5 w-full rounded-xl border border-[#3d47c4] bg-[#505CEE] text-white shadow-md hover:bg-[#3d47c4] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#505CEE] focus-visible:ring-offset-2"
        aria-label="Gulir ke atas">
        <i class="bx bx-chevron-up text-base leading-none"></i>
        <span class="text-[10px] font-medium leading-tight">Atas</span>
    </button>
</aside>