<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = 'Silakan login terlebih dahulu.';
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /dashboard/managements-admin');
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/AccountManagementController.php';

$action = $_POST['action'] ?? '';
$actorId = (int)($_SESSION['user']['id'] ?? 0);
if ($actorId < 1) {
    $_SESSION['error'] = 'Sesi tidak valid.';
    header('Location: ../login.php');
    exit;
}

$controller = new AccountManagementController($db);

try {
    switch ($action) {
        case 'create':
            $controller->create(
                trim($_POST['fullname'] ?? ''),
                trim($_POST['email'] ?? ''),
                $_POST['password'] ?? '',
                $_POST['confirm_password'] ?? '',
                trim($_POST['role'] ?? 'admin'),
                $actorId
            );
            $_SESSION['success'] = 'Akun admin berhasil ditambahkan.';
            header('Location: /dashboard/managements-admin');
            exit;

        case 'update':
            $id = (int)($_POST['id'] ?? 0);
            if ($id < 1) {
                throw new Exception('ID akun tidak valid.');
            }
            $newPwd = $_POST['new_password'] ?? '';
            $confirmPwd = $_POST['confirm_new_password'] ?? '';
            $controller->update(
                $id,
                trim($_POST['fullname'] ?? ''),
                trim($_POST['email'] ?? ''),
                trim($_POST['role'] ?? 'admin'),
                $newPwd,
                $confirmPwd,
                $actorId
            );
            $_SESSION['success'] = 'Akun berhasil diperbarui.';
            header('Location: /dashboard/managements-admin');
            exit;

        case 'delete':
            $id = (int)($_POST['id'] ?? 0);
            if ($id < 1) {
                throw new Exception('ID akun tidak valid.');
            }
            $controller->delete($id, $actorId);
            $_SESSION['success'] = 'Akun berhasil dihapus.';
            header('Location: /dashboard/managements-admin');
            exit;

        default:
            $_SESSION['error'] = 'Aksi tidak dikenal.';
            header('Location: /dashboard/managements-admin');
            exit;
    }
} catch (Exception $e) {
    error_log('Account management: ' . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    if ($action === 'create') {
        header('Location: /dashboard/managements-admin/create.php');
    } elseif ($action === 'update' && isset($_POST['id'])) {
        header('Location: /dashboard/managements-admin/edit.php?id=' . (int)$_POST['id']);
    } else {
        header('Location: /dashboard/managements-admin');
    }
    exit;
}
