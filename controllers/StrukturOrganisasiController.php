<?php

class StrukturOrganisasiController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    /**
     * Get all struktur organisasi with user information
     */
    public function getAll(): array
    {
        $data = [];
        $stmt = $this->db->prepare("SELECT s.*, a.fullname, a.email FROM `struktur_organisasi` s LEFT JOIN `accounts` a ON s.user_id = a.id ORDER BY s.created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    /**
     * Get first struktur organisasi data (for single data management)
     */
    public function getFirst(): ?array
    {
        $stmt = $this->db->prepare("SELECT s.*, a.fullname, a.email FROM `struktur_organisasi` s LEFT JOIN `accounts` a ON s.user_id = a.id ORDER BY s.created_at DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data ?: null;
    }

    /**
     * Get single struktur organisasi by ID with user information
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT s.*, a.fullname, a.email FROM `struktur_organisasi` s LEFT JOIN `accounts` a ON s.user_id = a.id WHERE s.id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data ?: null;
    }

    /**
     * Create new struktur organisasi
     */
    public function create(string $image, int $userId): int
    {
        if (empty($image)) {
            throw new Exception('Gambar wajib diisi.');
        }

        $stmt = $this->db->prepare("INSERT INTO `struktur_organisasi` (image, user_id) VALUES (?, ?)");
        $stmt->bind_param('si', $image, $userId);
        $stmt->execute();
        $newId = $stmt->insert_id;
        $stmt->close();
        return $newId;
    }

    /**
     * Update struktur organisasi
     */
    public function update(int $id, string $image): bool
    {
        if (empty($image)) {
            throw new Exception('Gambar wajib diisi.');
        }

        // Verify data exists
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        $stmt = $this->db->prepare("UPDATE `struktur_organisasi` SET image = ? WHERE id = ?");
        $stmt->bind_param('si', $image, $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }

    /**
     * Delete struktur organisasi
     */
    public function delete(int $id): bool
    {
        // Verify data exists
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        // Delete image file if exists
        if ($existing['image'] && file_exists(__DIR__ . '/../' . $existing['image'])) {
            unlink(__DIR__ . '/../' . $existing['image']);
        }

        $stmt = $this->db->prepare("DELETE FROM `struktur_organisasi` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }
}
