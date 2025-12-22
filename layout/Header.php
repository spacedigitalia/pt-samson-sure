<div class="text-xs sm:text-sm px-4">
    <div class="container mx-auto">
        <div class="flex items-center justify-between py-2 min-h-[40px]">
            <div class="flex items-center gap-2">
                <i class='bx bx-envelope text-orange-500 text-base'></i>
                <a href="mailto:operation@surenusantara.com"
                    class="text-[#333] underline hover:text-orange-500 transition-colors">operation@surenusantara.com</a>
            </div>

            <div class="flex items-center gap-2">
                <i class='bx bx-map-pin text-orange-500 text-base'></i>
                <span class="text-[#333]">Menteng, Jakarta Pusat</span>
                <a href="#"
                    class="text-orange-500 underline font-medium hover:text-[#e55a00] transition-colors">Change</a>
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
                                class="text-[#333] no-underline font-normal hover:text-orange-500 transition-colors">Home</a>
                        </li>
                        <li> <a href="/vision-mission"
                                class="text-[#333] no-underline font-normal hover:text-orange-500 transition-colors">Vision
                                Mission</a>
                        </li>
                        <li> <a href="/services"
                                class="text-[#333] no-underline font-normal hover:text-orange-500 transition-colors">Services</a>
                        </li>
                        <li> <a href="/cosultant"
                                class="text-[#333] no-underline font-normal hover:text-orange-500 transition-colors">Consultants</a>
                        </li>
                        <li> <a href="/contact"
                                class="text-[#333] no-underline font-normal hover:text-orange-500 transition-colors">Contact</a>
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
                        class="block text-lg text-[#333] no-underline font-normal hover:text-orange-500 transition-colors py-2">Home</a>
                </li>
                <li>
                    <a href="/vision-mission"
                        class="block text-lg text-[#333] no-underline font-normal hover:text-orange-500 transition-colors py-2">Vision
                        Mission</a>
                </li>
                <li>
                    <a href="/services"
                        class="block text-lg text-[#333] no-underline font-normal hover:text-orange-500 transition-colors py-2">Services</a>
                </li>
                <li>
                    <a href="/cosultant"
                        class="block text-lg text-[#333] no-underline font-normal hover:text-orange-500 transition-colors py-2">Consultants</a>
                </li>
                <li>
                    <a href="/contact"
                        class="block text-lg text-[#333] no-underline font-normal hover:text-orange-500 transition-colors py-2">Contact</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Mobile Menu Backdrop -->
<div id="mobile-menu-backdrop"
    class="fixed inset-0 bg-black/50 z-[1000] hidden opacity-0 transition-opacity duration-300 lg:hidden"></div>