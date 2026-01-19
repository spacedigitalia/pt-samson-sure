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