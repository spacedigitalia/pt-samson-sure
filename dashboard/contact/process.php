<?php

/**
 * Process Router for Contact CRUD Operations
 * Uses ContactController directly
 */

session_start();

// Proteksi: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/ContactController.php';

$action = $_POST['action'] ?? '';
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'User ID tidak ditemukan.';
    header('Location: contact');
    exit;
}

$controller = new ContactController($db);

// Helper function to handle image upload
function handleImageUpload($file, $targetDir = '../../uploads/contacts/', $oldImage = null)
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
    $fileName = uniqid('contact_') . '.' . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Delete old image if it exists and is different
        if ($oldImage && file_exists('../../' . $oldImage)) {
            unlink('../../' . $oldImage);
        }
        return 'uploads/contacts/' . $fileName;
    }

    throw new Exception('Gagal mengupload gambar.');
}

try {
    switch ($action) {
        case 'create':
            $title = trim($_POST['title'] ?? '');
            $link = trim($_POST['link'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null);

            $controller->create($title, $link, $description, $image, $userId);
            $_SESSION['success'] = 'Contact berhasil ditambahkan.';
            header('Location: /dashboard/contact');
            exit;

        case 'update':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID tidak ditemukan.';
                header('Location: /dashboard/contact');
                exit;
            }

            $existing = $controller->getById((int)$id);
            if (!$existing) {
                $_SESSION['error'] = 'Data tidak ditemukan.';
                header('Location: /dashboard/contact');
                exit;
            }

            $title = trim($_POST['title'] ?? '');
            $link = trim($_POST['link'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image = handleImageUpload($_FILES['image'] ?? null, '../../uploads/contacts/', $existing['image']);

            $controller->update((int)$id, $title, $link, $description, $image);
            $_SESSION['success'] = 'Contact berhasil diupdate.';
            header('Location: contact');
            exit;

        case 'delete':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID tidak ditemukan.';
                header('Location: contact');
                exit;
            }

            $controller->delete((int)$id);
            $_SESSION['success'] = 'Contact berhasil dihapus.';
            header('Location: contact');
            exit;

        default:
            $_SESSION['error'] = 'Aksi tidak dikenal.';
            header('Location: contact');
            exit;
    }
} catch (Exception $e) {
    error_log('Contact CRUD error: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    $redirectUrl = 'contact';
    if ($action === 'update' && isset($_POST['id'])) {
        $redirectUrl = 'edit.php?id=' . $_POST['id'];
    } elseif ($action === 'create') {
        $redirectUrl = 'create.php';
    }
    header('Location: ' . $redirectUrl);
    exit;
}