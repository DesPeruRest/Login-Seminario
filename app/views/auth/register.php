<?php
// Inicializar variables
 $errors = [];
 $success = '';
 $name = '';
 $lastname = '';
 $email = '';
 $company = '';
 $role = '';

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $lastname = htmlspecialchars(trim($_POST['lastname'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $terms = isset($_POST['terms']);

    // Validaciones
    if (empty($name)) {
        $errors[] = 'El nombre es obligatorio.';
    } elseif (strlen($name) < 2) {
        $errors[] = 'El nombre debe tener al menos 2 caracteres.';
    }

    if (empty($lastname)) {
        $errors[] = 'El apellido es obligatorio.';
    }

    if (empty($email)) {
        $errors[] = 'El correo electrónico es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'El correo electrónico no tiene un formato válido.';
    }

    if (empty($company)) {
        $errors[] = 'El nombre de la empresa es obligatorio.';
    }

    if (empty($role) || !in_array($role, ['director', 'gerente', 'desarrollador', 'diseñador', 'otro'])) {
        $errors[] = 'Selecciona un rol válido.';
    }

    if (empty($password)) {
        $errors[] = 'La contraseña es obligatoria.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'La contraseña debe tener al menos 8 caracteres.';
    }

    if ($password !== $password_confirm) {
        $errors[] = 'Las contraseñas no coinciden.';
    }

    if (!$terms) {
        $errors[] = 'Debes aceptar los términos y condiciones.';
    }

    // Si no hay errores, procesar registro
    if (empty($errors)) {
        // Aquí iría tu lógica: hash de contraseña, inserción en BD, envío de email de verificación, etc.
        // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        // $stmt = $pdo->prepare("INSERT INTO users (name, lastname, email, company, role, password) VALUES (?, ?, ?, ?, ?, ?)");
        // $stmt->execute([$name, $lastname, $email, $company, $role, $hashedPassword]);

        // Redirigir al login como demo
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta — Vertex</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/Login-Seminario/public/css/register.css">
</head>
<body>

<div class="register-container">

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
                Únete a miles de equipos que ya <span>crecen</span> con Vertex
            </h1>

            <p class="brand-description">
                Regístrate en menos de 2 minutos y comienza a transformar la
                forma en que tu equipo trabaja. Sin tarjeta de crédito requerida.
            </p>

            <!-- Beneficios -->
            <div class="brand-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div class="feature-text">
                        <div class="feature-title">Configuración instantánea</div>
                        <div class="feature-desc">Sin configuraciones complejas. Tu espacio de trabajo listo en segundos.</div>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="feature-text">
                        <div class="feature-title">Seguridad empresarial</div>
                        <div class="feature-desc">Cifrado de extremo a extremo y cumplimiento de normativas ISO 27001.</div>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div class="feature-text">
                        <div class="feature-title">Analítica en tiempo real</div>
                        <div class="feature-desc">Dashboards inteligentes que convierten tus datos en acciones concretas.</div>
                    </div>
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
                margin-bottom: 16px; font-size: 13.5px; color: #DC2626;
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
                <h2 class="form-title">Crear tu cuenta</h2>
                <p class="form-subtitle">
                    ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
                </p>
            </div>

            <!-- Formulario -->
            <form method="POST" action="/Login-Seminario/public/index.php?url=auth/registerPost">
                <!-- Nombre y Apellido en fila -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="name">Nombre</label>
                        <div class="input-wrapper">
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-input"
                                placeholder="Carlos"
                                value="<?php echo $name; ?>"
                                autocomplete="given-name"
                                required
                            >
                            <i class="fa-regular fa-user field-icon"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lastname">Apellido</label>
                        <div class="input-wrapper">
                            <input
                                type="text"
                                id="lastname"
                                name="lastname"
                                class="form-input"
                                placeholder="Ramírez"
                                value="<?php echo $lastname; ?>"
                                autocomplete="family-name"
                                required
                            >
                            <i class="fa-regular fa-user field-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">Correo electrónico corporativo</label>
                    <div class="input-wrapper">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="carlos@tuempresa.com"
                            value="<?php echo htmlspecialchars($email); ?>"
                            autocomplete="email"
                            required
                        >
                        <i class="fa-regular fa-envelope field-icon"></i>
                    </div>
                </div>

                <!-- Empresa -->
                <div class="form-group">
                    <label class="form-label" for="company">Nombre de la empresa</label>
                    <div class="input-wrapper">
                        <input
                            type="text"
                            id="company"
                            name="company"
                            class="form-input"
                            placeholder="Tu empresa S.A."
                            value="<?php echo $company; ?>"
                            autocomplete="organization"
                            required
                        >
                        <i class="fa-regular fa-building field-icon"></i>
                    </div>
                </div>

                <!-- Rol -->
                <div class="form-group">
                    <label class="form-label" for="role">Tu rol en la empresa</label>
                    <div class="input-wrapper">
                        <select id="role" name="role" class="form-select" required>
                            <option value="" disabled selected>Selecciona tu rol</option>
                            <option value="director" <?php echo ($role === 'director') ? 'selected' : ''; ?>>Director / CEO</option>
                            <option value="gerente" <?php echo ($role === 'gerente') ? 'selected' : ''; ?>>Gerente / Líder</option>
                            <option value="desarrollador" <?php echo ($role === 'desarrollador') ? 'selected' : ''; ?>>Desarrollador</option>
                            <option value="diseñador" <?php echo ($role === 'diseñador') ? 'selected' : ''; ?>>Diseñador</option>
                            <option value="otro" <?php echo ($role === 'otro') ? 'selected' : ''; ?>>Otro</option>
                        </select>
                        <i class="fa-regular fa-id-badge field-icon"></i>
                        <span class="select-arrow"><i class="fa-solid fa-chevron-down"></i></span>
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
                            placeholder="Mínimo 8 caracteres"
                            autocomplete="new-password"
                            required
                            oninput="checkStrength(this.value)"
                        >
                        <i class="fa-regular fa-lock field-icon"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="Mostrar contraseña">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <!-- Indicador de fuerza -->
                    <div class="password-strength">
                        <div class="strength-bar" id="bar1"></div>
                        <div class="strength-bar" id="bar2"></div>
                        <div class="strength-bar" id="bar3"></div>
                        <div class="strength-bar" id="bar4"></div>
                    </div>
                    <div class="strength-text" id="strengthText"></div>
                </div>

                <!-- Confirmar contraseña -->
                <div class="form-group">
                    <label class="form-label" for="password_confirm">Confirmar contraseña</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password_confirm"
                            name="password_confirm"
                            class="form-input"
                            placeholder="Repite tu contraseña"
                            autocomplete="new-password"
                            required
                        >
                        <i class="fa-regular fa-lock field-icon"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirm', this)" aria-label="Mostrar contraseña">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Términos -->
                <div class="terms-wrapper">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="terms" id="terms">
                        <div class="custom-checkbox"><i class="fa-solid fa-check"></i></div>
                        <span class="terms-label">
                            Acepto los <a href="#">Términos de Servicio</a> y la
                            <a href="#">Política de Privacidad</a>
                        </span>
                    </label>
                </div>

                <!-- Botón enviar -->
                <button type="submit" class="btn-primary">Crear mi cuenta</button>
            </form>

            <!-- Separador -->
            <div class="divider">
                <span>o regístrate con</span>
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

    // Indicador de fuerza de contraseña
    function checkStrength(password) {
        const bars = [
            document.getElementById('bar1'),
            document.getElementById('bar2'),
            document.getElementById('bar3'),
            document.getElementById('bar4')
        ];
        const text = document.getElementById('strengthText');

        // Reset
        bars.forEach(bar => {
            bar.className = 'strength-bar';
        });
        text.textContent = '';
        text.className = 'strength-text';

        if (password.length === 0) return;

        let score = 0;

        // Criterios
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        if (/[A-Z]/.test(password) && /[a-z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        // Mapear score a niveles
        let level = 0;
        let label = '';
        let cssClass = '';

        if (score <= 1) {
            level = 1;
            label = 'Débil';
            cssClass = 'weak';
        } else if (score <= 3) {
            level = 2;
            label = 'Media';
            cssClass = 'medium';
        } else if (score <= 4) {
            level = 3;
            label = 'Buena';
            cssClass = 'medium';
        } else {
            level = 4;
            label = 'Fuerte';
            cssClass = 'strong';
        }

        for (let i = 0; i < level; i++) {
            bars[i].classList.add('active', cssClass);
        }

        text.textContent = label;
        text.classList.add(cssClass);
    }
</script>

</body>
</html>