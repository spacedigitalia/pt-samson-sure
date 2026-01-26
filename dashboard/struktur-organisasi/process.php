<?php

/**
 * Process Router for Struktur Organisasi CRUD Operations
 * Uses StrukturOrganisasiController directly
 */

session_start();

// Proteksi: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /dashboard/struktur-organisasi');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/StrukturOrganisasiController.php';

$action = $_POST['action'] ?? '';
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'User ID tidak ditemukan.';
    header('Location: /dashboard/struktur-organisasi');
    exit;
}

$controller = new StrukturOrganisasiController($db);

// Helper function to handle image upload
function handleImageUpload($file, $targetDir = '../../uploads/struktur-organisasi/', $oldImage = null)
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
    $fileName = uniqid('struktur_organisasi_') . '.' . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Delete old image if it exists and is different
        if ($oldImage && file_exists('../../' . $oldImage)) {
            unlink('../../' . $oldImage);
        }
        return 'uploads/struktur-organisasi/' . $fileName;
    }

    throw new Exception('Gagal mengupload gambar.');
}

try {
    switch ($action) {
        case 'create':
            $image = handleImageUpload($_FILES['image'] ?? null);

            if (empty($image)) {
                throw new Exception('Gambar wajib diupload.');
            }

            $controller->create($image, $userId);
            $_SESSION['success'] = 'Gambar struktur organisasi berhasil diupload.';
            header('Location: /dashboard/struktur-organisasi');
            exit;

        case 'update':
            // Get existing data
            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new Exception('ID tidak valid.');
            }

            $existing = $controller->getById((int)$id);
            if (!$existing) {
                throw new Exception('Data tidak ditemukan.');
            }

            $image = handleImageUpload(
                $_FILES['image'] ?? null,
                '../../uploads/struktur-organisasi/',
                !empty($existing['image']) ? '../../' . $existing['image'] : null
            );

            // If no new image uploaded, keep the existing one
            $imagePath = $image ?? $existing['image'];

            if (empty($imagePath)) {
                throw new Exception('Gambar wajib diupload.');
            }

            $controller->update((int)$id, $imagePath);
            $_SESSION['success'] = 'Gambar struktur organisasi berhasil diupdate.';
            header('Location: /dashboard/struktur-organisasi');
            exit;

        case 'delete':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new Exception('ID tidak ditemukan.');
            }

            $controller->delete((int)$id);
            $_SESSION['success'] = 'Gambar struktur organisasi berhasil dihapus.';
            header('Location: /dashboard/struktur-organisasi');
            exit;

        default:
            $_SESSION['error'] = 'Aksi tidak dikenal.';
            header('Location: /dashboard/struktur-organisasi');
            exit;
    }
} catch (Exception $e) {
    error_log('Struktur Organisasi CRUD error: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    $redirectUrl = '/dashboard/struktur-organisasi';
    if ($action === 'update' && isset($_POST['id'])) {
        $redirectUrl = '/dashboard/struktur-organisasi/edit.php?id=' . $_POST['id'];
    }
    header('Location: ' . $redirectUrl);
    exit;
}
