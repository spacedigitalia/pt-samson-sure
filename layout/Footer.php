    <!-- Footer -->
    <footer class="bg-[#1e293b] text-white">
        <div class="container mx-auto px-4 py-12">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-8">
                <!-- Company Introduction Column -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <img src="/assets/logo.jpg" alt="PT Samson Sure" class="h-10 w-10 object-cover rounded-xl">
                        <h3 class="text-2xl font-bold">Samson Sure</h3>
                    </div>
                    <p class="text-sm text-gray-300 leading-relaxed mb-6">
                        Your trusted partner for comprehensive business solutions and services.
                    </p>
                    <!-- Social Media Icons -->
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-10 h-10 rounded-lg border border-gray-600 bg-[#2d3748] flex items-center justify-center text-white hover:bg-[#3d4758] hover:border-gray-500 transition-all">
                            <i class='bx bxl-facebook text-lg'></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-lg border border-gray-600 bg-[#2d3748] flex items-center justify-center text-white hover:bg-[#3d4758] hover:border-gray-500 transition-all">
                            <i class='bx bxl-twitter text-lg'></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-lg border border-gray-600 bg-[#2d3748] flex items-center justify-center text-white hover:bg-[#3d4758] hover:border-gray-500 transition-all">
                            <i class='bx bxl-linkedin text-lg'></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-lg border border-gray-600 bg-[#2d3748] flex items-center justify-center text-white hover:bg-[#3d4758] hover:border-gray-500 transition-all">
                            <i class='bx bxl-instagram text-lg'></i>
                        </a>
                    </div>
                </div>

                <!-- Services Column -->
                <div>
                    <h4 class="text-base font-semibold mb-4">Services</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <?php if (isset($services) && is_array($services) && !empty($services)): ?>
                            <?php foreach (array_slice($services, 0, 5) as $service): ?>
                                <li><a href="/services"
                                        class="hover:text-white transition-colors"><?php echo htmlspecialchars($service['title']); ?></a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="/services" class="hover:text-white transition-colors">Business Consulting</a></li>
                            <li><a href="/services" class="hover:text-white transition-colors">Management Services</a></li>
                            <li><a href="/services" class="hover:text-white transition-colors">Professional Solutions</a>
                            </li>
                        <?php endif; ?>
                        <li><a href="/services"
                                class="hover:text-white transition-colors font-medium text-blue-400">View All Services
                                -></a></li>
                    </ul>
                </div>

                <!-- Company Column -->
                <div>
                    <h4 class="text-base font-semibold mb-4">Company</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="/" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="/about" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="/vision-mission" class="hover:text-white transition-colors">Vision & Mission</a>
                        </li>
                        <li><a href="/cosultant" class="hover:text-white transition-colors">Consultants</a></li>
                        <li><a href="/contact" class="hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Contact Column -->
                <div>
                    <h4 class="text-base font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-start gap-3">
                            <i class='bx bx-map text-xl text-blue-400 mt-1'></i>
                            <span>Menteng, Jakarta Pusat</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class='bx bx-envelope text-xl text-blue-400'></i>
                            <a href="mailto:operation@surenusantara.com"
                                class="hover:text-white transition-colors">operation@surenusantara.com</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <!-- Copyright -->
                    <div class="text-sm text-gray-400">
                        <p>&copy; <?php echo date('Y'); ?> PT Samson Sure. All rights reserved.</p>
                    </div>

                    <!-- Legal Links -->
                    <div class="flex flex-wrap items-center gap-6 text-sm text-gray-400">
                        <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="/js/main.js"></script>
    </body>