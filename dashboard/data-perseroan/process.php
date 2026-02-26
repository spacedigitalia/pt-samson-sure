<?php

/**
 * Process Router for Data Perseroan CRUD Operations
 * Uses DataPerseroanController directly
 */

session_start();

// Proteksi: hanya admin yang boleh masuk
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: data-perseroan');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/DataPerseroanController.php';

$action = $_POST['action'] ?? '';
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'User ID tidak ditemukan.';
    header('Location: data-perseroan');
    exit;
}

$controller = new DataPerseroanController($db);

// Helper function to handle image upload
function handleImageUpload($file, $targetDir = '../../uploads/data-perseroan/', $oldImage = null)
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
    $fileName = uniqid('data_perseroan_') . '.' . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Delete old image if it exists and is different
        if ($oldImage && file_exists('../../' . $oldImage)) {
            unlink('../../' . $oldImage);
        }
        return 'uploads/data-perseroan/' . $fileName;
    }

    throw new Exception('Gagal mengupload gambar.');
}

// Helper function to process activities array
function processActivities($activitiesInput)
{
    if (empty($activitiesInput) || !is_array($activitiesInput)) {
        throw new Exception('Activities wajib diisi dan harus berupa array.');
    }

    $activities = [];
    foreach ($activitiesInput as $title) {
        $title = trim($title);
        if (!empty($title)) {
            $activities[] = ['title' => $title];
        }
    }

    if (empty($activities)) {
        throw new Exception('Minimal 1 activity harus diisi.');
    }

    return $activities;
}

try {
    switch ($action) {
        case 'create':
            $activities = processActivities($_POST['activities'] ?? []);
            $companyName = trim($_POST['company_name'] ?? '') ?: null;
            $presidentDirector = trim($_POST['president_director'] ?? '') ?: null;
            $deedIncorporationNumber = trim($_POST['deed_incorporation_number'] ?? '') ?: null;
            $nib = trim($_POST['nib'] ?? '') ?: null;
            $npwp = trim($_POST['npwp'] ?? '') ?: null;
            $address = trim($_POST['address'] ?? '') ?: null;
            $investmentStatus = trim($_POST['investment_status'] ?? '') ?: null;
            $image = handleImageUpload($_FILES['image'] ?? null);
            $imd = handleImageUpload($_FILES['imd'] ?? null);
            $imb = handleImageUpload($_FILES['imb'] ?? null);
            $skd = handleImageUpload($_FILES['skd'] ?? null);
            $skb = handleImageUpload($_FILES['skb'] ?? null);

            $controller->create($activities, $companyName, $presidentDirector, $deedIncorporationNumber, $nib, $npwp, $address, $investmentStatus, $image, $imd, $imb, $skd, $skb, $userId);
            $_SESSION['success'] = 'Data perseroan berhasil ditambahkan.';
            header('Location: /dashboard/data-perseroan');
            exit;

        case 'update':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID tidak ditemukan.';
                header('Location: /dashboard/data-perseroan');
                exit;
            }

            $existing = $controller->getById((int)$id);
            if (!$existing) {
                $_SESSION['error'] = 'Data tidak ditemukan.';
                header('Location: /dashboard/data-perseroan');
                exit;
            }

            $activities = processActivities($_POST['activities'] ?? []);
            $companyName = trim($_POST['company_name'] ?? '') ?: null;
            $presidentDirector = trim($_POST['president_director'] ?? '') ?: null;
            $deedIncorporationNumber = trim($_POST['deed_incorporation_number'] ?? '') ?: null;
            $nib = trim($_POST['nib'] ?? '') ?: null;
            $npwp = trim($_POST['npwp'] ?? '') ?: null;
            $address = trim($_POST['address'] ?? '') ?: null;
            $investmentStatus = trim($_POST['investment_status'] ?? '') ?: null;
            $image = handleImageUpload($_FILES['image'] ?? null, '../../uploads/data-perseroan/', $existing['image'] ?? null);
            $imd = handleImageUpload($_FILES['imd'] ?? null, '../../uploads/data-perseroan/', $existing['imd'] ?? null);
            $imb = handleImageUpload($_FILES['imb'] ?? null, '../../uploads/data-perseroan/', $existing['imb'] ?? null);
            $skd = handleImageUpload($_FILES['skd'] ?? null, '../../uploads/data-perseroan/', $existing['skd'] ?? null);
            $skb = handleImageUpload($_FILES['skb'] ?? null, '../../uploads/data-perseroan/', $existing['skb'] ?? null);

            // If no new images uploaded, keep the existing ones
            $imagePath = $image ?? ($existing['image'] ?? null);
            $imdPath = $imd ?? ($existing['imd'] ?? null);
            $imbPath = $imb ?? ($existing['imb'] ?? null);
            $skdPath = $skd ?? ($existing['skd'] ?? null);
            $skbPath = $skb ?? ($existing['skb'] ?? null);

            $controller->update((int)$id, $activities, $companyName, $presidentDirector, $deedIncorporationNumber, $nib, $npwp, $address, $investmentStatus, $imagePath, $imdPath, $imbPath, $skdPath, $skbPath);
            $_SESSION['success'] = 'Data perseroan berhasil diupdate.';
            header('Location: data-perseroan');
            exit;

        case 'delete':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error'] = 'ID tidak ditemukan.';
                header('Location: data-perseroan');
                exit;
            }

            $controller->delete((int)$id);
            $_SESSION['success'] = 'Data perseroan berhasil dihapus.';
            header('Location: data-perseroan');
            exit;

        default:
            $_SESSION['error'] = 'Aksi tidak dikenal.';
            header('Location: data-perseroan');
            exit;
    }
} catch (Exception $e) {
    error_log('Data Perseroan CRUD error: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    $redirectUrl = 'data-perseroan';
    if ($action === 'update' && isset($_POST['id'])) {
        $redirectUrl = 'edit.php?id=' . $_POST['id'];
    } elseif ($action === 'create') {
        $redirectUrl = 'create.php';
    }
    header('Location: ' . $redirectUrl);
    exit;
}
