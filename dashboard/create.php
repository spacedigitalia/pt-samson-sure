<?php
/**
 * Redirect: /dashboard/create.php has no meaning.
 * Redirect to dashboard home. Use specific module create pages instead, e.g.:
 * - /dashboard/interior/create.php
 * - /dashboard/struktur-organisasi/create.php
 */
header('Location: /dashboard');
exit;
