<?php

class HomeController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }


    /**
     * Get all homes with user information
     */
    public function getAll(): array
    {
        $homes = [];
        $stmt = $this->db->prepare("SELECT h.*, a.fullname, a.email FROM `homes` h LEFT JOIN `accounts` a ON h.user_id = a.id ORDER BY h.created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $homes[] = $row;
        }
        $stmt->close();
        return $homes;
    }

    /**
     * Get first home data (for single data management)
     */
    public function getFirst(): ?array
    {
        $stmt = $this->db->prepare("SELECT h.*, a.fullname, a.email FROM `homes` h LEFT JOIN `accounts` a ON h.user_id = a.id ORDER BY h.created_at DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $home = $result->fetch_assoc();
        $stmt->close();
        return $home ?: null;
    }

    /**
     * Get single home by ID with user information
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT h.*, a.fullname, a.email FROM `homes` h LEFT JOIN `accounts` a ON h.user_id = a.id WHERE h.id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $home = $result->fetch_assoc();
        $stmt->close();
        return $home ?: null;
    }

    /**
     * Create new home content
     */
    public function create(string $title, string $description, string $text, string $image, int $userId): int
    {
        if (empty($title) || empty($description) || empty($text)) {
            throw new Exception('Title, Description, dan Text wajib diisi.');
        }

        $stmt = $this->db->prepare("INSERT INTO `homes` (title, description, text, image, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssi', $title, $description, $text, $image, $userId);
        $stmt->execute();
        $newId = $stmt->insert_id;
        $stmt->close();
        return $newId;
    }

    /**
     * Update home content
     */
    public function update(int $id, string $title, string $description, string $text, string $image): bool
    {
        if (empty($title) || empty($description) || empty($text)) {
            throw new Exception('Title, Description, dan Text wajib diisi.');
        }

        // Verify data exists
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        $stmt = $this->db->prepare("UPDATE `homes` SET title = ?, description = ?, text = ?, image = ? WHERE id = ?");
        $stmt->bind_param('ssssi', $title, $description, $text, $image, $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }

    /**
     * Delete home content
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

        $stmt = $this->db->prepare("DELETE FROM `homes` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }
}
