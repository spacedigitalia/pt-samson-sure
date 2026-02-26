<?php

class CompanyManagementController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }


    /**
     * Get all company managements with user information
     */
    public function getAll(): array
    {
        $managements = [];
        $stmt = $this->db->prepare("SELECT cm.*, ac.fullname, ac.email FROM `company_managements` cm LEFT JOIN `accounts` ac ON cm.user_id = ac.id ORDER BY cm.created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $managements[] = $row;
        }
        $stmt->close();
        return $managements;
    }

    /**
     * Get first company management data (for single data management)
     */
    public function getFirst(): ?array
    {
        $stmt = $this->db->prepare("SELECT cm.*, ac.fullname, ac.email FROM `company_managements` cm LEFT JOIN `accounts` ac ON cm.user_id = ac.id ORDER BY cm.created_at DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $management = $result->fetch_assoc();
        $stmt->close();
        return $management ?: null;
    }

    /**
     * Get single company management by ID with user information
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT cm.*, ac.fullname, ac.email FROM `company_managements` cm LEFT JOIN `accounts` ac ON cm.user_id = ac.id WHERE cm.id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $management = $result->fetch_assoc();
        $stmt->close();
        return $management ?: null;
    }

    /**
     * Create new company management
     */
    public function create(string $position, string $status, ?string $image, string $description, int $userId): int
    {
        if (empty($position) || empty($status) || empty($description)) {
            throw new Exception('Position, Status, dan Description wajib diisi.');
        }

        $image = $image ?: null;
        $stmt = $this->db->prepare("INSERT INTO `company_managements` (position, status, image, description, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssi', $position, $status, $image, $description, $userId);
        $stmt->execute();
        $newId = $stmt->insert_id;
        $stmt->close();
        return $newId;
    }

    /**
     * Update company management
     */
    public function update(int $id, string $position, string $status, ?string $image, string $description): bool
    {
        if (empty($position) || empty($status) || empty($description)) {
            throw new Exception('Position, Status, dan Description wajib diisi.');
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
        $stmt = $this->db->prepare("UPDATE `company_managements` SET position = ?, status = ?, image = ?, description = ? WHERE id = ?");
        $stmt->bind_param('ssssi', $position, $status, $image, $description, $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }

    /**
     * Delete company management
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

        $stmt = $this->db->prepare("DELETE FROM `company_managements` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }
}
