<?php
include 'autoload.php';
$san = new Sanitize_Output();
$Configuracoes = new Configuracoes($connection);
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <title>RSV Telecom</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="assets/css/bootstrap-responsive.min.css"/>
        <script src="assets/js/jquery-1.10.1.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.form.js"></script>
        <?php
        $dados = $Configuracoes->get_config(1, 'config_id,fonte_family,fonte_size');
        ?>
        <link href='//fonts.googleapis.com/css?family=<?php echo $dados['fonte_family']; ?>' rel='stylesheet'>
        <?php
        if (isset($_SESSION['logado'])) {
            ?>
            <script src="assets/js/jquery.cookie.min.js"></script>
            <script src="assets/js/plugins_neoinovat.min.js"></script>
            <script src="assets/js/scripts.min.js"></script>
            <script src="assets/js/jquery.mask.min.js"></script>
            <link rel="stylesheet" href="assets/css/neoinovat_css.min.css" />
            <script src="assets/data-tables/jquery.dataTables.js"></script>
            <link rel="stylesheet" href="assets/data-tables/jquery.dataTables.min.css" />
            <script src="assets/data-tables/DT_bootstrap.js"></script>
            <?php
        }
        ?>
        <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/css/css_basico.min.css" />
        <link rel="stylesheet" href="assets/css/metro.css" />
        <?php
        echo "<style>body{font:" . $dados['fonte_size'] . "px '" . $dados['fonte_family'] . "';}</style>";
        ?>
    </head>
    <body>
        <?php

        function numeroDiaDuasDatas() {

            $now = time(); // or your date as well
            //Ano-Mes-Dia

            $your_date = strtotime("2017-11-15");

            $datediff = $now - $your_date;

            return floor($datediff / (60 * 60 * 24));
        }
        
        $tipoConta = false;
    
        if (isset($_SESSION['logado'])) {

            //Pega o nível do usuário se estiver logado.
            $tipoConta = $_SESSION['tx_dados_usuario']['conta_nivel'];
            if ($tipoConta == 'administrador') {

                $dia = (int) date('d');
                $mes = (int) date('m');
                $ano = (int) date('Y');
                $Pg = new Pagamentos($connection);

                if ($Pg->vericarSeExiste($mes, $ano) == '0') {
                    $Pg->inserir($mes, $ano);
                }

                define("DIA_20", 20);

                if ($Pg->pago($mes, $ano) == 'nao') {
                    if ($dia >= 15) {
                        ?>
                        <div class="container text-center">
                            <h1>
                                <?php
                                $dias_restantes = DIA_20 - date('d');
                                if ($dias_restantes == 5) {
                                    echo '<span style="background:#ffe6e6;display:block;">Fatam ', $dias_restantes, ' dias para o vencimento.</span>';
                                } else if ($dias_restantes == 4) {
                                    echo '<span style="background:#ff9999;display:block;">Fatam ', $dias_restantes, ' dias para o vencimento.</span>';
                                } else if ($dias_restantes == 3) {
                                    echo '<span style="background:#ff4d4d;display:block;">Fatam ', $dias_restantes, ' dias para o vencimento.</span>';
                                } else if ($dias_restantes == 2) {
                                    echo '<span style="background:#ff6666;display:block;">Fatam ', $dias_restantes, ' dias para o vencimento.</span>';
                                } else if ($dias_restantes == 1) {
                                    echo '<span style="background:#ff3333;display:block;">Fata ', $dias_restantes, ' dia para o vencimento.</span>';
                                } else if ($dias_restantes == 0) {
                                    echo '<span style="background:#ff0000;display:block;">&nbsp;Vence hoje.&nbsp;</span>';
                                } else {
                                    $r = -$dias_restantes;
                                    if ($r == 1) {
                                        echo '<span style="background:#ff0000;display:block;">', $r, '&nbsp; dia vencido.&nbsp;', '</span>';
                                    } else {
                                        echo '<span style="background:#ff0000;display:block;">', $r, '&nbsp; dias vencidos.&nbsp;', '</span>';
                                    }
                                }
                                echo 'Hoje é ', date('d/m/Y');
                                ?>
                            </h1>
                        </div>
                        <?php
                    }
                }
            }
        }
        ?>
        <br/>
        <div class="container" style="border:4px solid #f1f1f1;position: relative;height:768px;">
            <?php
            if (isset($_SESSION['logado'])) {
                ?>
                <div id="snackbar" style="display: block;"></div>
                <a href="javascript:void(0)" title="Clique para sair" class="sair-sistema btn red pull-right" >
                    <?php echo $_SESSION['tx_dados_usuario']['conta_usuario']; ?>&nbsp;<i class="fa fa-power-off" aria-hidden="true" /></i></a>
                <a href="#" title="" class="btn transparent pull-right">
                    <strong>Usuário com privilégios <?php echo ($tipoConta == 'padrao') ? ' padrões ' : 'administrativos'; ?></strong></a>
                <?php
            }
            ?>
            <h1 class="titulo" style="float:left;">Telecom</h1><br/>
            <div class="clearfix"></div>
            <hr style="margin-top:10px;margin-bottom:10px;border:0;border-top:0px dashed #ccc;" />
            <?php
            if (isset($_SESSION['logado'])) {
                ?>
                <div class="row-fluid">
                    <div class="tabbable tabbable-custom tabs-left">
                        <!-- Only required for left/right tabs -->
                        <ul class="nav nav-tabs tabs-left">
                            <li class="active acoes" id="aba1" data-acao="1"><a href="#tab_3_1" data-toggle="tab"><strong>Pesquisar</strong></a></li>
                            <li class="acoes" data-acao="2" id="aba2" ><a href="#tab_3_2" data-toggle="tab"><strong>Usuários</strong></a></li>
                            <?php
                            if ($tipoConta == 'administrador') {
                                ?>
                                <li class="acoes" data-acao="3" id="aba3"><a href="#tab_3_3" data-toggle="tab"><strong>Clientes</strong></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="tab-content">
                            <?php
                            if ($tipoConta == 'administrador') {
                                ?>
                                <div class="row-fluid">
                                    <div class="b_boletos_pagos"></div>
                                    <hr style="border:0px; border-top:1px solid #ccc;margin:0px;">
                                </div>
                                <?php }
                            ?>
                            <div class="tab-pane active" id="tab_3_1">
                                <form action="clientes/views/pesquisar_clientes.php" method="post" id='pesquisarClientes'>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <label><strong>Pesquisar cliente:</strong></label>

                                            <div class="row-fluid">
                                                <div class="span2">
                                                    <input class="pull-left" type="radio" value="nome" id="radio_nome" name="tipo_filtro" style="width: 20px;height: 20px;" checked="" />
                                                    <label class="pull-left" for="radio_nome" style="position: relative;margin-top:4px;">&nbsp;<strong>Por nome</strong></label>
                                                </div>
                                                <div class="span2">
                                                    <input class="pull-left" id="radio_cpf" value="cpf" type="radio" name="tipo_filtro" style="width: 20px;height: 20px;"   />
                                                    <label class="pull-left" for="radio_cpf" style="position: relative;margin-top:4px;">&nbsp;<strong>Por CPF</strong></label>
                                                </div>
                                                <div class="span2">
                                                    <input class="pull-left" id="radio_cnpj" value="cnpj" type="radio" name="tipo_filtro" style="width: 20px;height: 20px;"   />
                                                    <label class="pull-left" for="radio_cnpj" style="position: relative;margin-top:4px;">&nbsp;<strong>Por CNPJ</strong></label>
                                                </div>
                                                <div class="span2">
                                                    <input class="pull-left" id="radio_boleto" value="boleto" type="radio" name="tipo_filtro" style="width: 20px;height: 20px;"   />
                                                    <label class="pull-left" for="radio_boleto" style="position: relative;margin-top:4px;">&nbsp;<strong>Por Nome de Boleto</strong></label>
                                                </div>
                                            </div>

                                            <input class="span9" type="text" name="s" id="_s" autofocus="" required="" placeholder="Por nome ou CPF" autocomplete="off" />
                                            <button class="span3 pull-right button-sys" id="btnPesquisarClientes" 
                                                    style="padding-top:10px;padding-bottom:10px;"><i class="fa fa-search" aria-hidden="true" /></i> Pesquisar</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="result">
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div id="gerarBoleto"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3_2">
                                <div class="row-fluid" id="tab_3_2_1">
                                    <div class="m-load">
                                        <div class="loader"></div><label>&nbsp;carregando...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3_3">
                                <div class="row-fluid" id="tab_3_3_1">
                                    <div class="m-load">
                                        <div class="loader"></div><label>&nbsp;carregando...</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {


                        var ls = window.localStorage;

                        $.post("/clientes/views/buscar_boletos_pagos.php", function (data) {
                            $(".b_boletos_pagos").html(data);
                        });

                        $('input[name=tipo_filtro]').click(function () {
                            var __value = this.value;
                            if (__value == 'cpf') {
                                $('#_s').mask("###.###.###-##", {reverse: false});
                            } else if (__value == 'cnpj') {
                                $('#_s').mask("##.###.###/####-##", {reverse: false});
                            } else {
                                $('#_s').unmask().val(ls.getItem('s'));
                            }
                            $('#_s').select();
                            ls.setItem('tipoFiltro', __value);
                        });

                        if (ls.getItem('tipoFiltro') != null) {
                            $('#radio_' + ls.getItem('tipoFiltro')).prop('checked', true);
                        }

                        if (ls.getItem('s') != null) {
                            $('#_s').val(ls.getItem('s'));
                            $('#btnPesquisarClientes').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Pesquisando...').attr('disabled', true);
                            $.post('clientes/views/pesquisar_clientes.php', {
                                s: ls.getItem('s'),
                                tipo_filtro: ls.getItem('tipoFiltro')
                            }, function (data) {
                                $('#btnPesquisarClientes').html('<i class="fa fa-search" aria-hidden="true" /></i> Pesquisar').attr('disabled', false);
                                $(".result").html(data);
                            });
                        }

                        $('#pesquisarClientes').ajaxForm({
                            beforeSend: function () {
                                ls.setItem('s', $('#_s').val());
                                $('#btnPesquisarClientes').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Pesquisando...').attr('disabled', true);
                            },
                            uploadProgress: function (event, position, total, percentComplete) {
                                var percentVal = percentComplete + '%';
                                /*bar.width(percentVal)
                                 percent.html(percentVal);*/
                            },
                            success: function (data) {
                                var percentVal = '100%';
                                $(".result").html(data);
                                $('#btnPesquisarClientes').html('<i class="fa fa-search" aria-hidden="true" /></i> Pesquisar').attr('disabled', false);
                                /*bar.width(percentVal)
                                 percent.html(percentVal);*/
                            },
                            complete: function (xhr) {
                                /*status.html(xhr.responseText);*/
                            }
                        });
                        var tipoConta = '<?php echo $tipoConta ?>', cadastrarUsuario = false, cadastroClient = false;

                        if (ls.getItem("aba") == null) {
                            $('#aba1').addClass('active');
                            $('#aba3,#aba2').removeClass('active');
                        } else {
                            switch (ls.getItem("aba")) {
                                case '1':
                                    $('#aba1,#tab_3_1').addClass('active');
                                    $('#aba3,#aba2,#tab_3_3,#tab_3_2').removeClass('active');
                                    break;
                                case '2':
                                    $('#aba2,#tab_3_2').addClass('active');
                                    $('#aba3,#aba1,#tab_3_3,#tab_3_1').removeClass('active');
                                    if (cadastrarUsuario == false) {
                                        cadastrarUsuario = true;
                                        $.post('views/acoes.php', {
                                            acao: 'cadastrar-usuario'
                                        }, function (data) {
                                            $('#tab_3_2_1').html(data);
                                        });
                                    }
                                    break;
                                case '3':
                                    $('#aba3,#tab_3_3').addClass('active');
                                    $('#aba2,#aba1,#tab_3_2,#tab_3_1').removeClass('active');
                                    if (tipoConta == 'administrador') {
                                        if (cadastroClient == false) {
                                            cadastroClient = true;
                                            $.post('views/acoes.php', {
                                                acao: 'cadastrar-cliente'
                                            }, function (data) {
                                                $('#tab_3_3_1').html(data);
                                            });
                                        }
                                    }
                                    break;
                            }
                        }

                        $('.acoes').click(function () {
                            var _acao = $(this).attr('data-acao');
                            switch (_acao) {
                                case '1':
                                    ls.setItem("aba", '1');
                                    break;
                                case '2':
                                    ls.setItem("aba", '2');
                                    if (cadastrarUsuario == false) {
                                        cadastrarUsuario = true;
                                        $.post('views/acoes.php', {
                                            acao: 'cadastrar-usuario'
                                        }, function (data) {
                                            $('#tab_3_2_1').html(data);
                                        });
                                    }
                                    break;
                                case '3':
                                    ls.setItem("aba", '3');
                                    if (tipoConta == 'administrador') {
                                        if (cadastroClient == false) {
                                            cadastroClient = true;
                                            $.post('views/acoes.php', {
                                                acao: 'cadastrar-cliente'
                                            }, function (data) {
                                                $('#tab_3_3_1').html(data);
                                            });
                                        }
                                    }
                                    break;
                            }
                        });

                        $('#_s').keyup(function () {
                            var _this = this.value;
                            console.log($.isNumeric(_this));
                        });
                    });
                </script>
                <?php
            } else {
                ?>
                <!--LOGIN-->
                <div class="row-fluid">
                    <div class="span4"></div>
                    <div class="span4">
                        <form id="form-login" method="POST" action="models/login.php" autocomplete="on">
                            <h3 class="text-center">Login</h3>
                            <div class="row-fluid">
                                <label><b>Nome de Usuário:</b></label>
                                <input class="span12" type="text" placeholder="Entre com o nome de usário"
                                       name="uname" required="" autocomplete="off">
                            </div>
                            <div class="row-fluid">
                                <label><b>Senha:</b></label>
                                <input class="span12" type="password" placeholder="Entre com sua senha"
                                       name="psw" required="" autocomplete="off">
                            </div>
                            <button class="button-sys" type="submit" id="btnLoginSubmit"><i class="fa fa-lock" aria-hidden="true" /></i> Entrar</button>

                            <a href="http://192.168.2.1" target="_blank"><i class="fa fa-lock" aria-hidden="true" /></i> Abrir Link</a>

                    <!--<input type="checkbox" checked="checked"> Remember me-->  
                            <div style="background-color:#f1f1f1;text-align: center;">
                                <span style="padding-top:20px;padding-bottom:20px;display: block;">Esqueceu a <a href="#">senha?</a></span>
                            </div>
                        </form>
                    </div>
                    <div class="span4"></div>
                </div>
                <script>
                    $(document).ready(function () {
                        $('#form-login').ajaxForm({
                            beforeSend: function () {
                                /*status.empty();
                                 var percentVal = '0%';
                                 bar.width(percentVal)
                                 percent.html(percentVal);*/
                                $('#btnLoginSubmit').html('<i class="fa fa-spinner fa-spin fa-fw"></i>  Entrando, aguarde...').attr('disabled', true);
                            },
                            uploadProgress: function (event, position, total, percentComplete) {
                                var percentVal = percentComplete + '%';
                                /*bar.width(percentVal)
                                 percent.html(percentVal);*/
                            },
                            success: function (data) {
                                console.log(data);
                                if (data == '1') {
                                    window.location.reload();
                                } else if (data == '0') {
                                    alert('Usuário ou senha incorretos.');
                                    $('#btnLoginSubmit').html('<i class="fa fa-lock" aria-hidden="true" /></i> Entrar').attr('disabled', false);
                                } else {
                                    alert('Ops! Houve algum erro ao tentar fazer o login.');
                                    $('#btnLoginSubmit').html('<i class="fa fa-lock" aria-hidden="true" /></i> Entrar').attr('disabled', false);
                                }

                            }
                        });
                    });
                </script>
                <?php
            }
            ?>
        </div>
    </body>
</html>