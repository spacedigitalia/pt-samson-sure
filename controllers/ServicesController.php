<?php

class ServicesController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }


    /**
     * Get all services with user information
     */
    public function getAll(): array
    {
        $services = [];
        $stmt = $this->db->prepare("SELECT s.*, ac.fullname, ac.email FROM `services` s LEFT JOIN `accounts` ac ON s.user_id = ac.id ORDER BY s.created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
        $stmt->close();
        return $services;
    }

    /**
     * Get first service data (for single data management)
     */
    public function getFirst(): ?array
    {
        $stmt = $this->db->prepare("SELECT s.*, ac.fullname, ac.email FROM `services` s LEFT JOIN `accounts` ac ON s.user_id = ac.id ORDER BY s.created_at DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $service = $result->fetch_assoc();
        $stmt->close();
        return $service ?: null;
    }

    /**
     * Get single service by ID with user information
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT s.*, ac.fullname, ac.email FROM `services` s LEFT JOIN `accounts` ac ON s.user_id = ac.id WHERE s.id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $service = $result->fetch_assoc();
        $stmt->close();
        return $service ?: null;
    }

    /**
     * Create new service
     */
    public function create(string $title, string $description, ?string $image, int $userId): int
    {
        if (empty($title) || empty($description)) {
            throw new Exception('Title dan Description wajib diisi.');
        }

        $image = $image ?: null;
        $stmt = $this->db->prepare("INSERT INTO `services` (title, description, image, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssi', $title, $description, $image, $userId);
        $stmt->execute();
        $newId = $stmt->insert_id;
        $stmt->close();
        return $newId;
    }

    /**
     * Update service
     */
    public function update(int $id, string $title, string $description, ?string $image): bool
    {
        if (empty($title) || empty($description)) {
            throw new Exception('Title dan Description wajib diisi.');
        }

        // Verify data exists
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        // Keep existing image if new one is not provided
        if (empty($image)) {
            $image = $existing['image'];
        }

        $image = $image ?: null;
        $stmt = $this->db->prepare("UPDATE `services` SET title = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param('sssi', $title, $description, $image, $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }

    /**
     * Delete service
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

        $stmt = $this->db->prepare("DELETE FROM `services` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }
}
