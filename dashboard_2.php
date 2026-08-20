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
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada pengguna dijumpai.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include_once "includes/footer.php";
?>
