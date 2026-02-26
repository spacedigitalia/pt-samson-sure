<?php

/**
 * Process Router for Interior CRUD Operations
 * Uses InteriorController directly
 */

session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /dashboard/interior');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/InteriorController.php';

$action = $_POST['action'] ?? '';
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'User ID tidak ditemukan.';
    header('Location: /dashboard/interior');
    exit;
}

$controller = new InteriorController($db);

function handleImageUpload($file, $targetDir = '../../uploads/interior/', $oldImage = null)
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
    $fileName = uniqid('interior_') . '.' . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        if ($oldImage && file_exists('../../' . $oldImage)) {
            unlink('../../' . $oldImage);
        }
        return 'uploads/interior/' . $fileName;
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
            $_SESSION['success'] = 'Gambar interior berhasil diupload.';
            header('Location: /dashboard/interior');
            exit;

        case 'update':
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
                '../../uploads/interior/',
                !empty($existing['image']) ? '../../' . $existing['image'] : null
            );

            $imagePath = $image ?? $existing['image'];

            if (empty($imagePath)) {
                throw new Exception('Gambar wajib diupload.');
            }

            $controller->update((int)$id, $imagePath);
            $_SESSION['success'] = 'Gambar interior berhasil diupdate.';
            header('Location: /dashboard/interior');
            exit;

        case 'delete':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new Exception('ID tidak ditemukan.');
            }

            $controller->delete((int)$id);
            $_SESSION['success'] = 'Gambar interior berhasil dihapus.';
            header('Location: /dashboard/interior');
            exit;

        default:
            $_SESSION['error'] = 'Aksi tidak dikenal.';
            header('Location: /dashboard/interior');
            exit;
    }
} catch (Exception $e) {
    error_log('Interior CRUD error: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    $redirectUrl = '/dashboard/interior';
    if ($action === 'update' && isset($_POST['id'])) {
        $redirectUrl = '/dashboard/interior/edit.php?id=' . $_POST['id'];
    }
    header('Location: ' . $redirectUrl);
    exit;
}
