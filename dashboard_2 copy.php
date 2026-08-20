<?php
include_once "includes/db_connect.php";
include_once "includes/header.php";

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_msg'] = [
        'type' => 'error',
        'msg' => 'Sila log masuk untuk mengakses dashboard.'
    ];
    header("Location: login.php");
    exit;
}

// Nota: Dashboard proses delete, manakala update dibuat di halaman berasingan.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($action === 'delete' && $id > 0) {
$sqlDelete = "DELETE FROM users WHERE id = ?";
$stmtDelete = $conn->prepare($sqlDelete);
$stmtDelete->bind_param("i", $id);
$stmtDelete->execute();
$stmtDelete->close();

        if ($stmtDelete) {
            $stmtDelete->bind_param("i", $id);
            if ($stmtDelete->execute()) {
                $_SESSION['flash_msg'] = ['type' => 'success', 'msg' => 'Rekod berjaya dipadam.'];
            } else {
                $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Gagal padam rekod.'];
            }
            $stmtDelete->close();
        } else {
            $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Gagal padam rekod.'];
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$sql = "SELECT id, name, nric, program, role FROM users ORDER BY id ASC";
$result = $conn->query($sql);
$users = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard</h2>
        <div>
            <span class="me-3">Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Log Keluar</a>
        </div>
    </div>

    <h4 class="mb-3">Senarai Pengguna</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>No. IC</th>
                    <th>Program</th>
                    <th>Role</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0) : ?>
                    <?php foreach ($users as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['nric']); ?></td>
                            <td><?php echo htmlspecialchars($row['program']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td class="d-flex gap-2">
                                <a href="user_update.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Update</a>
                                <form method="POST" action="" onsubmit="return confirm('Padam rekod ini?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada pengguna dijumpai.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include_once "includes/footer.php";
?>
