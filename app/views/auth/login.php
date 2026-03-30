<?php
// Inicializar variables de error para evitar warnings
 $errors = [];
 $success = '';
 $email = '';

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // Validaciones
    if (empty($email)) {
        $errors[] = 'El correo electrónico es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'El correo electrónico no tiene un formato válido.';
    }

    if (empty($password)) {
        $errors[] = 'La contraseña es obligatoria.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
    }

    // Si no hay errores, procesar (aquí iría tu lógica de autenticación)
    if (empty($errors)) {
        // Ejemplo: verificar credenciales en base de datos
        // $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        // $stmt->execute([$email]);
        // $user = $stmt->fetch();

        // Por ahora redirigimos al registro como demo
        header('Location: register.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — Vertex</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/Login-Seminario/public/css/login.css">
</head>
<body>

<div class="login-container">

    <!-- ==================== PANEL IZQUIERDO ==================== -->
    <aside class="brand-panel">
        <div class="brand-pattern"></div>

        <div class="brand-content">
            <!-- Logo -->
            <div class="brand-logo">
                <div class="logo-icon">V</div>
                <span class="logo-text">Vertex</span>
            </div>

            <!-- Tagline -->
            <h1 class="brand-tagline">
                Impulsa tu negocio con <span>inteligencia</span> operativa
            </h1>

            <p class="brand-description">
                La plataforma integral que conecta tus equipos, optimiza procesos
                y transforma datos en decisiones estratégicas. Construida para empresas
                que buscan resultados reales.
            </p>

            <!-- Estadísticas -->
            <div class="brand-stats">
                <div class="stat-item">
                    <div class="stat-value">14k<span>+</span></div>
                    <div class="stat-label">Equipos Activos</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-value">99.9<span>%</span></div>
                    <div class="stat-label">Disponibilidad</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-value">4.9<span>/5</span></div>
                    <div class="stat-label">Valoración</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- ==================== PANEL DERECHO ==================== -->
    <main class="form-panel">

        <?php if (!empty($errors)): ?>
            <div style="
                max-width: 400px; width: 100%;
                background: #FEF2F2; border: 1px solid #FECACA;
                border-radius: 10px; padding: 14px 18px;
                margin-bottom: 20px; font-size: 13.5px; color: #DC2626;
                animation: fadeSlideUp 0.4s ease;
            ">
                <?php foreach ($errors as $error): ?>
                    <div style="margin-bottom: 4px;">&#x2022; <?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="form-wrapper">
            <!-- Encabezado -->
            <div class="form-header">
                <h2 class="form-title">Iniciar sesión</h2>
                <p class="form-subtitle">
                    ¿No tienes cuenta? <a href="/Login-Seminario/public/index.php?url=auth/register">Crear cuenta</a>
                </p>
            </div>

            <!-- Formulario -->
            <form method="POST" action="/Login-Seminario/public/index.php?url=auth/loginPost">
                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <div class="input-wrapper">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="tu@empresa.com"
                            value="<?php echo htmlspecialchars($email); ?>"
                            autocomplete="email"
                            required
                        >
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Ingresa tu contraseña"
                            autocomplete="current-password"
                            required
                        >
                        <i class="fa-regular fa-lock"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="Mostrar contraseña">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Opciones -->
                <div class="form-options">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="remember" id="remember">
                        <div class="custom-checkbox"><i class="fa-solid fa-check"></i></div>
                        <span class="checkbox-label">Recordarme</span>
                    </label>
                    <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                </div>

                <!-- Botón enviar -->
                <button type="submit" class="btn-primary">Iniciar sesión</button>
            </form>

            <!-- Separador -->
            <div class="divider">
                <span>o continúa con</span>
            </div>

            <!-- Botones sociales -->
            <div class="social-buttons">
                <button class="btn-social google" type="button">
                    <i class="fa-brands fa-google"></i>
                    Google
                </button>
                <button class="btn-social github" type="button">
                    <i class="fa-brands fa-github"></i>
                    GitHub
                </button>
            </div>

            <!-- Footer -->
            <div class="form-footer">
                &copy; 2025 Vertex. Todos los derechos reservados.
            </div>
        </div>
    </main>

</div>

<script>
    // Toggle visibilidad de contraseña
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

</body>
</html>