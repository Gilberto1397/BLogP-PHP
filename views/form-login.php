<?php
require_once __DIR__ . '/inicio-html.php';
?>

    <form method="post">
        <div class="container d-flex flex-column mt-5">
            <div class="mb-3">
                <label for="email" class="form-label">Usuário</label>
                <input type="email" name="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Lembrar-me</label>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </div>
    </form>

<?php
require_once __DIR__ . '/fim-html.php';