<?php

class VisiMisiController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    /**
     * Get all visi/misi by type
     */
    public function getAll(?string $type = null): array
    {
        $items = [];
        $sql = "SELECT vm.*, a.fullname, a.email 
                FROM `visi_mission` vm 
                LEFT JOIN `accounts` a ON vm.user_id = a.id 
                WHERE 1=1";

        $params = [];
        $types = '';

        if ($type) {
            $sql .= " AND vm.type = ?";
            $params[] = $type;
            $types .= 's';
        }

        $sql .= " ORDER BY vm.created_at DESC";

        $stmt = $this->db->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        $stmt->close();
        return $items;
    }

    /**
     * Get single visi/misi by ID
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT vm.*, a.fullname, a.email 
            FROM `visi_mission` vm 
            LEFT JOIN `accounts` a ON vm.user_id = a.id 
            WHERE vm.id = ?
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        $stmt->close();

        return $item ?: null;
    }

    /**
     * Create new visi/misi
     */
    public function create(string $description, string $type, ?string $image, int $userId): int
    {
        if (empty($description) || empty($type)) {
            throw new Exception('Semua field wajib diisi.');
        }

        $stmt = $this->db->prepare("
            INSERT INTO `visi_mission` 
            (description, type, image, user_id) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param('sssi', $description, $type, $image, $userId);
        $stmt->execute();
        $newId = $stmt->insert_id;
        $stmt->close();

        return $newId;
    }

    /**
     * Update visi/misi
     */
    public function update(int $id, string $description, string $type, ?string $image): bool
    {
        if (empty($description) || empty($type)) {
            throw new Exception('Semua field wajib diisi.');
        }

        // Verifikasi data ada
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        // Keep existing image if new one is not provided
        if (empty($image)) {
            $image = $existing['image'];
        }

        $stmt = $this->db->prepare("
            UPDATE `visi_mission` 
            SET description = ?, 
                type = ?, 
                image = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        $stmt->bind_param('sssi', $description, $type, $image, $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();

        return $success;
    }

    /**
     * Delete visi/misi
     */
    public function delete(int $id): bool
    {
        // Verifikasi data ada
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        // Hapus file gambar jika ada
        if (!empty($existing['image']) && file_exists(__DIR__ . '/../../' . $existing['image'])) {
            unlink(__DIR__ . '/../../' . $existing['image']);
        }

        $stmt = $this->db->prepare("DELETE FROM `visi_mission` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();

        return $success;
    }
}