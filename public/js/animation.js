
        /* ========================================
           INICIALIZACIÓN DE ICONOS LUCIDE
        ======================================== */
        lucide.createIcons();

        /* ========================================
           SISTEMA DE TOAST NOTIFICATIONS
        ======================================== */
        function showToast(message, type = 'info', duration = 3500) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            // Seleccionar icono según tipo
            const iconMap = { success: 'check-circle', error: 'alert-circle', info: 'info' };
            toast.innerHTML = `<i data-lucide="${iconMap[type] || 'info'}"></i><span>${message}</span>`;
            container.appendChild(toast);
            lucide.createIcons({ nodes: [toast] });

            setTimeout(() => {
                toast.classList.add('exit');
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }

        /* ========================================
           TOGGLE DE VISIBILIDAD DE CONTRASEÑA
        ======================================== */
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const target = document.getElementById(btn.dataset.target);
                const isPassword = target.type === 'password';
                target.type = isPassword ? 'text' : 'password';
                // Cambiar icono
                const icon = btn.querySelector('i');
                icon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
                lucide.createIcons({ nodes: [btn] });
            });
        });

        /* ========================================
           EFECTO 3D TILT EN LA TARJETA
        ======================================== */
        const card = document.getElementById('authCard');
        let tiltEnabled = true;

        // Desactivar tilt en dispositivos táctiles
        if ('ontouchstart' in window) {
            tiltEnabled = false;
        }

        if (tiltEnabled) {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = ((y - centerY) / centerY) * -4;
                const rotateY = ((x - centerX) / centerX) * 4;

                card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'rotateX(0deg) rotateY(0deg)';
            });
        }

        /* ========================================
           NAVEGACIÓN ENTRE FORMULARIOS
        ======================================== */
        const loginView = document.getElementById('loginView');
        const registerView = document.getElementById('registerView');

        function switchView(from, to) {
            from.classList.add('exit-left');
            setTimeout(() => {
                from.classList.remove('active', 'exit-left');
                to.classList.add('active');
                // Re-crear iconos en la nueva vista
                lucide.createIcons();
                clearAllErrors();
            }, 350);
        }

        document.getElementById('goToRegister').addEventListener('click', (e) => {
            e.preventDefault();
            switchView(loginView, registerView);
        });

        document.getElementById('goToLogin').addEventListener('click', (e) => {
            e.preventDefault();
            switchView(registerView, loginView);
        });

        document.getElementById('forgotLink').addEventListener('click', (e) => {
            e.preventDefault();
            showToast('Se ha enviado un enlace de recuperacion a tu correo', 'info');
        });

        /* ========================================
           VALIDACIÓN DE FORMULARIOS
        ======================================== */
        function showError(inputId, errorId) {
            document.getElementById(inputId).classList.add('error');
            document.getElementById(inputId).classList.remove('valid');
            document.getElementById(errorId).classList.add('show');
        }

        function showValid(inputId, errorId) {
            document.getElementById(inputId).classList.remove('error');
            document.getElementById(inputId).classList.add('valid');
            document.getElementById(errorId).classList.remove('show');
        }

        function clearError(inputId, errorId) {
            document.getElementById(inputId).classList.remove('error', 'valid');
            document.getElementById(errorId).classList.remove('show');
        }

        function clearAllErrors() {
            document.querySelectorAll('.error-msg').forEach(el => el.classList.remove('show'));
            document.querySelectorAll('input').forEach(el => el.classList.remove('error', 'valid'));
            // Resetear barra de fortaleza
            const bar = document.getElementById('strengthBar');
            bar.className = 'strength-bar';
            document.getElementById('strengthLabel').textContent = '';
        }

        // Validación en tiempo real para login
        document.getElementById('loginUser').addEventListener('input', function() {
            if (this.value.trim().length > 0) {
                showValid('loginUser', 'loginUserError');
            } else {
                clearError('loginUser', 'loginUserError');
            }
        });

        document.getElementById('loginPass').addEventListener('input', function() {
            if (this.value.length > 0) {
                showValid('loginPass', 'loginPassError');
            } else {
                clearError('loginPass', 'loginPassError');
            }
        });

        // Validación en tiempo real para registro
        document.getElementById('regUser').addEventListener('input', function() {
            if (this.value.trim().length >= 3) {
                showValid('regUser', 'regUserError');
            } else if (this.value.trim().length > 0) {
                showError('regUser', 'regUserError');
            } else {
                clearError('regUser', 'regUserError');
            }
        });

        document.getElementById('regEmail').addEventListener('input', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailRegex.test(this.value)) {
                showValid('regEmail', 'regEmailError');
            } else if (this.value.length > 0) {
                showError('regEmail', 'regEmailError');
            } else {
                clearError('regEmail', 'regEmailError');
            }
        });

        // Barra de fortaleza de contraseña
        document.getElementById('regPass').addEventListener('input', function() {
            const val = this.value;
            const bar = document.getElementById('strengthBar');
            const label = document.getElementById('strengthLabel');
            let score = 0;

            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
            if (/[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val)) score++;

            bar.className = 'strength-bar' + (score > 0 ? ` s${score}` : '');

            const labels = ['', 'Debil', 'Regular', 'Buena', 'Fuerte'];
            const colors = ['', 'var(--danger)', '#ff9f43', '#ffd32a', 'var(--success)'];
            label.textContent = val.length > 0 ? labels[score] : '';
            label.style.color = colors[score];

            if (val.length >= 6) {
                showValid('regPass', 'regPassError');
            } else if (val.length > 0) {
                showError('regPass', 'regPassError');
            } else {
                clearError('regPass', 'regPassError');
            }

            // Revalidar confirmación si ya tiene valor
            const confirm = document.getElementById('regPassConfirm');
            if (confirm.value.length > 0) {
                if (confirm.value === val) {
                    showValid('regPassConfirm', 'regPassConfirmError');
                } else {
                    showError('regPassConfirm', 'regPassConfirmError');
                }
            }
        });

        document.getElementById('regPassConfirm').addEventListener('input', function() {
            const pass = document.getElementById('regPass').value;
            if (this.value === pass && this.value.length > 0) {
                showValid('regPassConfirm', 'regPassConfirmError');
            } else if (this.value.length > 0) {
                showError('regPassConfirm', 'regPassConfirmError');
            } else {
                clearError('regPassConfirm', 'regPassConfirmError');
            }
        });

        /* ========================================
           ENVÍO DE FORMULARIOS
        ======================================== */
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const user = document.getElementById('loginUser').value.trim();
            const pass = document.getElementById('loginPass').value;
            let valid = true;

            if (!user) { showError('loginUser', 'loginUserError'); valid = false; }
            if (!pass) { showError('loginPass', 'loginPassError'); valid = false; }

            if (!valid) return;

            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');

            // Simulación de llamada al servidor
            setTimeout(() => {
                btn.classList.remove('loading');

                // Credenciales de demo: admin / admin123
                if (user === 'admin' && pass === 'admin123') {
                    showToast('Bienvenido, administrador', 'success');
                    // Efecto de éxito en la tarjeta
                    card.style.boxShadow = '0 0 0 2px var(--accent), 0 30px 80px -20px rgba(0,0,0,0.6), 0 0 80px -10px var(--accent-glow)';
                    setTimeout(() => {
                        card.style.boxShadow = '';
                    }, 2000);
                } else {
                    showToast('Credenciales incorrectas. Intenta con admin / admin123', 'error');
                    // Efecto de error (shake)
                    card.style.animation = 'none';
                    card.offsetHeight; // forzar reflow
                    card.style.animation = 'shake 0.5s ease';
                }
            }, 1500);
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const user = document.getElementById('regUser').value.trim();
            const email = document.getElementById('regEmail').value;
            const pass = document.getElementById('regPass').value;
            const passConfirm = document.getElementById('regPassConfirm').value;
            let valid = true;

            if (user.length < 3) { showError('regUser', 'regUserError'); valid = false; }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showError('regEmail', 'regEmailError'); valid = false; }
            if (pass.length < 6) { showError('regPass', 'regPassError'); valid = false; }
            if (pass !== passConfirm) { showError('regPassConfirm', 'regPassConfirmError'); valid = false; }

            if (!valid) return;

            const btn = document.getElementById('registerBtn');
            btn.classList.add('loading');

            setTimeout(() => {
                btn.classList.remove('loading');
                showToast('Cuenta creada exitosamente. Ya puedes iniciar sesion.', 'success');

                // Cambiar a login después de un momento
                setTimeout(() => {
                    switchView(registerView, loginView);
                    // Pre-llenar usuario
                    document.getElementById('loginUser').value = user;
                    showValid('loginUser', 'loginUserError');
                }, 1200);
            }, 1800);
        });

        // Botones sociales
        document.getElementById('btnGoogle').addEventListener('click', () => {
            showToast('Redirigiendo a Google Sign-In...', 'info');
        });
        document.getElementById('btnMicrosoft').addEventListener('click', () => {
            showToast('Redirigiendo a Microsoft Azure AD...', 'info');
        });

        /* ========================================
           ANIMACIÓN SHAKE (inyectada dinámicamente)
        ======================================== */
        const shakeStyle = document.createElement('style');
        shakeStyle.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 50%, 90% { transform: translateX(-6px); }
                30%, 70% { transform: translateX(6px); }
            }
        `;
        document.head.appendChild(shakeStyle);

        /* ========================================
           PARTÍCULAS DECORATIVAS CSS
        ======================================== */
        (function createFloatingDots() {
            const container = document.getElementById('floatingDots');
            const count = window.innerWidth < 768 ? 12 : 25;

            for (let i = 0; i < count; i++) {
                const dot = document.createElement('div');
                dot.className = 'dot';
                dot.style.left = Math.random() * 100 + '%';
                dot.style.animationDuration = (8 + Math.random() * 14) + 's';
                dot.style.animationDelay = (Math.random() * 10) + 's';
                dot.style.width = dot.style.height = (2 + Math.random() * 3) + 'px';
                container.appendChild(dot);
            }
        })();

        /* ========================================
           ESCENA 3D CON THREE.JS
           - Esfera wireframe animada
           - Partículas flotantes
           - Anillo toroidal sutil
           - Interacción con el mouse
        ======================================== */
        (function init3DScene() {
            const canvas = document.getElementById('bgCanvas');
            const renderer = new THREE.WebGLRenderer({
                canvas,
                antialias: true,
                alpha: true
            });

            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(55, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.z = 6;

            // Color de la escena
            const accentColor = new THREE.Color(0x00d4aa);
            const secondaryColor = new THREE.Color(0x006a88);

            // === ESFERA WIREFRAME ===
            const sphereGeo = new THREE.IcosahedronGeometry(1.8, 2);
            const sphereMat = new THREE.MeshBasicMaterial({
                color: accentColor,
                wireframe: true,
                transparent: true,
                opacity: 0.08
            });
            const sphere = new THREE.Mesh(sphereGeo, sphereMat);
            scene.add(sphere);

            // === ESFERA INTERIOR ===
            const innerGeo = new THREE.IcosahedronGeometry(1.2, 1);
            const innerMat = new THREE.MeshBasicMaterial({
                color: secondaryColor,
                wireframe: true,
                transparent: true,
                opacity: 0.06
            });
            const innerSphere = new THREE.Mesh(innerGeo, innerMat);
            scene.add(innerSphere);

            // === ANILLO TOROIDAL ===
            const torusGeo = new THREE.TorusGeometry(2.6, 0.02, 16, 100);
            const torusMat = new THREE.MeshBasicMaterial({
                color: accentColor,
                transparent: true,
                opacity: 0.12
            });
            const torus = new THREE.Mesh(torusGeo, torusMat);
            torus.rotation.x = Math.PI * 0.45;
            scene.add(torus);

            // === SEGUNDO ANILLO ===
            const torus2Geo = new THREE.TorusGeometry(3.0, 0.015, 16, 100);
            const torus2Mat = new THREE.MeshBasicMaterial({
                color: secondaryColor,
                transparent: true,
                opacity: 0.07
            });
            const torus2 = new THREE.Mesh(torus2Geo, torus2Mat);
            torus2.rotation.x = Math.PI * 0.6;
            torus2.rotation.y = Math.PI * 0.3;
            scene.add(torus2);

            // === PARTÍCULAS ===
            const particleCount = window.innerWidth < 768 ? 400 : 800;
            const particleGeo = new THREE.BufferGeometry();
            const positions = new Float32Array(particleCount * 3);
            const sizes = new Float32Array(particleCount);

            for (let i = 0; i < particleCount; i++) {
                const i3 = i * 3;
                // Distribución esférica
                const radius = 2 + Math.random() * 5;
                const theta = Math.random() * Math.PI * 2;
                const phi = Math.acos(2 * Math.random() - 1);

                positions[i3] = radius * Math.sin(phi) * Math.cos(theta);
                positions[i3 + 1] = radius * Math.sin(phi) * Math.sin(theta);
                positions[i3 + 2] = radius * Math.cos(phi);

                sizes[i] = Math.random() * 2 + 0.5;
            }

            particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            particleGeo.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

            // Shader personalizado para partículas circulares suaves
            const particleMat = new THREE.ShaderMaterial({
                uniforms: {
                    uColor: { value: accentColor },
                    uOpacity: { value: 0.6 }
                },
                vertexShader: `
                    attribute float size;
                    void main() {
                        vec4 mvPosition = modelViewMatrix * vec4(position, 1.0);
                        gl_PointSize = size * (200.0 / -mvPosition.z);
                        gl_Position = projectionMatrix * mvPosition;
                    }
                `,
                fragmentShader: `
                    uniform vec3 uColor;
                    uniform float uOpacity;
                    void main() {
                        float d = length(gl_PointCoord - vec2(0.5));
                        if (d > 0.5) discard;
                        float alpha = smoothstep(0.5, 0.1, d) * uOpacity;
                        gl_FragColor = vec4(uColor, alpha);
                    }
                `,
                transparent: true,
                depthWrite: false,
                blending: THREE.AdditiveBlending
            });

            const particles = new THREE.Points(particleGeo, particleMat);
            scene.add(particles);

            // === SEGUNDO SISTEMA DE PARTÍCULAS (color secundario) ===
            const particle2Count = window.innerWidth < 768 ? 150 : 300;
            const particle2Geo = new THREE.BufferGeometry();
            const pos2 = new Float32Array(particle2Count * 3);
            const sizes2 = new Float32Array(particle2Count);

            for (let i = 0; i < particle2Count; i++) {
                const i3 = i * 3;
                const radius = 1.5 + Math.random() * 3;
                const theta = Math.random() * Math.PI * 2;
                const phi = Math.acos(2 * Math.random() - 1);
                pos2[i3] = radius * Math.sin(phi) * Math.cos(theta);
                pos2[i3 + 1] = radius * Math.sin(phi) * Math.sin(theta);
                pos2[i3 + 2] = radius * Math.cos(phi);
                sizes2[i] = Math.random() * 1.5 + 0.3;
            }

            particle2Geo.setAttribute('position', new THREE.BufferAttribute(pos2, 3));
            particle2Geo.setAttribute('size', new THREE.BufferAttribute(sizes2, 1));

            const particle2Mat = new THREE.ShaderMaterial({
                uniforms: {
                    uColor: { value: secondaryColor },
                    uOpacity: { value: 0.4 }
                },
                vertexShader: particleMat.vertexShader,
                fragmentShader: particleMat.fragmentShader,
                transparent: true,
                depthWrite: false,
                blending: THREE.AdditiveBlending
            });

            const particles2 = new THREE.Points(particle2Geo, particle2Mat);
            scene.add(particles2);

            // === RATÓN PARA INTERACCIÓN ===
            const mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };

            document.addEventListener('mousemove', (e) => {
                mouse.targetX = (e.clientX / window.innerWidth - 0.5) * 2;
                mouse.targetY = -(e.clientY / window.innerHeight - 0.5) * 2;
            });

            // === RESIZE ===
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
                renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            });

            // === LOOP DE ANIMACIÓN ===
            const clock = new THREE.Clock();

            function animate() {
                requestAnimationFrame(animate);

                const t = clock.getElapsedTime();

                // Suavizado del mouse
                mouse.x += (mouse.targetX - mouse.x) * 0.04;
                mouse.y += (mouse.targetY - mouse.y) * 0.04;

                // Rotación de esferas
                sphere.rotation.x = t * 0.08 + mouse.y * 0.3;
                sphere.rotation.y = t * 0.12 + mouse.x * 0.3;

                innerSphere.rotation.x = -t * 0.1 + mouse.y * 0.2;
                innerSphere.rotation.y = -t * 0.15 + mouse.x * 0.2;

                // Rotación de anillos
                torus.rotation.z = t * 0.06;
                torus2.rotation.z = -t * 0.04;

                // Movimiento de partículas
                particles.rotation.y = t * 0.02 + mouse.x * 0.15;
                particles.rotation.x = t * 0.01 + mouse.y * 0.1;

                particles2.rotation.y = -t * 0.03 + mouse.x * 0.1;
                particles2.rotation.x = -t * 0.015 + mouse.y * 0.08;

                // Cámara sigue sutilmente al mouse
                camera.position.x = mouse.x * 0.3;
                camera.position.y = mouse.y * 0.2;
                camera.lookAt(0, 0, 0);

                // Pulso sutil en la opacidad de las esferas
                sphereMat.opacity = 0.06 + Math.sin(t * 0.8) * 0.02;
                innerMat.opacity = 0.04 + Math.sin(t * 1.2 + 1) * 0.02;

                renderer.render(scene, camera);
            }

            animate();
        })();