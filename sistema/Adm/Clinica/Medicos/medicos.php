<section id="Medicos">
    <a class="btns btn_cria" href="index.php?pag=medicos&funcao=novoMedico">
        <p>Novo Medico(a)</p>
    </a>

    <div id="List_Medicos">
        <?php
            $query = $pdo->query("SELECT * FROM medicos WHERE nivel != 'adm' ORDER BY id DESC");
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);

            for ($i=0; $i < count($dados); $i++) {
                $id_medico = $dados[$i]['id'];
                $nome_medico = $dados[$i]['nome'];
                $email_medico = $dados[$i]['email'];
                $imagem = $dados[$i]['foto'];
                $status = $dados[$i]['status_perfil'];

                if($imagem == "placeholder.webp" || $imagem == ""){
                    $imagem = "<img class='imgMedico' src='../../../Clinica/assets/users/user_placeholder.webp'>";
                }else{
                    $imagem = "<img class='imgMedico' src='../../../Clinica/assets/users/$imagem'>";
                }
                if($nome_medico == ""){
                    $nome_medico = "Usuario sem <br> informações cadastradas";
                }
                if($status != "inativo"){
                    $ação = "<a href='index.php?pag=medicos&funcao=editMedico&id=".$id_medico."'><img src='../../../assets/sistema/edit.svg'></a>";
                }
                else{
                    $ação = "";
                }

                echo "
                    <div class='espec_card'>
                        $imagem
                        <h4 class='nome'>$nome_medico</h4>
                        <p class='email'>$email_medico</p>

                        <div class='acoes'>
                            $ação
                            <a href='index.php?pag=medicos&funcao=deletMedico&id=".$id_medico."'><img src='../../../assets/sistema/delet.svg'></a>
                        </div>
                    </div>
                ";
            }
        ?>
    </div>

    <!-- Modal Cria medico -->
    <div class="modal fade" id="ModalCriaMedico" tabindex="-1">
        <div class="modal-dialog">
            <form id="Form_ModalCriaMedico" method="post" class="modal-content">
                <button type="button" class="CloseBtn" data-bs-dismiss="modal" aria-label="Close" onclick='window.location=`./index.php?pag=medicos`;'></button>
                <div class="modal-body">
                    <h4>Novo Medico(a)!</h4>
                    <div class="BlockBox">
                        <input type="text" name="email_Medico" id="email_Medico" maxlength="50" required>
                        <span>Email:</span>
                    </div>
                    <div class="BlockBox">
                        <input type="text" name="senha_Temp" id="senha_Temp" maxlength="100" required>
                        <span>Senha temporaria:</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btns btn_cancel" type="button" data-bs-dismiss="modal" onclick='window.location=`./index.php?pag=medicos`;'>Cancelar</button>
                    <button class="btns btn_salvar" type="submit">Salvar perfil</button>
                </div>
            </form>
        </div>
        <div id="msg_ModalCriaMedico"></div>
    </div>
    
    <!-- Modal Delete medico-->
    <div class="modal fade" id="ModalDeletMedico" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="Form_ModalDeletMedico" method="post" class="modal-content">
                <button type="button" class="CloseBtn" data-bs-dismiss="modal" aria-label="Close" onclick='window.location=`./index.php?pag=medicos`;'></button>
                <div class="modal-body">
                    <h4>Gostaria mesmo de excluir este medico(a)?</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_medico_delete" name="id_medico_delete" value="<?php echo @$_GET['id'] ?>" required>

                    <button class="btns btn_cancel" type="button" data-bs-dismiss="modal" onclick='window.location=`./index.php?pag=medicos`;'>Cancelar</button>
                    <button class="btns btn_excluir" type="submit">Excluir</button>
                </div>
            </form>
            <div id="msg_ModalDeletMedico"></div>
        </div>
    </div>

    <!-- ADICIONAR BTN DE DESATIVAR MEDICO E BTN DE RECUPERAR SENHA DENTRO DESSA MODAL -->

    <!-- FUNÇÕES PHP NA CHAMADA DE MODAL -->
    <?php
        if (@$_GET["funcao"] == "novoMedico") {
            echo "
                <button id='openModalCriaMedico' class='hide' type='button' data-bs-toggle='modal' data-bs-target='#ModalCriaMedico'></button>
                <script language='javascript'>$('#openModalCriaMedico').click();</script>
            ";
        }
        if (@$_GET["funcao"] == "deletMedico") {
            echo "
                <button id='openModalDeletMedico' class='hide' type='button' data-bs-toggle='modal' data-bs-target='#ModalDeletMedico'></button>
                <script language='javascript'>$('#openModalDeletMedico').click();</script>
            ";
        }
    ?>

    <script>
        // //CHAMADA DE FUNÇÃO PARA UPLOAD DE IMG BANCO DE DADOS
        // function carregarImgWeb(){ carregarImagem('icon_espec_Input', 'target_imgEspec', "../../assets/icons/Placeholder.svg", 'img_espec_modal'); }


        //UPLOAD DAS INFOS NO BANCO DE DADOS
        $("#Form_ModalCriaMedico").submit(function (e) {
            e.preventDefault();
            $('#msg_ModalCriaMedico').text('');
            $('#msg_ModalCriaMedico').removeClass('text-danger');
            $('#msg_ModalCriaMedico').removeClass('text-warning');
            $('#msg_ModalCriaMedico').removeClass('text-success');
            $.ajax({
                url: "Medicos/insert.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (msg) {
                    if (msg.trim() === "Perfil de medico(a) criado com Sucesso!!") {
                        $('#msg_ModalCriaMedico').addClass('text-success');
                        $('#msg_ModalCriaMedico').text(msg);
                        setTimeout(() => { window.location='./index.php?pag=medicos'; }, 1500);
                    }
                    if (msg.trim() === "E-mail ja cadastrado no banco de dados!!") {
                        $('#msg_ModalCriaMedico').addClass('text-danger');
                        $('#msg_ModalCriaMedico').text(msg);
                    }
                    else {
                        $('#msg_ModalCriaMedico').addClass('text-warning');
                        $('#msg_ModalCriaMedico').text('O perfil foi criado!! Mas o e-mail com link de acesso para o novo medico não pode ser enviado por falhas com a comunicação do servidor.');
                        setTimeout(() => { window.location='./index.php?pag=medicos'; }, 3000);
                    }
                }
            });
        });

        $('#Form_ModalDeletMedico').submit(function (e) {
            e.preventDefault();
            $('#msg_ModalDeletMedico').text('');
            $('#msg_ModalDeletMedico').removeClass('text-danger');
            $('#msg_ModalDeletMedico').removeClass('text-success');
            $.ajax({
                url: "Medicos/delete.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (msg) {
                    if (msg.trim() === "Excluído com Sucesso!!") {
                        $('#msg_ModalDeletMedico').addClass('text-success');
                        $('#msg_ModalDeletMedico').text(msg);
                        setTimeout(() => { window.location='./index.php?pag=medicos'; }, 1500);
                    }
                    else{
                        $('#msg_ModalDeletMedico').addClass('text-danger');
                        $('#msg_ModalDeletMedico').text(msg)
                    }
                }
            })
        });

    </script>
</section>