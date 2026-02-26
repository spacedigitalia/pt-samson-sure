<?php

/**
 * Process Router for Home CRUD Operations
 * Uses HomeController directly
 */

session_start();

// Proteksi: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: home.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/HomeController.php';

$action = $_POST['action'] ?? '';
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'User ID tidak ditemukan.';
    header('Location: home.php');
    exit;
}

$controller = new HomeController($db);

// Helper function to handle image upload
function handleImageUpload($file, $targetDir = '../../uploads/home/', $oldImage = null)
{
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return $oldImage;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('Tipe file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
    }

    if ($file['size'] > $maxSize) {
        throw new Exception('Ukuran file terlalu besar. Maksimal 2MB.');
    }

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid('home_') . '.' . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Delete old image if it exists and is different
        if ($oldImage && file_exists('../../' . $oldImage)) {
            unlink('../../' . $oldImage);
        }
        return 'uploads/home/' . $fileName;
    }

    throw new Exception('Gagal mengupload gambar.');
}

try {
    switch ($action) {
        case 'create':
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $text = trim($_POST['text'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null);

            if (empty($title) || empty($description) || empty($text)) {
                throw new Exception('Harap lengkapi semua field termasuk gambar');
            }

            $controller->create($title, $description, $text, $image, $userId);
            $_SESSION['success'] = 'Home content berhasil ditambahkan.';
            header('Location: /dashboard/home');
            exit;

        case 'update':
            // Get first data for single data management
            $existing = $controller->getFirst();
            if (!$existing) {
                $_SESSION['error'] = 'Data tidak ditemukan.';
                header('Location: /dashboard/home');
                exit;
            }

            $id = $existing['id'];
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $text = trim($_POST['text'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null, '../../uploads/home/', $existing['image']);

            $controller->update((int)$id, $title, $description, $text, $image);
            $_SESSION['success'] = 'Home content berhasil diupdate.';
            header('Location: /dashboard/home');
            exit;

        case 'delete':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID tidak ditemukan.';
                header('Location: /dashboard/home');
                exit;
            }

            $controller->delete((int)$id);
            $_SESSION['success'] = 'Home content berhasil dihapus.';
            header('Location: /dashboard/home');
            exit;

        default:
            $_SESSION['error'] = 'Aksi tidak dikenal.';
            header('Location: /dashboard/home');
            exit;
    }
} catch (Exception $e) {
    error_log('Home CRUD error: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    $redirectUrl = '/dashboard/home';
    if ($action === 'update' && isset($_POST['id'])) {
        $redirectUrl = '/dashboard/home/edit/?action=edit&id=' . $_POST['id'];
    }
    header('Location: ' . $redirectUrl);
    exit;
}
