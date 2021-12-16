<?php $navBar=            "    <!-- BARRA DE NAVEGAÇÃO -->
    <div>

        <nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='index.php'>L&P | Classificador de Pastas</a>
                <button class='navbar-toggler ' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
            </div>

            <!-- BUSCAR PASTA SEARCH BOX -->
           
                <div  class=' container-fluid' style='padding-top: 14px;'>
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'></link>
                        <form class='searchF' action='pastaBuscar.php' method='GET'>
                            <input type='text' name='search' placeholder='buscar pasta...'></input>
                            <button type='submit' name='submit-search'><i class='fa fa-search '></i></button>
                        </form>
                </div>
            

            <!-- LINK PÁGINA RESUMO -->
            <div class=' container-fluid'>
            <a class='button' href='resumo.php'>Ir para Resumo</a>
            </div>
            <br>

            <!-- CADASTRAR NOVA PASTA -->
            <div class=' container-fluid'>
                <a class='button' href='pastaNova.php'>Cadastrar Nova Pasta</a>
            </div>
            <br>

            <div class='d-flex'>
            <p><a class='admUp' href='mailto:jurimetria@lp.com.br?subject=Classificador - dúvidas e sugestões' title='Contatar Administrador'> ✉  </a></p>
            </div>

            <!-- SAIR -->
            <div class='d-flex'>
                <a href='login.php' class='btn btn-danger me-5'>Sair</a>
            </div>
        </nav>
    </div><br>
    "
?>