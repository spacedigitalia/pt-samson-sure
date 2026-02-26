<?php

/**
 * Process Router for Company Management CRUD Operations
 * Uses CompanyManagementController directly
 */

session_start();

// Proteksi: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /dashboard/company-managements');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/CompanyManagementController.php';

$action = $_POST['action'] ?? '';
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'User ID tidak ditemukan.';
    header('Location: /dashboard/company-managements');
    exit;
}

$controller = new CompanyManagementController($db);

// Helper function to handle image upload
function handleImageUpload($file, $targetDir = '../../uploads/company-managements/', $oldImage = null)
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
    $fileName = uniqid('company_management_') . '.' . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Delete old image if it exists and is different
        if ($oldImage && file_exists('../../' . $oldImage)) {
            unlink('../../' . $oldImage);
        }
        return 'uploads/company-managements/' . $fileName;
    }

    throw new Exception('Gagal mengupload gambar.');
}

try {
    switch ($action) {
        case 'create':
            $position = trim($_POST['position'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null);

            $controller->create($position, $status, $image, $description, $userId);
            $_SESSION['success'] = 'Company management berhasil ditambahkan.';
            header('Location: /dashboard/company-managements');
            exit;

        case 'update':
            // Get first data for single data management
            $existing = $controller->getFirst();
            if (!$existing) {
                $_SESSION['error'] = 'Data tidak ditemukan.';
                header('Location: /dashboard/company-managements');
                exit;
            }

            $id = $existing['id'];
            $position = trim($_POST['position'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null, '../../uploads/company-managements/', $existing['image']);

            $controller->update((int)$id, $position, $status, $image, $description);
            $_SESSION['success'] = 'Company management berhasil diupdate.';
            header('Location: /dashboard/company-managements');
            exit;

        case 'delete':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID tidak ditemukan.';
                header('Location: /dashboard/company-managements');
                exit;
            }

            $controller->delete((int)$id);
            $_SESSION['success'] = 'Company management berhasil dihapus.';
            header('Location: /dashboard/company-managements');
            exit;

        default:
            $_SESSION['error'] = 'Aksi tidak dikenal.';
            header('Location: /dashboard/company-managements');
            exit;
    }
} catch (Exception $e) {
    error_log('Company Management CRUD error: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    $redirectUrl = '/dashboard/company-managements';
    if ($action === 'update' && isset($_POST['id'])) {
        $redirectUrl = 'edit.php?id=' . $_POST['id'];
    } elseif ($action === 'create') {
        $redirectUrl = 'create.php';
    }
    header('Location: ' . $redirectUrl);
    exit;
}
