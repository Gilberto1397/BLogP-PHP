<?php
require_once __DIR__ . '/inicio-html.php';
?>

    <form>
        <div class="container d-flex flex-column mt-5">
            <div class="mb-3">
                <label for="email" class="form-label">Usuário</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

<?php
require_once __DIR__ . '/fim-html.php';