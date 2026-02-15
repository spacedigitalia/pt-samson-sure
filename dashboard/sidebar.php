<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;
$active = $active ?? 'dashboard';

function navClass(string $key, string $active): string
{
    $base = 'flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold ';
    if ($key === $active) {
        return $base . 'bg-slate-900 text-white';
    }

    return $base . 'text-slate-700 hover:bg-slate-100';
}
?>
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-white text-slate-800 h-screen min-h-screen overflow-y-auto flex flex-col border-r border-slate-200 transform -translate-x-full transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0">
    <div class="px-6 py-6 border-b border-slate-200 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="h-14 w-14 rounded-xl overflow-hidden">
                <img src="/assets/logo.jpg" alt="PT Samson Sure" class="h-full w-full object-cover">
            </div>
            <div>
                <div class="text-base font-semibold leading-tight">PT Samson Sure</div>
                <div class="text-xs text-slate-500">Marine Surveyor & Consultant Company</div>
            </div>
        </div>
        <!-- Close button for mobile -->
        <button id="close-sidebar" class="lg:hidden text-slate-500 hover:text-slate-900">
            <i class='bx bx-x text-2xl'></i>
        </button>
    </div>

    <nav class="px-4 py-4 flex-1 space-y-1">
        <a href="/dashboard" class="<?php echo navClass('dashboard', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'dashboard' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>">
                <i class='bx bx-home text-base'></i>
            </span>
            Dashboard
        </a>

        <div class="pt-4 pb-2 px-3 text-[11px] uppercase tracking-wider text-slate-400">Workspace</div>

        <a href="/dashboard/home" class="<?php echo navClass('home', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'home' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx  bx-home'></i> </span>
            Home
        </a>

        <a href="/dashboard/about" class="<?php echo navClass('about', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'about-us' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-user'></i> </span>
            About
        </a>

        <a href="/dashboard/data-perseroan" class="<?php echo navClass('data-perseroan', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'data-perseroan' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-file'></i> </span>
            Data Perseroan
        </a>

        <a href="/dashboard/interior" class="<?php echo navClass('interior', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'interior' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-building'></i> </span>
            Interior
        </a>

        <a href="/dashboard/struktur-organisasi" class="<?php echo navClass('struktur-organisasi', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'struktur-organisasi' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-sitemap'></i> </span>
            Struktur Organisasi
        </a>

        <a href="/dashboard/company-managements" class="<?php echo navClass('company-managements', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'company-managements' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-building'></i> </span>
            Company Management
        </a>

        <a href="/dashboard/services" class="<?php echo navClass('services', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'services' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-cog'></i> </span>
            Services
        </a>

        <a href="/dashboard/consultants" class="<?php echo navClass('consultants', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'consultants' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-group'></i> </span>
            Consultants
        </a>

        <a href="/dashboard/vision-mission" class="<?php echo navClass('vision-mission', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'vision-mission' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-bulb'></i> </span>
            Visi & Misi
        </a>

        <a href="/dashboard/contact" class="<?php echo navClass('contact', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'contact' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-phone-call'></i> </span>
            Contact
        </a>

        <div class="pt-4 pb-2 px-3 text-[11px] uppercase tracking-wider text-slate-400">Account</div>

        <a href="/dashboard/profile" class="<?php echo navClass('profile', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'profile' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-user'></i> </span>
            Profile
        </a>

        <a href="/dashboard/logs" class="<?php echo navClass('logs', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'logs' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-history'></i> </span>
            Logs
        </a>

        <a href="/" class="<?php echo navClass('back-home', $active); ?>">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo $active === 'back-home' ? 'bg-white/15' : 'bg-slate-100 text-slate-700'; ?>"><i
                    class='bx bx-home'></i> </span>
            Back Home
        </a>
    </nav>

    <div class="px-4 py-4 border-t border-slate-200">
        <div class="flex items-center gap-3 px-3 py-3 rounded-2xl bg-slate-50 border border-slate-200">
            <div class="h-10 w-10 rounded-md overflow-hidden">
                <img src="/assets/logo.jpg" alt="profile" />
            </div>
            <div class="min-w-0">
                <div class="text-sm font-semibold truncate">
                    <?php echo htmlspecialchars($user['fullname'] ?? 'Admin'); ?></div>
                <div class="text-xs text-slate-500 truncate"><?php echo htmlspecialchars($user['email'] ?? ''); ?></div>
            </div>
        </div>

        <form action="/dashboard/process.php" method="POST" class="mt-3">
            <input type="hidden" name="action" value="logout">
            <button type="submit"
                class="w-full rounded-xl bg-rose-600 px-3 py-2.5 text-sm font-semibold text-white hover:bg-rose-700">
                Logout
            </button>
        </form>
    </div>
</aside>