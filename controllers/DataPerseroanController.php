<?php

class DataPerseroanController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }


    /**
     * Get all data perseroan with user information
     */
    public function getAll(): array
    {
        $dataPerseroan = [];
        $stmt = $this->db->prepare("SELECT dp.*, ac.fullname, ac.email FROM `data_perseroan` dp LEFT JOIN `accounts` ac ON dp.user_id = ac.id ORDER BY dp.created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // Decode JSON activities
            if (isset($row['activities']) && is_string($row['activities'])) {
                $row['activities'] = json_decode($row['activities'], true) ?: [];
            }
            $dataPerseroan[] = $row;
        }
        $stmt->close();
        return $dataPerseroan;
    }

    /**
     * Get first data perseroan (for single data management)
     */
    public function getFirst(): ?array
    {
        $stmt = $this->db->prepare("SELECT dp.*, ac.fullname, ac.email FROM `data_perseroan` dp LEFT JOIN `accounts` ac ON dp.user_id = ac.id ORDER BY dp.created_at DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $dataPerseroan = $result->fetch_assoc();
        $stmt->close();

        if ($dataPerseroan) {
            // Decode JSON activities
            if (isset($dataPerseroan['activities']) && is_string($dataPerseroan['activities'])) {
                $dataPerseroan['activities'] = json_decode($dataPerseroan['activities'], true) ?: [];
            }
            return $dataPerseroan;
        }

        return null;
    }

    /**
     * Get single data perseroan by ID with user information
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT dp.*, ac.fullname, ac.email FROM `data_perseroan` dp LEFT JOIN `accounts` ac ON dp.user_id = ac.id WHERE dp.id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $dataPerseroan = $result->fetch_assoc();
        $stmt->close();

        if ($dataPerseroan) {
            // Decode JSON activities
            if (isset($dataPerseroan['activities']) && is_string($dataPerseroan['activities'])) {
                $dataPerseroan['activities'] = json_decode($dataPerseroan['activities'], true) ?: [];
            }
            return $dataPerseroan;
        }

        return null;
    }

    /**
     * Create new data perseroan
     */
    public function create(array $activities, ?string $companyName, ?string $presidentDirector, ?string $deedIncorporationNumber, ?string $nib, ?string $npwp, ?string $address, ?string $investmentStatus, ?string $image, ?string $imd, ?string $imb, ?string $skd, ?string $skb, int $userId): int
    {
        if (empty($activities) || !is_array($activities)) {
            throw new Exception('Activities wajib diisi dan harus berupa array.');
        }

        // Validate activities structure
        foreach ($activities as $activity) {
            if (empty($activity['title'])) {
                throw new Exception('Setiap activity harus memiliki title.');
            }
        }

        $activitiesJson = json_encode($activities, JSON_UNESCAPED_UNICODE);
        $companyName = $companyName ?: null;
        $presidentDirector = $presidentDirector ?: null;
        $deedIncorporationNumber = $deedIncorporationNumber ?: null;
        $nib = $nib ?: null;
        $npwp = $npwp ?: null;
        $address = $address ?: null;
        $investmentStatus = $investmentStatus ?: null;
        $image = $image ?: null;
        $imd = $imd ?: null;
        $imb = $imb ?: null;
        $skd = $skd ?: null;
        $skb = $skb ?: null;

        $stmt = $this->db->prepare("INSERT INTO `data_perseroan` (activities, company_name, president_director, deed_incorporation_number, nib, npwp, address, investment_status, image, imd, imb, skd, skb, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssssssssssi', $activitiesJson, $companyName, $presidentDirector, $deedIncorporationNumber, $nib, $npwp, $address, $investmentStatus, $image, $imd, $imb, $skd, $skb, $userId);
        $stmt->execute();
        $newId = $stmt->insert_id;
        $stmt->close();
        return $newId;
    }

    /**
     * Update data perseroan
     */
    public function update(int $id, array $activities, ?string $companyName, ?string $presidentDirector, ?string $deedIncorporationNumber, ?string $nib, ?string $npwp, ?string $address, ?string $investmentStatus, ?string $image, ?string $imd, ?string $imb, ?string $skd, ?string $skb): bool
    {
        if (empty($activities) || !is_array($activities)) {
            throw new Exception('Activities wajib diisi dan harus berupa array.');
        }

        // Validate activities structure
        foreach ($activities as $activity) {
            if (empty($activity['title'])) {
                throw new Exception('Setiap activity harus memiliki title.');
            }
        }

        // Verify data exists
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        // Keep existing images if new ones are not provided
        if (empty($image)) {
            $image = $existing['image'];
        }
        if (empty($imd)) {
            $imd = $existing['imd'] ?? null;
        }
        if (empty($imb)) {
            $imb = $existing['imb'] ?? null;
        }
        if (empty($skd)) {
            $skd = $existing['skd'] ?? null;
        }
        if (empty($skb)) {
            $skb = $existing['skb'] ?? null;
        }

        $activitiesJson = json_encode($activities, JSON_UNESCAPED_UNICODE);
        $companyName = $companyName ?: null;
        $presidentDirector = $presidentDirector ?: null;
        $deedIncorporationNumber = $deedIncorporationNumber ?: null;
        $nib = $nib ?: null;
        $npwp = $npwp ?: null;
        $address = $address ?: null;
        $investmentStatus = $investmentStatus ?: null;
        $image = $image ?: null;
        $imd = $imd ?: null;
        $imb = $imb ?: null;
        $skd = $skd ?: null;
        $skb = $skb ?: null;

        $stmt = $this->db->prepare("UPDATE `data_perseroan` SET activities = ?, company_name = ?, president_director = ?, deed_incorporation_number = ?, nib = ?, npwp = ?, address = ?, investment_status = ?, image = ?, imd = ?, imb = ?, skd = ?, skb = ? WHERE id = ?");
        $stmt->bind_param('sssssssssssssi', $activitiesJson, $companyName, $presidentDirector, $deedIncorporationNumber, $nib, $npwp, $address, $investmentStatus, $image, $imd, $imb, $skd, $skb, $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }

    /**
     * Delete data perseroan
     */
    public function delete(int $id): bool
    {
        // Verify data exists
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Data tidak ditemukan.');
        }

        // Delete image files if exists
        $imageFields = ['image', 'imd', 'imb', 'skd', 'skb'];
        foreach ($imageFields as $field) {
            if (!empty($existing[$field]) && file_exists(__DIR__ . '/../' . $existing[$field])) {
                unlink(__DIR__ . '/../' . $existing[$field]);
            }
        }

        $stmt = $this->db->prepare("DELETE FROM `data_perseroan` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }
}
