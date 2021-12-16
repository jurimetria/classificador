<?php $navBar="    <!-- BARRA DE NAVEGAÇÃO -->
    <div>

        <nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='index.php'>L&P | Classificador de Pastas</a>
                <button class='navbar-toggler ' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
            </div>

            <!-- IR RESUMO -->
            <div class='container-fluid'>
                <button type='button' class='button ' onclick=location.href='resumo.php'>Ir para Resumo</button>
            </div>
 

            <!-- CADASTRAR NOVA PASTA -->
            <div  class='container-fluid '>
                <a class='button2 ' href='pastaNova.php'>Cadastrar Nova Pasta</a>
            </div>
            

            <!-- BUSCAR PASTA SEARCH BOX -->
            <div style='padding-top:14px' class='container-fluid '>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
                <form class='searchF ' action='pastaBuscar.php' method='GET'>
                    <input type='text' name='search' placeholder='buscar pasta...'>
                    <button type='submit' name='submit-search'><i class='fa fa-search'></i></button>
                </form>
            </div>

            <div class='d-flex'>
            <p><a class='admUp' style='padding-right:20px' href='mailto:jurimetria@lp.com.br?subject=Classificador - dúvidas e sugestões' title='Contatar Administrador'> ✉  </a></p>
            </div>

            <!-- SAIR -->
            <div class='d-flex'>
                <a href='login.php' class='btn btn-danger me-5'>Sair</a>
            </div>
        </nav>
    </div><br>

"
?>