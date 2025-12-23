<?php

/**
 * Process Router for Consultants CRUD Operations
 * Uses ConsultantsController directly
 */

session_start();

// Proteksi: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /dashboard/consultants');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/ConsultantsController.php';

$action = $_POST['action'] ?? '';
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'User ID tidak ditemukan.';
    header('Location: /dashboard/consultants');
    exit;
}

$controller = new ConsultantsController($db);

// Helper function to handle image upload
function handleImageUpload($file, $targetDir = '../../uploads/consultants/', $oldImage = null)
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
    $fileName = uniqid('consultant_') . '.' . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Delete old image if it exists and is different
        if ($oldImage && file_exists('../../' . $oldImage)) {
            unlink('../../' . $oldImage);
        }
        return 'uploads/consultants/' . $fileName;
    }

    throw new Exception('Gagal mengupload gambar.');
}

try {
    switch ($action) {
        case 'create':
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null);

            $controller->create($title, $description, $image, $userId);
            $_SESSION['success'] = 'Consultant berhasil ditambahkan.';
            header('Location: /dashboard/consultants');
            exit;

        case 'update':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID tidak ditemukan.';
                header('Location: /dashboard/consultants');
                exit;
            }

            $existing = $controller->getById((int)$id);
            if (!$existing) {
                $_SESSION['error'] = 'Data tidak ditemukan.';
                header('Location: /dashboard/consultants');
                exit;
            }

            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null, '../../uploads/consultants/', $existing['image']);

            $controller->update((int)$id, $title, $description, $image);
            $_SESSION['success'] = 'Consultant berhasil diupdate.';
            header('Location: /dashboard/consultants');
            exit;

        case 'delete':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID tidak ditemukan.';
                header('Location: /dashboard/consultants');
                exit;
            }

            $controller->delete((int)$id);
            $_SESSION['success'] = 'Consultant berhasil dihapus.';
            header('Location: /dashboard/consultants');
            exit;

        default:
            $_SESSION['error'] = 'Aksi tidak dikenal.';
            header('Location: /dashboard/consultants');
            exit;
    }
} catch (Exception $e) {
    error_log('Consultants CRUD error: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    $redirectUrl = '/dashboard/consultants';
    if ($action === 'update' && isset($_POST['id'])) {
        $redirectUrl = 'edit.php?id=' . $_POST['id'];
    } elseif ($action === 'create') {
        $redirectUrl = 'create.php';
    }
    header('Location: ' . $redirectUrl);
    exit;
}
