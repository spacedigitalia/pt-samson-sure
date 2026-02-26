<?php

/**
 * Process Router for About CRUD Operations
 * Uses AboutController directly
 */

session_start();

// Proteksi: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /dashboard/about');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/AboutController.php';

$action = $_POST['action'] ?? '';
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'User ID tidak ditemukan.';
    header('Location: /dashboard/about');
    exit;
}

$controller = new AboutController($db);

// Helper function to handle image upload
function handleImageUpload($file, $targetDir = '../../uploads/about/', $oldImage = null)
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
    $fileName = uniqid('about_') . '.' . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Delete old image if it exists and is different
        if ($oldImage && file_exists('../../' . $oldImage)) {
            unlink('../../' . $oldImage);
        }
        return 'uploads/about/' . $fileName;
    }

    throw new Exception('Gagal mengupload gambar.');
}

try {
    switch ($action) {
        case 'create':
            // Process items array from form
            $items = [];
            if (isset($_POST['items']) && is_array($_POST['items'])) {
                foreach ($_POST['items'] as $item) {
                    if (!empty($item['title']) && !empty($item['description'])) {
                        $items[] = [
                            'title' => trim($item['title']),
                            'description' => trim($item['description'])
                        ];
                    }
                }
            }

            if (empty($items)) {
                throw new Exception('Minimal harus ada satu item dengan title dan description.');
            }

            $text = trim($_POST['text'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null);
            $controller->create($items, $text, $image, $userId);
            $_SESSION['success'] = 'About content berhasil ditambahkan.';
            header('Location: /dashboard/about');
            exit;

        case 'update':
            // Get first data for single data management
            $existing = $controller->getFirst();
            if (!$existing) {
                $_SESSION['error'] = 'Data tidak ditemukan.';
                header('Location: /dashboard/about');
                exit;
            }

            $id = $existing['id'];

            // Process items array from form
            $items = [];
            if (isset($_POST['items']) && is_array($_POST['items'])) {
                foreach ($_POST['items'] as $item) {
                    if (!empty($item['title']) && !empty($item['description'])) {
                        $items[] = [
                            'title' => trim($item['title']),
                            'description' => trim($item['description'])
                        ];
                    }
                }
            }

            if (empty($items)) {
                throw new Exception('Minimal harus ada satu item dengan title dan description.');
            }

            $text = trim($_POST['text'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null, '../../uploads/about/', $existing['image']);
            $controller->update((int)$id, $items, $text, $image);
            $_SESSION['success'] = 'About content berhasil diupdate.';
            header('Location: /dashboard/about');
            exit;

        case 'delete':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID tidak ditemukan.';
                header('Location: /dashboard/about');
                exit;
            }

            $controller->delete((int)$id);
            $_SESSION['success'] = 'About content berhasil dihapus.';
            header('Location: /dashboard/about');
            exit;

        default:
            $_SESSION['error'] = 'Aksi tidak dikenal.';
            header('Location: /dashboard/about');
            exit;
    }
} catch (Exception $e) {
    error_log('About CRUD error: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    $redirectUrl = '/dashboard/about';
    if ($action === 'update' && isset($_POST['id'])) {
        $redirectUrl = 'edit.php?id=' . $_POST['id'];
    } elseif ($action === 'create') {
        $redirectUrl = 'create.php';
    }
    header('Location: ' . $redirectUrl);
    exit;
}
