<?php

class AboutController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }


    /**
     * Get all abouts with user information
     */
    public function getAll(): array
    {
        $abouts = [];
        $stmt = $this->db->prepare("SELECT a.*, ac.fullname, ac.email FROM `abouts` a LEFT JOIN `accounts` ac ON a.user_id = ac.id ORDER BY a.created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // Decode JSON items
            if (isset($row['items']) && is_string($row['items'])) {
                $row['items'] = json_decode($row['items'], true) ?: [];
            }
            $abouts[] = $row;
        }
        $stmt->close();
        return $abouts;
    }

    /**
     * Get first about data (for single data management)
     */
    public function getFirst(): ?array
    {
        $stmt = $this->db->prepare("SELECT a.*, ac.fullname, ac.email FROM `abouts` a LEFT JOIN `accounts` ac ON a.user_id = ac.id ORDER BY a.created_at DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $about = $result->fetch_assoc();
        $stmt->close();

        if ($about) {
            // Decode JSON items
            if (isset($about['items']) && is_string($about['items'])) {
                $about['items'] = json_decode($about['items'], true) ?: [];
            }
            return $about;
        }

        return null;
    }

    /**
     * Get single about by ID with user information
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT a.*, ac.fullname, ac.email FROM `abouts` a LEFT JOIN `accounts` ac ON a.user_id = ac.id WHERE a.id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $about = $result->fetch_assoc();
        $stmt->close();

        if ($about) {
            // Decode JSON items
            if (isset($about['items']) && is_string($about['items'])) {
                $about['items'] = json_decode($about['items'], true) ?: [];
            }
            return $about;
        }

        return null;
    }

    /**
     * Create new about content with array of items
     */
    public function create(array $items, ?string $text, ?string $image, int $userId): int
    {
        if (empty($items) || !is_array($items)) {
            throw new Exception('Items wajib diisi dan harus berupa array.');
        }

        // Validate items structure
        foreach ($items as $item) {
            if (empty($item['title']) || empty($item['description'])) {
                throw new Exception('Setiap item harus memiliki title dan description.');
            }
        }

        $itemsJson = json_encode($items, JSON_UNESCAPED_UNICODE);
        $text = $text ?: null;
        $image = $image ?: null;
        $stmt = $this->db->prepare("INSERT INTO `abouts` (items, text, image, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssi', $itemsJson, $text, $image, $userId);
        $stmt->execute();
        $newId = $stmt->insert_id;
        $stmt->close();
        return $newId;
    }

    /**
     * Update about content with array of items
     */
    public function update(int $id, array $items, ?string $text, ?string $image): bool
    {
        if (empty($items) || !is_array($items)) {
            throw new Exception('Items wajib diisi dan harus berupa array.');
        }

        // Validate items structure
        foreach ($items as $item) {
            if (empty($item['title']) || empty($item['description'])) {
                throw new Exception('Setiap item harus memiliki title dan description.');
            }
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

        $itemsJson = json_encode($items, JSON_UNESCAPED_UNICODE);
        $text = $text ?: null;
        $image = $image ?: null;
        $stmt = $this->db->prepare("UPDATE `abouts` SET items = ?, text = ?, image = ? WHERE id = ?");
        $stmt->bind_param('sssi', $itemsJson, $text, $image, $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }

    /**
     * Delete about content
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

        $stmt = $this->db->prepare("DELETE FROM `abouts` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }
}