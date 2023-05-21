<script>
    function botoesNavbar() {
        let logado = document.getElementById('logado');
        let homeBtn = document.getElementById('home');
        let novoBtn = document.getElementById('novoPost');
        let entrarBtn = document.getElementById('entrar');
        let sairBtn = document.getElementById('sair');
        let criarBtn = document.getElementById('criarUsuario');

        if (logado.value !== '') {
            entrarBtn.style.cssText = 'display: none';
            criarBtn.style.cssText = 'display: none';
        } else {
            homeBtn.style.cssText = 'display: none';
            novoBtn.style.cssText = 'display: none';
            sairBtn.style.cssText = 'display: none';
        }
    }
    botoesNavbar();
</script>

</body>
</html>