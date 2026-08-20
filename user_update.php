<?php
include_once "includes/db_connect.php";
include_once "includes/header.php";

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_msg'] = [
        'type' => 'error',
        'msg' => 'Sila log masuk untuk mengakses halaman ini.'
    ];
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['flash_msg'] = [
        'type' => 'error',
        'msg' => 'ID pengguna tidak sah.'
    ];
    header("Location: dashboard_2 copy.php");
    exit;
}

$sqlUser = "SELECT id, name, nric, program, role FROM users WHERE id = ?";
$stmtUser = $conn->prepare($sqlUser);
$user = null;

if ($stmtUser) {
    $stmtUser->bind_param("i", $id);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    $user = $resultUser ? $resultUser->fetch_assoc() : null;
    $stmtUser->close();
}

if (!$user) {
    $_SESSION['flash_msg'] = [
        'type' => 'error',
        'msg' => 'Rekod pengguna tidak dijumpai.'
    ];
    header("Location: dashboard_2 copy.php");
    exit;
}

// Nota: Proses update dibuat dalam halaman berasingan untuk tujuan pembelajaran CRUD.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $nric = trim($_POST['nric'] ?? '');
    $program = trim($_POST['program'] ?? '');
    $role = trim($_POST['role'] ?? 'student');

    if ($name === '' || $nric === '' || strlen($nric) !== 12) {
        $_SESSION['flash_msg'] = [
            'type' => 'error',
            'msg' => 'Data tidak sah. Pastikan nama diisi dan IC 12 digit.'
        ];
        header("Location: user_update.php?id=" . $id);
        exit;
    }

    $sqlUpdate = "UPDATE users SET name = ?, nric = ?, program = ?, role = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);

    if ($stmtUpdate) {
        $stmtUpdate->bind_param("ssssi", $name, $nric, $program, $role, $id);
        if ($stmtUpdate->execute()) {
            $_SESSION['flash_msg'] = [
                'type' => 'success',
                'msg' => 'Rekod berjaya dikemaskini.'
            ];
            $stmtUpdate->close();
            header("Location: dashboard_2 copy.php");
            exit;
        }
        $stmtUpdate->close();
    }

    $_SESSION['flash_msg'] = [
        'type' => 'error',
        'msg' => 'Gagal kemaskini rekod.'
    ];
    header("Location: user_update.php?id=" . $id);
    exit;
}
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kemaskini Pengguna</h2>
        <a href="dashboard_2 copy.php" class="btn btn-secondary btn-sm">Kembali Dashboard</a>
    </div>

    <div class="card">
        <div class="card-header">Edit Rekod ID: <?php echo (int) $user['id']; ?></div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. IC</label>
                        <input type="text" name="nric" class="form-control" maxlength="12" value="<?php echo htmlspecialchars($user['nric']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Program</label>
                        <input type="text" name="program" class="form-control" value="<?php echo htmlspecialchars($user['program']); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="student" <?php echo ($user['role'] === 'student') ? 'selected' : ''; ?>>student</option>
                            <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>admin</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="dashboard_2 copy.php" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once "includes/footer.php";
?>
