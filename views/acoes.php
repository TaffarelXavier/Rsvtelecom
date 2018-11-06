<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../autoload.php';

    /* if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') { */

    $Clientes = new Clientes($connection);
    ?>
    <hr style="margin-top:10px;margin-bottom:10px;border:0;border-top:1px solid #ccc;" />
    <div class="row-fluid">
        <?php
        $acao = val_input::sani_string('acao');

        switch ($acao) {
            case 'cadastrar-usuario':
                ?>
                <style>
                    .chip{display:inline-block;padding:0 25px;height:50px;font-size:18px;line-height:50px;border-radius:25px!important;background-color:#f1f1f1;width:18%!important;margin-bottom:5px}.chip img{float:left;margin:0 10px 0 -25px;height:50px;width:50px;border-radius:50%!important}.closebtn{padding-left:10px;color:#888;font-weight:700;float:right;font-size:20px;cursor:pointer}.closebtn:hover{color:#000}.editar-conta{text-decoration:none!important}
                </style>
                <div class="tabbable tabbable-custom">
                    <ul class="nav nav-tabs">
                        <?php
                        if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                            ?>
                            <li class="active abas" data-aba="1"><a href="#tabuser_1_1" data-toggle="tab"><strong>Adicionar Novo Usuário</strong></a></li>
                            <li class="abas" data-aba="2"><a href="#tabuser_1_2" data-toggle="tab"><strong>Todos Usuários</strong></a></li>
                            <li class="abas" data-aba="3"><a href="#tabuser_1_3" data-toggle="tab"><strong>Configurações</strong></a></li>
                            <li class="abas" data-aba="4"><a href="#tabuser_1_4" data-toggle="tab"><strong>Log de Boletos</strong></a></li>
                            <?php
                        } else {
                            ?>
                            <li class="active abas" data-aba="2"><a href="#tabuser_1_2" data-toggle="tab"><strong>Conta</strong></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                    <div class="tab-content">
                        <?php
                        if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                            ?>
                            <div class="tab-pane active" id="tabuser_1_1">
                                <div class="row-fluid" id="cadastrar-usuario">
                                    <div class="span4"></div>
                                    <div class="span4">
                                        <form enctype="multipart/form-data" action="../usuarios/models/adicionar_usuario.php"
                                              method="POST" id="form-criar-novo-usuario">
                                            <h3 style="border-bottom: 3px solid #f1f1f1;">Adicionar Novo Usuário</h3>
                                            <label><strong>Nome:</strong></label>
                                            <input class="span12" type="text" name="nome" autofocus="" required="" autocomplete="off" />
                                            <label><strong>Senha:</strong></label>
                                            <input class="span12" type="password" name="senha" required="" autocomplete="off" />
                                            <label><strong>Nível:</strong></label>
                                            <select name="nivel" class="span12" required="" style="border-radius: 0px;height: 40px;"  >
                                                <option value="">Selecione...</option>
                                                <option value="administrador">Administrador</option>
                                                <option value="padrao">Padrão</option>
                                            </select>
                                            <button class="button-sys" id="btnCriarNovoUsuario" >Salvar <i class="fa fa-send-o" aria-hidden="true" /></i></button>
                                            <a class="red" href="./" >Cancelar</a>
                                            <div id="resultado"></div>
                                        </form>
                                    </div>
                                    <div class="span4"></div>
                                </div>
                            </div>
                            <?php
                        }
                        if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                            ?>
                            <div class="tab-pane" id="tabuser_1_2">
                                <h3 style="margin:0;">Contas de Usuários</h3>
                                <?php
                            } else {
                                ?>
                                <div class="tab-pane active" id="tabuser_1_2">
                                    <h3 style="margin:0;">Sua Conta</h3>
                                    <?php
                                }
                                ?>
                                <hr style="margin-top:0px;margin-bottom:10px;border:0;border-top:1px solid #ccc;" />
                                <?php
                                $Conta = new Contas($connection);

                                $fcnt = $Conta->get_todas_contas();

                                $tipo_conta = $_SESSION['tx_dados_usuario']['conta_nivel'];

                                while ($row = $fcnt->fetch(PDO::FETCH_ASSOC)) {
                                    if ($tipo_conta == 'administrador') {
                                        ?>
                                        <a href="#myModal3" role="button" data-toggle="modal" 
                                           id="conta_<?php echo $row['conta_id']; ?>" title="Clique para Alterar"
                                           data-id="<?php echo $row['conta_id']; ?>"
                                           data-conta-nome="<?php echo $row['conta_usuario']; ?>"
                                           data-conta-tipo="<?php echo $row['conta_nivel']; ?>"
                                           class="editar-conta">
                                            <div class="chip">
                                                <img src="../_arquivos/imagens-perfil/img_avatar_homem.png" alt="Person" width="96" height="96">
                                                <?php echo $row['conta_usuario']; ?>
                                            </div>
                                        </a>
                                        <?php
                                    } else {
                                        /* Se o usuário não for administrador, mas poderá alterar seus dados. */
                                        if ($_SESSION['tx_dados_usuario']['conta_id'] == $row['conta_id']) {
                                            ?>
                                            <a href="#myModal3" role="button" data-toggle="modal" 
                                               id="conta_<?php echo $row['conta_id']; ?>" title="Clique para Alterar"
                                               data-id="<?php echo $row['conta_id']; ?>"
                                               data-conta-nome="<?php echo $row['conta_usuario']; ?>"
                                               data-conta-tipo="<?php echo $row['conta_nivel']; ?>"
                                               class="editar-conta">
                                                <div class="chip">
                                                    <img src="../_arquivos/imagens-perfil/img_avatar_homem.png" alt="Person" width="96" height="96">
                                                    <?php echo $row['conta_usuario']; ?>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    }
                                }
                                if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                    ?>
                                </div>
                                <?php
                            }
                            if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                ?>
                                <div class="tab-pane" id="tabuser_1_3">
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <form enctype="multipart/form-data" action="../models/alterar_telefone.php" 
                                                  method="POST" id="formAlterarConfiguracoes">
                                                <label><strong>Número de Telefone:</strong></label>
                                                <?php
                                                $Configuracoes = new Configuracoes($connection);
                                                $config = $Configuracoes->get_config(1);
                                                ?>
                                                <input type="text" name="config_fone" class="span6" id="config_fone" value="<?php echo $config['telefone']; ?>"  />
                                                <input type="hidden" name="config_id" value="<?php echo $config['config_id']; ?>"  />
                                                <button class="button-sys" id="btnSalvarTelefone" disabled="">Salvar <i class="fa fa-send-o" aria-hidden="true"></i></button>
                                            </form> 
                                        </div>
                                        <div class="span4">
                                            <?php $array = array('ABeeZee', 'Abel', 'Abhaya Libre', 'Abril Fatface', 'Aclonica', 'Acme', 'Actor', 'Adamina', 'Advent Pro', 'Aguafina Script', 'Akronim', 'Aladin', 'Aldrich', 'Alef', 'Alegreya', 'Alegreya SC', 'Alegreya Sans', 'Alegreya Sans SC', 'Alex Brush', 'Alfa Slab One', 'Alice', 'Alike', 'Alike Angular', 'Allan', 'Allerta', 'Allerta Stencil', 'Allura', 'Almendra', 'Almendra Display', 'Almendra SC', 'Amarante', 'Amaranth', 'Amatic SC', 'Amatica SC', 'Amethysta', 'Amiko', 'Amiri', 'Amita', 'Anaheim', 'Andada', 'Andika', 'Angkor', 'Annie Use Your Telescope', 'Anonymous Pro', 'Antic', 'Antic Didone', 'Antic Slab', 'Anton', 'Arapey', 'Arbutus', 'Arbutus Slab', 'Architects Daughter', 'Archivo Black', 'Archivo Narrow', 'Aref Ruqaa', 'Arima Madurai', 'Arimo', 'Arizonia', 'Armata', 'Arsenal', 'Artifika', 'Arvo', 'Arya', 'Asap', 'Asar', 'Asset', 'Assistant', 'Astloch', 'Asul', 'Athiti', 'Atma', 'Atomic Age', 'Aubrey', 'Audiowide', 'Autour One', 'Average', 'Average Sans', 'Averia Gruesa Libre', 'Averia Libre', 'Averia Sans Libre', 'Averia Serif Libre', 'Bad Script', 'Bahiana', 'Baloo', 'Baloo Bhai', 'Baloo Bhaina', 'Baloo Chettan', 'Baloo Da', 'Baloo Paaji', 'Baloo Tamma', 'Baloo Thambi', 'Balthazar', 'Bangers', 'Barrio', 'Basic', 'Battambang', 'Baumans', 'Bayon', 'Belgrano', 'Belleza', 'BenchNine', 'Bentham', 'Berkshire Swash', 'Bevan', 'Bigelow Rules', 'Bigshot One', 'Bilbo', 'Bilbo Swash Caps', 'BioRhyme', 'BioRhyme Expanded', 'Biryani', 'Bitter', 'Black Ops One', 'Bokor', 'Bonbon', 'Boogaloo', 'Bowlby One', 'Bowlby One SC', 'Brawler', 'Bree Serif', 'Bubblegum Sans', 'Bubbler One', 'Buda', 'Buenard', 'Bungee', 'Bungee Hairline', 'Bungee Inline', 'Bungee Outline', 'Bungee Shade', 'Butcherman', 'Butterfly Kids', 'Cabin', 'Cabin Condensed', 'Cabin Sketch', 'Caesar Dressing', 'Cagliostro', 'Cairo', 'Calligraffitti', 'Cambay', 'Cambo', 'Candal', 'Cantarell', 'Cantata One', 'Cantora One', 'Capriola', 'Cardo', 'Carme', 'Carrois Gothic', 'Carrois Gothic SC', 'Carter One', 'Catamaran', 'Caudex', 'Caveat', 'Caveat Brush', 'Cedarville Cursive', 'Ceviche One', 'Changa', 'Changa One', 'Chango', 'Chathura', 'Chau Philomene One', 'Chela One', 'Chelsea Market', 'Chenla', 'Cherry Cream Soda', 'Cherry Swash', 'Chewy', 'Chicle', 'Chivo', 'Chonburi', 'Cinzel', 'Cinzel Decorative', 'Clicker Script', 'Coda', 'Coda Caption', 'Codystar', 'Coiny', 'Combo', 'Comfortaa', 'Coming Soon', 'Concert One', 'Condiment', 'Content', 'Contrail One', 'Convergence', 'Cookie', 'Copse', 'Corben', 'Cormorant', 'Cormorant Garamond', 'Cormorant Infant', 'Cormorant SC', 'Cormorant Unicase', 'Cormorant Upright', 'Courgette', 'Cousine', 'Coustard', 'Covered By Your Grace', 'Crafty Girls', 'Creepster', 'Crete Round', 'Crimson Text', 'Croissant One', 'Crushed', 'Cuprum', 'Cutive', 'Cutive Mono', 'Damion', 'Dancing Script', 'Dangrek', 'David Libre', 'Dawning of a New Day', 'Days One'); ?>
                                            <label><strong>Fontes do Google</strong></label>
                                            <a href="https://www.w3schools.com/howto/howto_google_fonts.asp" title="" class="">Google Fontes</a>
                                            <select id="selectFontGoogle" >
                                                <option value="">Selecione a fonte...</option>
                                                <?php
                                                foreach ($array as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                </div>
                                <!---->
                                <div class="tab-pane" id="tabuser_1_4">
                                    <div class="row-fluid">
                                        <div class="alert alert-info">
                                            Boletos que foram pagos.
                                        </div>
                                    </div>
                                    <div class="row-fluid" style="max-height: 400px;overflow: auto;position: relative;">
                                        <table class="table">
                                            <tr>
                                                <th>Boleto Id:</th>
                                                <th>Usuário:</th>
                                                <th>Data de Pagamento:</th>
                                                <th>#</th>
                                            </tr>
                                            <?php
                                            $Boletos = new Boletos($connection);
                                            $brf = $Boletos->get_logs_boletos();
                                            $i54= 0;
                                            while ($row = $brf->fetch(PDO::FETCH_ASSOC)) {
                                                $i54++;
                                                ?>
                                                <tr>
                                                    <td><?php echo '[',$i54 ,']', $row['log_boleto_id']; ?></td>
                                                    <td><?php echo $row['conta_usuario']; ?></td>
                                                    <td><?php echo date('d/m/Y \à\s H:i', $row['log_data']); ?></td>
                                                    <td><label class="text-success"><strong><?php echo 'PAGO'; ?></strong></label></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                        <p>Total: <b><?php echo ($i54 * 70) ?></b></p>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        var confiId = 1;
                                        /*Muda o tamanho da fonte*/
                                        $('#selectFontGoogle').change(function () {
                                            var _fontFamily = this.value;
                                            $.post('models/m_acoes.php', {
                                                fontfamily: _fontFamily,
                                                fontzize: '18',
                                                config_id: confiId
                                            }, function (data) {
                                                if (data == '1') {
                                                    window.location.reload();
                                                }
                                            });
                                        });

                                        [$.cookie('__FontGoogle')].forEach(function (item) {
                                            $('#selectFontGoogle option[value="' + item + '"]').attr({selected: true});
                                        });

                                        $('#config_fone').keyup(function () {
                                            $('#btnSalvarTelefone').attr('disabled', false);
                                        });

                                        $('#formAlterarConfiguracoes').ajaxForm({
                                            beforeSend: function () {
                                                $('#btnSalvarTelefone').attr('disabled', true).html('<i class="fa fa-save"></i> Salvando aguarde, por favor.');
                                            },
                                            uploadProgress: function (event, position, total, percentComplete) {
                                                var percentVal = percentComplete + '%';
                                            },
                                            success: function (data) {
                                                alert(data);
                                                if (data == '1') {
                                                    mostrasSnackbar('Alterações Salvas com sucesso!');
                                                    $('#btnSalvarTelefone').attr('disabled', false).html('<i class="fa fa-save"></i> Salvar');
                                                } else if (data == '0') {
                                                    mostrasSnackbar('Nenhum dado foi salvo!');
                                                    $('#btnSalvarTelefone').attr('disabled', false).html('<i class="fa fa-save"></i> Salvar');
                                                } else {
                                                    mostrasSnackbar('As alterações não poderam ser salvas. Tente novamente.');
                                                }
                                            }
                                        });
                                    });
                                </script>
                                <?php
                            }
                            ?>
                            <!--MODAL ALTERAR DADOS-->
                            <div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <?php
                                    if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                        ?>
                                        <h3 id="myModalLabel3">Alterar Conta de Usuário</h3>
                                        <?php
                                    } else {
                                        ?>
                                        <h3 id="myModalLabel3">Alterar Senha</h3>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="modal-body">
                                    <form enctype="multipart/form-data" action="../usuarios/models/alterar_conta.php"
                                          method="POST" id="formAlterarDadosConta" autocomplete="off">
                                              <?php
                                              if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                                  ?>
                                            <div class="row-fluid text-center">
                                                <div class="span2">
                                                    <i class="fa fa-4x fa-id-card-o" aria-hidden="true" /></i>
                                                </div>
                                                <div class="span8">
                                                    <input id="radio_alt_1" style="height: 20px;width: 20px;float:left;" type="radio" name="tipo_altr" value="1" required="" />
                                                    <label for="radio_alt_1" style="position: relative;top:3px;float:left;"><strong>Somente Dados Básicos</strong></label>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <label><strong>Nome:</strong></label>
                                                <input class="span12" type="text" name="nome" id="getNomeConta" />
                                                <input type="hidden" name="conta_nome" id="conta_nome"  />
                                            </div>
                                            <div class="row-fluid">
                                                <label><strong>Nível</strong></label>
                                                <select name="tipo_de_conta" class="span12" style="height: 42px;" id="selectTipoConta">
                                                    <option value="">Selecione...</option>
                                                    <option value="administrador">Administrador</option>
                                                    <option value="padrao">Padrão</option>
                                                </select>
                                                <input type="hidden" name="usuario_id" id="get_conta_id"  />
                                                <hr style="margin-top:5px;margin-bottom:5px;border:0;border-top:3px dashed #ccc;" />
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="hidden" name="usuario_id" id="get_conta_id"  />
                                            <?php
                                        }
                                        ?>
                                        <div class="row-fluid">
                                            <div class="row-fluid text-center">
                                                <div class="span2">
                                                    <i class="fa fa-4x fa-lock" aria-hidden="true" /></i>
                                                </div>
                                                <div class="span10">
                                                    <?php
                                                    if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                                        ?>
                                                        <input id="radio_alt_2" style="height: 20px;width: 20px;float:left;" type="radio" name="tipo_altr" value="2" required="" />
                                                        <label for="radio_alt_2" style="position: relative;top:3px;float:left;"><strong>Alterar Senha</strong></label>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <input id="radio_alt_1" style="height: 20px;width: 20px;float:left;" type="radio" name="tipo_altr" value="2" required="" />
                                                        <label for="radio_alt_1" style="position: relative;top:3px;float:left;"><strong>Alterar Senha</strong></label>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <label><strong>Escolha uma senha:</strong></label>
                                                    <input type="password" name="senha1" autocomplete="off"/>  
                                                </div>
                                                <div class="span6">
                                                    <label><strong>Confirme a nova senha:</strong></label>
                                                    <input type="password" name="senha2" autocomplete="off"/>  
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn blue" data-dismiss="modal" aria-hidden="true">Fechar</button>
                                    <?php
                                    if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                        ?>
                                        <button class="btn red excluir-usuario" ><i class="fa fa-trash"></i> Excluir</button>
                                        <?php
                                    }
                                    ?>
                                    <button class="btn green" form="formAlterarDadosConta" type="submit"
                                            id="btnAlterarDadosUsuarios"><i class="fa fa-save"></i> Salvar Alterações</button>
                                </div>
                            </div><!--FIM DO MODAL-->
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {

                            $('.excluir-usuario').click(function () {
                                if (confirm("Tem certeza de que deseja excluir permanentemente esta conta?")) {
                                    $.post('usuarios/models/excluir_permanentemente.php', {
                                        usuario_id: $('#get_conta_id').val()
                                    }, function (data) {
                                        if (data == '1') {
                                            alert('Conta excluída com sucesso!');
                                            window.location.reload();
                                        }
                                    });
                                }
                            });

                            $('.editar-conta').click(function () {
                                var _id = $(this).attr('data-id');

                                var _conta_nome = $(this).attr('data-conta-nome');

                                var _tipo = $(this).attr('data-conta-tipo');

                                $('#getNomeConta').val(_conta_nome);

                                $('#conta_nome').val(_conta_nome);

                                [_tipo].forEach(function (item) {
                                    $('#selectTipoConta option[value="' + item + '"]').attr({selected: true});
                                });

                                $('#get_conta_id').val(_id);
                            });

                            /**
                             * Alterar Dados
                             */

                            $('#formAlterarDadosConta').ajaxForm({
                                beforeSend: function () {
                                },
                                uploadProgress: function (event, position, total, percentComplete) {
                                    var percentVal = percentComplete + '%';
                                    $('#btnAlterarDadosUsuarios').html(percentVal + ' <i class="fa fa-save"></i>  Alterando, aguarde...').attr('disabled', true);
                                },
                                success: function (data) {
                                    if (document.getElementById("radio_alt_1").checked == true) {
                                        if (data == '1') {
                                            $('#btnAlterarDadosUsuarios').html('<i class="fa fa-save"></i> Salvar Alterações').attr('disabled', false);
                                            alert("Dados alterados com sucesso!");
                                        } else if (data == '0') {
                                            $('#btnAlterarDadosUsuarios').html('<i class="fa fa-save"></i> Salvar Alterações').attr('disabled', false);
                                            alert("Não foi possível fazer a alteração, tente novamente.");
                                        } else {
                                            $('#btnAlterarDadosUsuarios').html('<i class="fa fa-save"></i> Salvar Alterações').attr('disabled', false);
                                            alert(data);
                                        }
                                    } else {
                                        if (data == '1') {
                                            $('#btnAlterarDadosUsuarios').html('<i class="fa fa-save"></i> Salvar Alterações').attr('disabled', false);
                                            alert("Senha alterada com sucesso!");
                                        } else if (data == '0') {
                                            $('#btnAlterarDadosUsuarios').html('<i class="fa fa-save"></i> Salvar Alterações').attr('disabled', false);
                                            alert("Não foi possível fazer a alteração, tente novamente.");
                                        } else {
                                            $('#btnAlterarDadosUsuarios').html('<i class="fa fa-save"></i> Salvar Alterações').attr('disabled', false);
                                            alert(data);
                                        }
                                    }

                                }
                            });

                            $('#form-criar-novo-usuario').ajaxForm({
                                beforeSend: function () {
                                    /*status.empty();
                                     var percentVal = '0%';
                                     bar.width(percentVal)
                                     percent.html(percentVal);*/
                                },
                                uploadProgress: function (event, position, total, percentComplete) {
                                    var percentVal = percentComplete + '%';
                                    $('#btnCriarNovoUsuario').html(percentVal + ' Salvando, aguarde...');
                                    /*bar.width(percentVal)
                                     percent.html(percentVal);*/
                                },
                                success: function (data) {

                                    if (data == '1') {
                                        mostrasSnackbar('Novo usuário adicionado com sucesso!');
                                    } else if (data == 'CONTA_EXISTE') {
                                        mostrasSnackbar('A conta já existe.');
                                    } else if (data == 'USUAIO_INCORRETO') {
                                        mostrasSnackbar('O nome do usuário está incorreto.');
                                    } else {
                                        mostrasSnackbar('Não foi possível fazer a inclusão.\nAtualizae a página e tente novamente');
                                    }

                                    $('#btnCriarNovoUsuario').html('Salvar');
                                }
                            });
                        });
                    </script>
                    <?php
                    break;
                case 'cadastrar-cliente':
                    ?>
                    <div class="tabbable tabbable-custom">
                        <ul class="nav nav-tabs">
                            <?php
                            if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                ?>
                                <li class="active tabcliente" id="tabcliente_1" data-tab="1"><a href="#tab_1_1" data-toggle="tab"><strong>Adicionar Novo</strong></a></li>
                                <?php
                            } else {
                                ?>
                                <li class="active tabcliente" id="tabcliente_1"  data-tab="1"><a href="#tab_1_1" data-toggle="tab"><strong>Adicionar Novo</strong></a></li>
                                <?php
                            }
                            ?>
                            <li class=" tabcliente" id="tabcliente_2"  data-tab="2"><a href="#tab_1_2" data-toggle="tab"><strong>Todos o Clientes</strong></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1_1">
                                <div class="row-fluid" id="cadastrar-cliente">
                                    <div class="span4"></div>
                                    <div class="span4">
                                        <form enctype="multipart/form-data" action="../clientes/models/criar_novo_cliente.php"
                                              method="POST" id="form-criar-novo-usuario">
                                            <h3 style="border-bottom: 3px solid #f1f1f1;">Adicionar Novo Cliente</h3>
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <label for="inputRadio1" style="display: inline;top: 4px;position: relative;">&nbsp;<strong>CPF</strong></label>  
                                                    <input id="inputRadio1" value="cpf" type="radio" name="tipo_cliente" 
                                                           style="float: left;width: 20px;height:20px;" required="" class="cls_tipo_cliente" />
                                                </div>
                                                <div class="span6">
                                                    <label for="inputRadio2" style="display: inline;position: relative;top: 4px;">&nbsp;<strong>CNPJ</strong></label>
                                                    <input id="inputRadio2" class="cls_tipo_cliente"  value="cnpj" type="radio" 
                                                           name="tipo_cliente" style="float: left;width: 20px;height:20px;" id="inputRadio1"  required="" />
                                                </div>
                                            </div>
                                            <label><strong>Nome:</strong></label>
                                            <input class="span12" type="text" name="nome" autofocus="" required="" autocomplete="off" />
                                            <label><strong>CPF:</strong></label>
                                            <input class="span12" type="text" name="cpf" required="" id="cpfId" autocomplete="off" />
                                            <button class="button-sys" id="btnCriarNovoUsuario" >Salvar <i class="fa fa-send-o" aria-hidden="true" /></i></button>
                                            <a class="red" href="./" >Cancelar</a>
                                            <div id="resultado"></div>
                                        </form>
                                    </div>
                                    <div class="span4"></div>
                                </div>
                            </div>
                            <!-- The Modal -->
                            <div id="modalEditarCliente" class="telecom-modal">
                                <!-- Modal content -->
                                <div class="modal-content">
                                    <div class="tel-modal-header">
                                        <span class="tel-close">&times;</span>
                                        <h2 style="padding:0px !important;">Editar Cliente...</h2>
                                    </div>
                                    <div class="modal-body">
                                        <form enctype="multipart/form-data" action="clientes/models/acoes.php"
                                              method="POST" style="" id="formAlterarCliente">
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <label for="inputRadio11" style="display: inline;top: 4px;position: relative;">&nbsp;<strong>CPF</strong></label>  
                                                    <input id="inputRadio11" class="cls_tipo_cliente" value="cpf" type="radio" name="tipo_cliente" style="float: left;width: 20px;height:20px;" required="">
                                                </div>
                                                <div class="span6">
                                                    <label for="inputRadio22" style="display: inline;position: relative;top: 4px;">&nbsp;<strong>CNPJ</strong></label>
                                                    <input id="inputRadio22" class="cls_tipo_cliente" value="cnpj" type="radio" name="tipo_cliente" style="float: left;width: 20px;height:20px;" required="">
                                                </div>
                                            </div>
                                            <label><strong>Nome:</strong></label>
                                            <input type="text" name="nome" id="cli_nome" class="span12" />
                                            <label><strong id="getCpf">CPF:</strong></label>
                                            <input type="text" name="cpf" id="cli_cpf" />
                                            <input type="hidden" name="cliente_id" id="cli_id" />
                                            <input type="hidden" name="acao" value="update" />
                                        </form>
                                    </div>
                                    <div class="tel-modal-footer">
                                        <div class="row-fluid text-center">
                                            <button class="button-sys cancelar-modal" 
                                                    style="background: #d84a38;font-size:18px;"><i class="fa fa-window-close"></i> Cancelar</button>
                                            <button class="button-sys" form="formAlterarCliente" id="btnAlterarCliente"
                                                    type="submit" style="background: #0362fd;font-size:18px;"><i class="fa fa-save"></i> Confirmar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_1_2">
                                <?php
                                $tds = $Clientes->get_todos_clientes();
                                ?>
                                <div class="row-fluid">
                                    <div class="alert">
                                        Relação de todos os <strong>Clientes</strong> cadastrados.
                                    </div>
                                </div>
                                <div class="row-fluid" style="border-bottom:1px solid #ccc;box-shadow: 0px 10px 15px 0px rgba(0,0,0,0.2);">
                                    <div class="span12">
                                        <label><strong>Pesquisar Cliente:</strong></label>
                                        <input type="text" name="name" class="span12" id="searchInput" placeholder="Por nome, cpf ou cnpj" autofocus="" />
                                    </div>
                                </div>
                                <div class="row-fluid" style="max-height: 400px;overflow: auto;position: relative;">
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th style="text-align: center;">Tipo de Conta</th>
                                                <th style="text-align: center;">Dados</th>
                                                <th style="text-align: center;">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $tds->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr id="cl_<?php echo $row['cliente_id']; ?>">
                                                    <td><?php echo $row['cliente_nome']; ?></td>
                                                    <td style="text-align: center;"><?php echo strlen($row['cliente_cpf']) <= '14' ? 'CPF' : 'CNPJ'; ?></td>
                                                    <td style="text-align: center;"><?php echo $row['cliente_cpf']; ?></td>
                                                    <td style="text-align: center;">
                                                        <a href="javascript:void(0)" title="Clique para editar"
                                                           data-nome="<?php echo $row['cliente_nome']; ?>"
                                                           data-cpf="<?php echo $row['cliente_cpf']; ?>"
                                                           data-id="<?php echo $row['cliente_id']; ?>"
                                                           class="btn mini green editar-cliente"><i class="fa fa-edit"></i> Editar</a>
                                                        <a href="javascript:void(0)" title="Clique para excluir" 
                                                           id="<?php echo $row['cliente_id']; ?>"
                                                           class="btn mini red excluir-cliente"><i class="fa fa-trash"></i> Excluir</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            var $rows = $('#table tbody tr');

                            $('#searchInput').keyup(function () {
                                var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase().split(' ');
                                $rows.hide().filter(function () {
                                    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                                    var matchesSearch = true;
                                    $(val).each(function (index, value) {
                                        matchesSearch = (!matchesSearch) ? false : ~text.indexOf(value);
                                    });
                                    return matchesSearch;
                                }).show();
                            });

                            /* $(".cls_tipo_cliente").change(function (ev) {
                             
                             var v = this.value;
                             if (v == 'cpf') {
                             $('#cpfId,#cpf_cliente').mask("###.###.###-##", {reverse: false});
                             } else if (v == 'cnpj') {
                             $('#cpfId,#cpf_cliente').mask("##.###.###/####-##", {reverse: false});
                             }
                             });
                             */
                            $('.cls_tipo_cliente').click(function () {
                                var v = this.value;
                                if (v == 'cpf') {
                                    $('#getCpf').html('CPF:');
                                    $('#cpfId,#cpf_cliente,#cli_cpf').mask("###.###.###-##", {reverse: false});
                                } else if (v == 'cnpj') {
                                    $('#getCpf').html('CNPJ:');
                                    $('#cpfId,#cpf_cliente,#cli_cpf').mask("##.###.###/####-##", {reverse: false});
                                }
                            });

                            var _modal = document.getElementById('modalEditarCliente');

                            $('.editar-cliente').click(function () {
                                var _nome = $(this).attr('data-nome');
                                var _cpf = $(this).attr('data-cpf');
                                var _id = $(this).attr('data-id');
                                _modal.style.display = "block";
                                $('#cli_nome').val(_nome);
                                $('#cli_cpf').val(_cpf);
                                $('#cli_id').val(_id);
                                var sCpf = _cpf.length;
                                /*getCpf*/
                                if (sCpf <= 14) {
                                    $('#getCpf').html('CPF:');
                                    $('#inputRadio11').prop('checked', true);
                                    $('#cli_cpf').mask("###.###.###-##", {reverse: false});
                                } else {
                                    $('#getCpf').html('CNPJ:');
                                    $('#inputRadio22').prop('checked', true);
                                    $('#cli_cpf').mask("##.###.###/####-##", {reverse: false});
                                }
                            });

                            $('.cancelar-modal,.tel-close').click(function () {
                                _modal.style.display = "none";
                            });

                            var _locl = window.localStorage;

                            if (_locl.getItem('tabcliente') != null) {
                                if (_locl.getItem('tabcliente') == '1') {
                                    $('#tabcliente_1,#tab_1_1').addClass('active');
                                    $('#tabcliente_2,#tab_1_2').removeClass('active');
                                } else if (_locl.getItem('tabcliente') == '2') {
                                    $('#tabcliente_2,#tab_1_2').addClass('active');
                                    $('#tabcliente_1,#tab_1_1').removeClass('active');
                                }
                            }

                            $('.tabcliente').click(function () {
                                var _attr = $(this).attr('data-tab');
                                _locl.setItem('tabcliente', _attr);
                            });

                            /*ALTERAR DADOS DE CLIENTE*/
                            $('#formAlterarCliente').ajaxForm({
                                beforeSend: function () {
                                    $('#btnAlterarCliente').attr('disabled', true).html('Salvando alterações, aguarde...');
                                },
                                uploadProgress: function (event, position, total, percentComplete) {
                                    var percentVal = percentComplete + '%';
                                },
                                success: function (data) {
                                    if (data == '1') {
                                        $('#btnAlterarCliente').attr('disabled', false).html('Salvar Alterações');
                                        $("#cl_" + $('#cli_id').val()).find('td').eq(0).html($('#cli_nome').val());
                                        $("#cl_" + $('#cli_id').val()).find('td').eq(2).html($('#cli_cpf').val());
                                        mostrasSnackbar('Dados alterados com sucesso!');
                                    } else if (data == '0') {
                                        $('#btnAlterarCliente').attr('disabled', false).html('Salvar Alterações');
                                        mostrasSnackbar('Nenhum dado foi alterado!');
                                    } else {
                                        $('#btnAlterarCliente').attr('disabled', false).html('Salvar Alterações');
                                        mostrasSnackbar('Não foi possível fazer as alterações.<br/>' + data);
                                    }
                                }
                            });

                            $('.excluir-cliente').click(function () {

                                var _idCliente = this.id;

                                if (confirm("Tem certeza de que deseja realmente excluir este cliente?")) {
                                    $('#cl_' + _idCliente).remove();
                                    $.post('clientes/models/acoes.php', {
                                        acao: 'delete',
                                        cliente_id: _idCliente
                                    }, function (data) {
                                        if (data != '1') {
                                            alert('Não foi possível fazer a exclusão. Tente novamente.');
                                        }
                                    });
                                }
                            });

                            $('#form-criar-novo-usuario').ajaxForm({
                                beforeSend: function () {
                                },
                                uploadProgress: function (event, position, total, percentComplete) {
                                    var percentVal = percentComplete + '%';
                                    $('#btnCriarNovoUsuario').html(percentVal + ' Salvando, aguarde...');
                                },
                                success: function (data) {

                                    if (data == '1') {
                                        mostrasSnackbar('Cliente cadastrado com sucesso!');
                                    } else {
                                        mostrasSnackbar('Não foi possível fazer a inclusão do cliente.\n' + data);
                                    }

                                    $('#btnCriarNovoUsuario').html('Salvar');
                                }
                            });
                        });
                    </script>
                    <?php
                    break;
            }
            ?>
        </div>
        <?php
    }