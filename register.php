<?php
declare(strict_types=1);

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNo = trim($_POST['id_no'] ?? '');
    $firstName = trim($_POST['first_name'] ?? '');
    $middleName = trim($_POST['middle_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $suffix = trim($_POST['suffix'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $required = [
        'ID No.' => $idNo,
        'First Name' => $firstName,
        'Last Name / Surname' => $lastName,
        'Username' => $username,
        'Password' => $password,
        'Email' => $email,
    ];
    $missing = array_keys(array_filter($required, fn ($v) => $v === ''));

    if (!empty($missing)) {
        $message = 'Please fill in all required fields: ' . implode(', ', $missing) . '.';
        $messageType = 'error';
    } elseif ($password !== $confirmPassword) {
        $message = 'Passwords do not match.';
        $messageType = 'error';
    } else {
        $dataFile = __DIR__ . '/data/registrations.json';
        $registrations = [];
        if (file_exists($dataFile)) {
            $decoded = json_decode(file_get_contents($dataFile), true);
            $registrations = is_array($decoded) ? $decoded : [];
        }

        $registrations[] = [
            'id_no' => $idNo,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'suffix' => $suffix,
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'registered_at' => date('Y-m-d H:i:s'),
        ];

        if (@file_put_contents($dataFile, json_encode($registrations, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false) {
            $message = 'Registration successful! You can now log in with your ID No. and password.';
            $messageType = 'success';
        } else {
            $message = 'Unable to save registration. Please try again.';
            $messageType = 'error';
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Baguio College of Technology | Registration Result</title>
    <link rel="icon" type="image/png" href="Images/Logos/BCTLogo.png" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="CSS/style.css" />
</head>

<body class="page-register">
    <div class="bg-slideshow" id="bgSlideshow" aria-hidden="true">
        <div class="bg-slide bg-slide-1 active"></div>
        <div class="bg-slide bg-slide-2"></div>
        <div class="bg-slide bg-slide-3"></div>
    </div>

    <div class="bg-overlay" aria-hidden="true"></div>

    <main class="login-stage">
        <section class="login-panel" aria-labelledby="schoolName">
            <div class="panel-content">
                <header class="register-header">
                    <img class="register-seal" src="Images/Logos/BCTLogo.png"
                        alt="Baguio College of Technology seal" />
                    <div class="register-heading">
                        <h1 id="schoolName">Baguio College of Technology</h1>
                        <p>Leader in Technical Education since 1972</p>
                    </div>
                </header>

                <?php if ($message): ?>
                    <div class="result-box <?= htmlspecialchars($messageType) ?>">
                        <span class="icon">
                            <?= $messageType === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>' ?>
                        </span>
                        <?= nl2br(htmlspecialchars($message)) ?>
                        <p style="margin-top: .75rem;">
                            <a href="<?= $messageType === 'success' ? 'LoginPage.html' : 'RegistrationPage.html' ?>" data-transition>
                                <?= $messageType === 'success' ? 'Go to Login' : 'Try Again' ?>
                            </a>
                        </p>
                    </div>
                <?php endif; ?>

                <p class="panel-footer">
                    &copy; 2026 Baguio College of Technology &middot; Student Portal
                </p>
            </div>
        </section>
    </main>

    <script src="JS/script.js"></script>
</body>

</html>
