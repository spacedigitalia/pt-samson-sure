<?php

require_once __DIR__ . '/AuthController.php';

class AccountManagementController
{
    private mysqli $db;
    private AuthController $auth;

    private const ALLOWED_ROLES = ['admin'];

    private const FULLNAME_MIN_LEN = 2;

    private const FULLNAME_MAX_LEN = 120;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
        $this->auth = new AuthController($db);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getAll(): array
    {
        $rows = [];
        $result = $this->db->query(
            "SELECT id, fullname, email, role, created_at, updated_at FROM `accounts` ORDER BY created_at DESC"
        );
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT id, fullname, email, role, created_at, updated_at FROM `accounts` WHERE id = ? LIMIT 1"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    /**
     * Validasi nama lengkap: panjang dan karakter yang diizinkan (huruf Unicode, spasi, . ' -)
     */
    private function validateFullname(string $fullname): void
    {
        $len = function_exists('mb_strlen')
            ? mb_strlen($fullname, 'UTF-8')
            : strlen($fullname);

        if ($len < self::FULLNAME_MIN_LEN) {
            throw new Exception('Nama minimal ' . self::FULLNAME_MIN_LEN . ' karakter.');
        }
        if ($len > self::FULLNAME_MAX_LEN) {
            throw new Exception('Nama maksimal ' . self::FULLNAME_MAX_LEN . ' karakter.');
        }

        if (!preg_match('/^[\p{L}\s\.\'\-]+$/u', $fullname)) {
            throw new Exception(
                'Nama hanya boleh berisi huruf, spasi, titik (.), apostrof (\'), atau tanda hubung (-).'
            );
        }
    }

    /** Rapatkan spasi berlebih; dipakai sebelum simpan & cek unik. */
    private function normalizeFullname(string $fullname): string
    {
        $s = trim($fullname);
        $collapsed = preg_replace('/\s+/u', ' ', $s);

        return $collapsed !== null ? $collapsed : $s;
    }

    /**
     * Pastikan nama lengkap belum dipakai akun lain (bandingkan tanpa membedakan huruf besar/kecil).
     *
     * @param int|null $excludeUserId null saat create; id akun saat edit
     */
    private function assertFullnameAvailable(string $normalizedFullname, ?int $excludeUserId): void
    {
        if ($excludeUserId === null) {
            $stmt = $this->db->prepare(
                "SELECT id FROM `accounts` WHERE LOWER(fullname) = LOWER(?) LIMIT 1"
            );
            $stmt->bind_param('s', $normalizedFullname);
        } else {
            $stmt = $this->db->prepare(
                "SELECT id FROM `accounts` WHERE LOWER(fullname) = LOWER(?) AND id != ? LIMIT 1"
            );
            $stmt->bind_param('si', $normalizedFullname, $excludeUserId);
        }
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            throw new Exception('Nama lengkap sudah terdaftar. Gunakan nama yang berbeda.');
        }
        $stmt->close();
    }

    /** True jika nama dari form sama dengan nama yang tersimpan untuk akun ini (setelah normalisasi, abaikan besar/kecil huruf). */
    private function isUnchangedFullname(string $newNormalized, string $previousRawFromDb): bool
    {
        $prev = $this->normalizeFullname($previousRawFromDb);
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($newNormalized, 'UTF-8') === mb_strtolower($prev, 'UTF-8');
        }

        return strtolower($newNormalized) === strtolower($prev);
    }

    public function create(
        string $fullname,
        string $email,
        string $password,
        string $confirmPassword,
        string $role,
        int $actorId
    ): void {
        $fullname = $this->normalizeFullname($fullname);
        $email = trim($email);
        if ($fullname === '' || $email === '' || $password === '' || $confirmPassword === '') {
            throw new Exception('Semua field wajib diisi.');
        }
        $this->validateFullname($fullname);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Format email tidak valid.');
        }
        if ($password !== $confirmPassword) {
            throw new Exception('Konfirmasi password tidak sama.');
        }
        if (strlen($password) < 6) {
            throw new Exception('Password minimal 6 karakter.');
        }
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            throw new Exception('Role tidak valid.');
        }

        $this->assertFullnameAvailable($fullname, null);

        $stmt = $this->db->prepare("SELECT id FROM `accounts` WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            throw new Exception('Email sudah terdaftar.');
        }
        $stmt->close();

        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO `accounts` (fullname, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $fullname, $email, $hashed, $role);
        $stmt->execute();
        $newId = (int)$stmt->insert_id;
        $stmt->close();

        $this->auth->log($actorId, 'account_create', 'Menambah akun: ' . $email . ' (id ' . $newId . ')');
    }

    public function update(
        int $id,
        string $fullname,
        string $email,
        string $role,
        ?string $newPassword,
        ?string $confirmPassword,
        int $actorId
    ): void {
        $fullname = $this->normalizeFullname($fullname);
        $email = trim($email);
        if ($fullname === '' || $email === '') {
            throw new Exception('Nama dan email wajib diisi.');
        }
        $this->validateFullname($fullname);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Format email tidak valid.');
        }
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            throw new Exception('Role tidak valid.');
        }

        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception('Akun tidak ditemukan.');
        }

        if (!$this->isUnchangedFullname($fullname, (string)($existing['fullname'] ?? ''))) {
            $this->assertFullnameAvailable($fullname, $id);
        }

        $stmt = $this->db->prepare("SELECT id FROM `accounts` WHERE email = ? AND id != ? LIMIT 1");
        $stmt->bind_param('si', $email, $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            throw new Exception('Email sudah digunakan akun lain.');
        }
        $stmt->close();

        $newPassword = $newPassword !== null ? trim($newPassword) : '';
        $confirmPassword = $confirmPassword !== null ? trim($confirmPassword) : '';

        if ($newPassword !== '' || $confirmPassword !== '') {
            if ($newPassword !== $confirmPassword) {
                throw new Exception('Konfirmasi password baru tidak sama.');
            }
            if (strlen($newPassword) < 6) {
                throw new Exception('Password baru minimal 6 karakter.');
            }
            $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare(
                "UPDATE `accounts` SET fullname = ?, email = ?, role = ?, password = ?, updated_at = NOW() WHERE id = ?"
            );
            $stmt->bind_param('ssssi', $fullname, $email, $role, $hashed, $id);
        } else {
            $stmt = $this->db->prepare(
                "UPDATE `accounts` SET fullname = ?, email = ?, role = ?, updated_at = NOW() WHERE id = ?"
            );
            $stmt->bind_param('sssi', $fullname, $email, $role, $id);
        }
        $stmt->execute();
        $stmt->close();

        $this->auth->log($actorId, 'account_update', 'Memperbarui akun id ' . $id . ' (' . $email . ')');
    }

    public function delete(int $id, int $actorId): void
    {
        if ($id === $actorId) {
            throw new Exception('Tidak dapat menghapus akun yang sedang Anda gunakan.');
        }

        $target = $this->getById($id);
        if (!$target) {
            throw new Exception('Akun tidak ditemukan.');
        }

        if (($target['role'] ?? '') === 'admin') {
            $result = $this->db->query("SELECT COUNT(*) AS c FROM `accounts` WHERE role = 'admin'");
            $row = $result ? $result->fetch_assoc() : null;
            $adminCount = (int)($row['c'] ?? 0);
            if ($adminCount <= 1) {
                throw new Exception('Tidak dapat menghapus akun admin terakhir.');
            }
        }

        $stmt = $this->db->prepare("DELETE FROM `accounts` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        $this->auth->log($actorId, 'account_delete', 'Menghapus akun id ' . $id);
    }
}
