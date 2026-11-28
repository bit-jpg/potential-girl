<?php
declare(strict_types=1);
// Moving Forward, please comment shit.
// Thanks, Jayden
$message = '';
$messageType = '';

// Map common errors here.
$errorMesssages = [
    'login' => [
        'passwordWrong' => 'Wrong Password!',
        'studentIdNotFound' => 'Student ID does not exist.',
    ],
    'required' => [
        'password_empty' => 'Password Empty!',
        'student_id_empty' => 'Please Enter your Student ID.',
        'both_empty' => 'Both Student ID and Password are Required!',
    ],
    'invalid' => 'Invalid Student ID/Username or Password.'

];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = trim($_POST['studentId'] ?? '');
    $password = trim($_POST['studentPassword'] ?? '');

    if (!$studentId || !$password) {
        $message = $errorMesssages['required']['both_empty'];
        $messageType = 'error';
    } else {
        $dataFile = __DIR__ . '/data/registrations.json';
        $registrations = [];
        if (file_exists($dataFile)) {
            $decoded = json_decode(file_get_contents($dataFile), true);
            $registrations = is_array($decoded) ? $decoded : [];
        }

        $user = null;
        foreach ($registrations as $record) {
            if ((string)($record['id_no'] ?? '') === $studentId
                || (string)($record['username'] ?? '') === $studentId
            ) {
                $user = $record;
                break;
            }
        }

        if ($user && password_verify($password, $user['password_hash'])) {
            $message = 'Welcome back, ' . htmlspecialchars($user['first_name'] ?? 'Student') . '! Login successful.';
            $messageType = 'success';
        } else {
            $message = $errorMesssages['invalid'];
            $messageType = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Baguio College of Technology | Login Result</title>
    <link rel="icon" type="image/png" href="Images/Logos/BCTLogo.png" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="CSS/style.css" />
</head>

<body class="page-login">
    <div class="bg-slideshow" id="bgSlideshow" aria-hidden="true">
        <div class="bg-slide bg-slide-1 active"></div>
        <div class="bg-slide bg-slide-2"></div>
        <div class="bg-slide bg-slide-3"></div>
    </div>

    <div class="bg-overlay" aria-hidden="true"></div>

    <main class="login-stage">
        <section class="login-panel" aria-labelledby="schoolName">
            <div class="panel-content">
                <div class="seal-badge">
                    <img src="Images/Logos/BCTLogo.png" alt="Baguio College of Technology seal" />
                </div>

                <div class="acronym-boxes" aria-hidden="true">
                    <div class="letter-box">B</div>
                    <div class="letter-box letter-box-tall">C</div>
                    <div class="letter-box">T</div>
                </div>

                <h1 class="school-full-name" id="schoolName">Baguio College of Technology</h1>

                <svg class="motto-arc" viewBox="0 0 400 56" xmlns="http://www.w3.org/2000/svg" role="img"
                    aria-label="Leader in Technical Education since 1972">
                    <path id="mottoArcPath" d="M10 10 Q200 54 390 10" fill="none" />
                    <text class="motto-text">
                        <textPath href="#mottoArcPath" startOffset="50%" text-anchor="middle">
                            Leader in Technical Education since 1972
                        </textPath>
                    </text>
                </svg>

                <?php if ($message): ?>
                    <div class="result-box <?= htmlspecialchars($messageType) ?>">
                        <span class="icon">
                            <?= $messageType === 'success' ? '<i class="fas fa-sign-in-alt"></i>' : '<i class="fas fa-exclamation-circle"></i>' ?>
                        </span>
                        <?= nl2br(htmlspecialchars($message)) ?>
                        <p style="margin-top: .75rem;">
                            <a href="LoginPage.html" data-transition><?= $messageType === 'success' ? 'Return to Login' : 'Try Again' ?></a>
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
