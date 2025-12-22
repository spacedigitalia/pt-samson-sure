<?php

/**
 * Process Router for Vision & Mission CRUD Operations
 */

session_start();

// Proteksi: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /dashboard/vision-mission');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/VisiMisiController.php';

$action = $_POST['action'] ?? '';
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'User ID tidak ditemukan.';
    header('Location: /dashboard/vision-mission');
    exit;
}

$controller = new VisiMisiController($db);

// Helper function untuk upload gambar
function handleImageUpload($file, $targetDir = '../../uploads/vision_mission/', $oldImage = null)
{
    // Hapus gambar lama jika ada
    if ($oldImage && file_exists($oldImage)) {
        unlink($oldImage);
    }

    // Jika tidak ada file yang diupload, kembalikan null
    if (!isset($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    // Validasi file upload
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('Hanya file JPG, PNG, dan GIF yang diperbolehkan.');
    }

    if ($file['size'] > $maxSize) {
        throw new Exception('Ukuran file melebihi batas maksimal 2MB.');
    }

    // Buat direktori jika belum ada
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileName = 'vision_mission_' . uniqid() . '.' . $extension;
    $targetFile = rtrim($targetDir, '/') . '/' . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Delete old image if it exists and is different
        if ($oldImage && file_exists($oldImage)) {
            unlink($oldImage);
        }
        return 'uploads/vision_mission/' . $fileName;
    }

    throw new Exception('Gagal mengupload gambar.');
}

try {
    switch ($action) {
        case 'create':
            $type = trim($_POST['type'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($type) || empty($description)) {
                throw new Exception('Semua field wajib diisi.');
            }

            $image = handleImageUpload($_FILES['image'] ?? null);
            $id = $controller->create($description, $type, $image, $userId);

            $_SESSION['success'] = ucfirst($type) . ' berhasil ditambahkan.';
            header('Location: /dashboard/vision-mission');
            exit;

        case 'update':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new Exception('ID tidak valid.');
            }

            // Get existing data
            $existing = $controller->getById((int)$id);
            if (!$existing) {
                throw new Exception('Data tidak ditemukan.');
            }

            $type = trim($_POST['type'] ?? $existing['type']);
            $description = trim($_POST['description'] ?? '');

            if (empty($description)) {
                throw new Exception('Deskripsi wajib diisi.');
            }

            $image = handleImageUpload(
                $_FILES['image'] ?? null,
                '../../uploads/vision_mission/',
                !empty($existing['image']) ? '../../' . $existing['image'] : null
            );

            // If no new image uploaded, keep the existing one
            $imagePath = $image ?? $existing['image'];

            $controller->update(
                id: (int)$id,
                description: $description,
                type: $type,
                image: $imagePath
            );
            $_SESSION['success'] = ucfirst($type) . ' berhasil diperbarui.';
            header('Location: /dashboard/vision-mission');
            exit;

        case 'delete':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new Exception('ID tidak ditemukan.');
            }

            // Get data before delete to show success message with type
            $existing = $controller->getById((int)$id);
            if (!$existing) {
                throw new Exception('Data tidak ditemukan.');
            }

            $controller->delete((int)$id);
            $_SESSION['success'] = ucfirst($existing['type']) . ' berhasil dihapus.';
            header('Location: /dashboard/vision-mission');
            exit;

        default:
            throw new Exception('Aksi tidak valid.');
    }
} catch (Exception $e) {
    error_log('Visi/Misi CRUD error: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    $redirectUrl = '/dashboard/vision-mission';
    if ($action === 'update' && isset($_POST['id'])) {
        $redirectUrl = 'edit.php?id=' . (int)$_POST['id'];
    } elseif ($action === 'create') {
        $redirectUrl = 'create.php';
        if (isset($_POST['type'])) {
            $redirectUrl .= '?type=' . urlencode($_POST['type']);
        }
    }
    header('Location: ' . $redirectUrl);
    exit;
}
