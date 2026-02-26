<?php

class InteriorController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    /**
     * Get all interior with user information
     */
    public function getAll(): array
    {
        $data = [];
        $stmt = $this->db->prepare("SELECT i.*, a.fullname, a.email FROM `interior` i LEFT JOIN `accounts` a ON i.user_id = a.id ORDER BY i.created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    /**
     * Get single interior by ID with user information
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT i.*, a.fullname, a.email FROM `interior` i LEFT JOIN `accounts` a ON i.user_id = a.id WHERE i.id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data ?: null;
    }

    /**
     * Create new interior
     */
    public function create(string $image, int $userId): int
    {
        if (empty($image)) {
            throw new Exception('Gambar wajib diisi.');
        }

        $stmt = $this->db->prepare("INSERT INTO `interior` (image, user_id) VALUES (?, ?)");
        $stmt->bind_param('si', $image, $userId);
        $stmt->execute();
        $newId = $stmt->insert_id;
        $stmt->close();
        return $newId;
    }

    /**
     * Update interior
     */
    public function update(int $id, string $image): bool
    {
        if (empty($image)) {
            throw new Exception('Gambar wajib diisi.');
        }

        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        $stmt = $this->db->prepare("UPDATE `interior` SET image = ? WHERE id = ?");
        $stmt->bind_param('si', $image, $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }

    /**
     * Delete interior
     */
    public function delete(int $id): bool
    {
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        if ($existing['image'] && file_exists(__DIR__ . '/../' . $existing['image'])) {
            unlink(__DIR__ . '/../' . $existing['image']);
        }

        $stmt = $this->db->prepare("DELETE FROM `interior` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }
}
