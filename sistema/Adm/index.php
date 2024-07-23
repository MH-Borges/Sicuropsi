<?php
session_start();
require_once("../configs/conexao.php");

$emailUserSessao = @$_SESSION['email_user'];
$query = $pdo->query("SELECT * FROM usuarios WHERE email = '$emailUserSessao' LIMIT 1");
$dados = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($dados) > 0){
    $nomeAdm = $dados[0]['nome_Completo'];
    $temaAdm = $dados[0]['tema'];
    $telefoneAdm = $dados[0]['telefone'];
    $senhaAdm = $dados[0]['senha'];
    $dataRegistroAdm = $dados[0]['data_Registro'];

    setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
    $date = strftime(" %B de %Y", strtotime($dataRegistroAdm));
} 
else {
    $_SESSION['msg_perfilInvalido'] = "<div class='msgPerfilInvalido' style='left: 1.5vw !important; background:#CC101D;'>Usuario não encontrado!</div>";
    header("Location: ../../links.php");
}

?> 


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Inove | Administrativo</title>
    <link rel="icon" href="../../assets/icon.svg" />

    <script src="../../js/svg-inject.min.js"></script>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    
    <!-- Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Main files -->
    <link rel="stylesheet" href="../../css/Back/style.min.css">

    <script src="../js/Adm/dataTables.min.js"></script>
    <script defer src="../js/Adm/main.min.js"></script>
</head>

<?php
    if($temaAdm === 'light'){ echo '<body class="TelaAdm light-theme">'; }
    else{ echo '<body class="TelaAdm">'; }
?>
    <img class="textura_adm" src="../../assets/backgrounds/textura_adm.webp" alt="adm texture">

    <?php
        if (isset($_SESSION['Alertas'])) {
            echo $_SESSION['Alertas'];
            unset($_SESSION['Alertas']);
        }
    ?>

    <header>
        <div class="Notificacoes">
            <button type="button" data-toggle="dropdown" aria-expanded="false">
                <?php 
                    $query = $pdo->query("SELECT * FROM notificacoes where status_notif = 'ativa' ");
                    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                    $number = count($dados);
                    if($number !== 0){
                        echo "<span class='notif_num'>$number</span>";
                    }
                ?>
                <img src="../../assets/icons/notf.svg" >
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                <h3>Notificações</h3>
                <div class="block-dropdow">
                    <?php 
                        $query = $pdo->query("SELECT * FROM notificacoes ORDER BY id DESC LIMIT 8");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        for ($i=0; $i < count($dados); $i++) { 
                            $id = $dados[$i]['id'];
                            $acao = $dados[$i]['acao'];
                            $mensagem = $dados[$i]['mensagem'];
                            $status = $dados[$i]['status_notif'];

                            if($acao === 'clique'){ $acao = 'click.svg'; }
                            if($acao === 'carrinho'){ $acao = 'bag.svg'; }
                            if($acao === 'visualizacao'){ $acao = 'eye.svg'; }
                            if($acao === 'estoque_baixo'){ $acao = 'boxes.svg'; }
                            if($acao === 'sem_estoque'){ $acao = 'produtos_Sem_Estoque.svg'; }
                            if($acao === 'final_compra'){ $acao = 'cart.svg'; }

                            echo " 
                                <div class='dropdown-item $status' onmouseover='status(this)'>
                                    <span class='hide'>$id</span>    
                                    <img src='../../assets/icons/$acao' onload='SVGInject(this)'>
                                    <h3>$mensagem</h3>
                                </div>
                            ";
                        }
                    ?>
                </div>
                <a class='link' href="index.php?pag=notificacoes"> Ver mais... </a>
            </div>
        </div>

        <div class="User_config">
            <button type="button" data-toggle="dropdown" aria-expanded="false">
                <img src="../../assets/icons/user.svg" >
            </button>

            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                <button class="dropdown-item" type="button" data-toggle="modal" data-target="#ModalLogout">
                    <p>Sair</p>
                    <img src="../../assets/icons/logout.svg" >
                </button>
                <button class="dropdown-item" type="button" data-toggle="modal" data-target="#ModalEditPerfil">
                    <p>Editar dados</p>
                    <img src="../../assets/icons/user_config.svg" >
                </button>
            </div>
        </div>
    </header>

    <main>
        <aside class="sideMenu">
            <a href="https://autoinove.com.br" class="goHome">
                <img src="../../assets/logo_Horizontal.svg" >
            </a>

            <?php
                if (@$_GET["pag"] == null || @$_GET["pag"] == "home") {
                    echo '<a class="itens active" href="index.php?pag=home">';
                } else { echo '<a class="itens" href="index.php?pag=home">';}
            ?>
                <img src="../../assets/icons/home.svg" >  
                <p>Inicio</p>
            </a>


            <?php
                if (@$_GET["pag"] == "homeProduto" || @$_GET["pag"] == "categoriasProduto" || @$_GET["pag"] == "listagemProduto"){
                    echo '<button class="itens btnProdutos active" type="button" data-toggle="collapse" data-target="#ProdutosListMenu" aria-expanded="true">';
                } else { echo '<button class="itens btnProdutos" type="button" data-toggle="collapse" data-target="#ProdutosListMenu" aria-expanded="false">'; }
            ?>
                <img src="../../assets/icons/boxes.svg" >  
                <p>Produtos</p>
                <img class="seta" src="../../assets/icons/seta.svg" onload="SVGInject(this)">
            </button>


            <?php
                if (@$_GET["pag"] == "homeProduto" || @$_GET["pag"] == "categoriasProduto" || @$_GET["pag"] == "listagemProduto"){
                    echo '<div class="collapse show" id="ProdutosListMenu">';
                } else { echo '<div class="collapse" id="ProdutosListMenu">'; }
            ?>
                <?php
                    if (@$_GET["pag"] == "homeProduto") { echo '<a class="active" href="index.php?pag=homeProduto">Resumo</a>'; }
                    else { echo '<a href="index.php?pag=homeProduto">Resumo</a>'; }
                ?>

                <?php
                    if (@$_GET["pag"] == "categoriasProduto") { echo '<a class="active" href="index.php?pag=categoriasProduto">Categorias & Sub-Categorias</a>'; }
                    else { echo '<a href="index.php?pag=categoriasProduto">Categorias & Sub-Categorias</a>'; }
                ?>

                <?php
                    if (@$_GET["pag"] == "listagemProduto") { echo '<a class="active" href="index.php?pag=listagemProduto">Produtos & Códigos</a>'; }
                    else { echo '<a href="index.php?pag=listagemProduto">Produtos & Códigos</a>'; }
                ?>
            </div>


            <?php
                if (@$_GET["pag"] == "relatorios" || @$_GET["pag"] == "maisVistos" || @$_GET["pag"] == "maisVendidos" || @$_GET["pag"] == "ultimasVendas" || @$_GET["pag"] == "semEstoque" || @$_GET["pag"] == "notificacoes") {
                    echo '<a class="itens active" href="index.php?pag=relatorios">';
                } else { echo '<a class="itens" href="index.php?pag=relatorios">';}
            ?>
                <img src="../../assets/icons/relatorio.svg" >  
                <p>Relatórios</p>
            </a>


            <form id="themeSwitch" method="POST">
                <input type="hidden" id="idTheme" name="idTheme" value="<?php echo @$_SESSION['id_user'] ?>" required>
                <input type="hidden" id="theme" name="theme" value="<?php echo $temaAdm ?>" required>
                <button class="switch" type="button"></button>
                <div class="sun">
                    <img src="../../assets/icons/sun.svg">
                    <p>Claro</p>
                </div>
                <div class="moon">
                    <img src="../../assets/icons/moon.svg">
                    <p>Escuro</p>
                </div>
                <div class="msgErro" id="msgErro_themeSwitch"></div>
            </form>

            <a class="backup" href="./Main_menus/backup.php">Backup</a>
        </aside>
        
        
        <?php 
            if (@$_GET["pag"] == null || @$_GET["pag"] == "home") { include_once("Home/home.php"); }
            //produto
            else if (@$_GET["pag"] == "homeProduto") { include_once("Produtos/home.php"); }
            else if (@$_GET["pag"] == "categoriasProduto") { include_once("Produtos/categoriasProduto.php"); }
            else if (@$_GET["pag"] == "listagemProduto") { include_once("Produtos/listagemProduto.php"); }
            //relatorios
            else if (@$_GET["pag"] == "relatorios") { include_once("Relatorios/home.php"); }
            else if (@$_GET["pag"] == "maisVistos") { include_once("Relatorios/maisVistos.php"); }
            else if (@$_GET["pag"] == "maisVendidos") { include_once("Relatorios/maisVendidos.php"); }
            else if (@$_GET["pag"] == "ultimasVendas") { include_once("Relatorios/ultimasVendas.php"); }
            else if (@$_GET["pag"] == "semEstoque") { include_once("Relatorios/semEstoque.php"); }
            else if (@$_GET["pag"] == "notificacoes") { include_once("Relatorios/notificacoes.php"); }

            else { include_once("Home/home.php"); }
        ?>
    </main>

    <!-- Modal Logout-->
    <div class="modal fade" id="ModalLogout" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-block">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close">
                        <img src="../../assets/icons/close.svg">
                    </button>
                    <div class="modal-body">
                        <h5>Já vai embora?</h5>
                        <h6>Tem certeza que gostaria de sair da sa conta?</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="CancelaBtnModal" type="button" data-dismiss="modal">Cancelar</button>
                        <a class="ExcluirBtnModal" href="../configs/logout.php" type="button">Sair</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar perfil-->
    <div class="modal fade" id="ModalEditPerfil" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-block">
            <div class="modal-dialog">
                <div class="modal-content">

                    <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close">
                        <img src="../../assets/icons/close.svg">
                    </button>

                    <div class="modal-body">
                        <div id="MenuAdm" class="nav nav-pills MenuAdm">
                            <a class="active" data-toggle="pill" href="#ContaDados">Dados da conta</a>
                            <a data-toggle="pill" href="#EmailTroca">Troca de email</a>
                            <a data-toggle="pill" href="#SenhaTroca">Troca de senha</a>
                        </div>
                        <div id="TabsAdm" class="tab-content TabsAdm">
                            <div class="tab-pane fade show active" id="ContaDados">
                                <form id="formEditUser" class="editDados" method="POST">
                                    <h4>Alterar informações de conta:</h4>
                                    <div class="BlockBox">
                                        <input type="text" name="nomeCompEdit" id="nomeCompEdit" maxlength="75" value="<?php echo $nomeAdm ?>">
                                        <span>Nome completo:</span>
                                        <p class="lengthInput NomeCompEditInput"></p>
                                    </div>
                                    <div class="BlockBox">
                                        <input type="text" name="telefoneContatoEdit" id="telefoneContatoEdit" value="<?php echo $telefoneAdm ?>">
                                        <span>Telefone de contato:</span>
                                    </div>
                                    <input value="<?php echo @$_SESSION['id_user'] ?>" class="hide" type="hidden" name="idUser" id="idUser">
                                    <button class="SalvarBtnModal" type="submit">Salvar</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="EmailTroca">
                                <form id="formEditEmailUser" class="emailEdit" method="POST">
                                    <h4>Alterar Email:</h4>
                                    <div class="BlockBox">
                                        <input type="text" name="antigoEmail" id="antigoEmail" maxlength="50" required>
                                        <span>E-mail Antigo:</span>
                                        <p class="lengthInput emailAntigoEditInput"></p>
                                    </div>
                                    <div class="BlockBox">
                                        <input type="text" name="novoEmail" id="novoEmail" maxlength="50" required>
                                        <span>Novo e-mail:</span>
                                        <p class="lengthInput novoEmailEditInput"></p>
                                    </div>
                                    <div class="BlockBox">
                                        <input type="text" name="confirmaNovoEmail" id="confirmaNovoEmail" maxlength="50" required>
                                        <span>Confirma novo e-mail:</span>
                                        <p class="lengthInput ConfirmaNovoEmailEditInput"></p>
                                    </div>
            
                                    <input value="<?php echo @$_SESSION['id_user'] ?>" class="hide" type="hidden" name="idUserEmail" id="idUserEmail">
                                    <input value="<?php echo @$_SESSION['email_user'] ?>" class="hide" type="hidden" name="emailUserSemAlteracoes" id="emailUserSemAlteracoes">
                                    <button class="SalvarBtnModal" type="submit">Salvar</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="SenhaTroca">
                                <form id="formEditSenhaUser" class="senhaEdit" method="POST">
                                    <h4>Alterar Senha:</h4>
                                    <div class="BlockBox senhaInput">
                                        <input type="password" name="antigaSenha" id="antigaSenha" maxlength="25" required>
                                        <span>Senha antiga:</span>
                                        <i id="password_toggle" onclick="setupPasswordToggle('antigaSenha', 'password_toggle')" class="senhaIcon fa-regular fa-eye-slash"></i>
                                        <p class="lengthInput SenhaAntigaEditInput"></p>
                                    </div>
                                    <div class="BlockBox senhaInput">
                                        <input type="password" name="novaSenha" id="novaSenha" maxlength="25" required>
                                        <span>Nova senha:</span>
                                        <i id="password_toggle_new" onclick="setupPasswordToggle('novaSenha', 'password_toggle_new')" class="senhaIcon fa-regular fa-eye-slash"></i>
                                        <p class="lengthInput NovaSenhaEditInput"></p>
                                    </div>
                                    <div class="BlockBox senhaInput">
                                        <input type="password" name="confirmaNovaSenha" id="confirmaNovaSenha" maxlength="25" required>
                                        <span>Confirma nova senha:</span>
                                        <i id="password_toggle_confirm" onclick="setupPasswordToggle('confirmaNovaSenha', 'password_toggle_confirm')" class="senhaIcon fa-regular fa-eye-slash"></i>
                                        <p class="lengthInput ConfirmaNovaSenhaEditInput"></p>
                                    </div>
                                    <input value="<?php echo @$_SESSION['id_user'] ?>" class="hide" type="hidden" name="idUserSenha" id="idUserSenha">
                                    <input value="<?php echo $senhaAdm ?>" class="hide" type="hidden" name="senhaUserSemAlteracoes" id="senhaUserSemAlteracoes">
                                    <button class="SalvarBtnModal" type="submit">Salvar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="msgErro" id="msgErro_EditUser"></div>
                </div>
            </div>
        </div>
    </div>

    <form id="form_Notificacao" class="hide" method="POST"></form>

    <script>
        $('#form_Notificacao').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: "Main_menus/notificacao.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(msg){ }
            })
        });

        function status(event) {
            if(event.classList.contains("ativa")){
                //remove status visual
                event.classList.remove("ativa");
                let number = Number($('.notif_num').text());
                number--;

                if(number !== 0){
                    $('.notif_num').text(number);
                } else{ $('.notif_num').remove(); }

                //remove status Banco de dados
                let id = event.children[0].innerHTML;
                $('#form_Notificacao').append(`
                    <input type="hidden" id="id_item_notf" name="id_item_notf" value="${id}">
                `);

                $('.Notificacoes').on('hide.bs.dropdown', function (e) { if (e.clickEvent) { e.preventDefault(); } });
                $('#form_Notificacao').click();
            }
        }
    </script>
</body>
</html>