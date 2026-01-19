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

            $controller->create($activities, $companyName, $presidentDirector, $deedIncorporationNumber, $nib, $npwp, $address, $investmentStatus, $userId);
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

            $controller->update((int)$id, $activities, $companyName, $presidentDirector, $deedIncorporationNumber, $nib, $npwp, $address, $investmentStatus);
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
