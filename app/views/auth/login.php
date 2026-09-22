<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="form-card">
    <h2 style="text-align: center; margin-bottom: 1.5rem; color: var(--dark-color);">Iniciar Sesión</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert-message" style="background-color: #ffe0e3; color: #d63031; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="/auth/login" method="POST">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control" required placeholder="correo@ejemplo.com">
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">Ingresar</button>
    </form>

    <p style="text-align: center; margin-top: 1.2rem; font-size: 0.9rem;">
        ¿No tienes cuenta aún? <a href="/auth/registro" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Crea una aquí</a>
    </p>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>