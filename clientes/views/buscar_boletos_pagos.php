<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../../autoload.php';

    $Clientes = new Clientes($connection);

    define('PATH_ARQUIVOS', '/arquivos-de-boletos/');

    $filtro = trim(val_input::sani_string('s'));

    $tipo = 'pago';

    $total = 0;

    switch ($tipo) {
        case 'pago':
            //Conta
            $total = $Clientes->contar_boletos_pagos(false);

            break;
    }

    if ($total == 0) {
        ?>

        <div class="row-fluid">

            <div class="span12">

                <div class="alert alert-error">
                    Não há nenhum boleto pago agora.
                </div>

            </div>

        </div>

        <?php
    } else {

        $ft = false;

        switch ($tipo) {
            case 'pago':
                $total = $Clientes->contar_boletos_pagos(false);
                $ft = $Clientes->contar_boletos_pagos(true);
                break;
        }
        ?>

        <div class="row-fluid">

            <div class="span12">

                <div class="alert alert-info">
                    <h2>Notificação:</h2>
                    <strong><?php echo $total; ?> <?php echo $total == 1 ? ' registro' : ' registros'; ?></strong>.

                </div>

            </div>

        </div>

        <div class="row-fluid">

            <div class="span12" style="max-height: 500px;overflow: auto;">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Nome</th>

                            <th>CPF</th>

                            <th>Boleto</th>

                            <th style="text-align: center;">Pago?</th>

                            <th style="text-align: center;">Data/Pagamento</th>

                            <?php
                            if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                ?>

                                <th style="text-align: center;">Opções</th>

                                <?php
                            }
                            ?>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        while ($row = $ft->fetch(PDO::FETCH_ASSOC)) {

                            $c = $Clientes->verificar_se_exite_boletos($row['cliente_id']);

                            $dados = $Clientes->buscar_boletos_por_cliente_id($row['cliente_id']);
                            
                            $boletoId = $row['boleto_id'];
                            
                            ?>

                            <tr id="cliente_<?php echo $row['cliente_id']; ?>">
                                <td><?php echo $boletoId; ?></td>
                                <td><?php echo $row['cliente_nome']; ?></td>
                                <td><?php echo $row['cliente_cpf']; ?></td>
                                <td>
                                    <?php
                                    if ($dados['excluido'] != 'sim') {

                                        if ($c > 0) {
                                            ?>

                                            <a href="<?php echo PATH_ARQUIVOS . $dados['boleto_file_md5']; ?>"

                                               target="_blank"

                                               title="Clique para visualizar">

                                                <?php
                                                echo $dados['boleto_file_realname'];
                                                ?>

                                            </a>

                                            <?php
                                        } else {
                                            ?>

                                            <label class="bold text-error">Boleto Indisponível</label>

                                            <?php
                                        }
                                    }
                                    ?></td>

                                <?php
                                if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                    ?>

                                    <td style="text-align: center;">

                                        <?php ?>

                                        <!-- Rounded switch -->

                                        <?php
                                        if ($dados['excluido'] != 'sim') {

                                            if ($c > 0) {

                                                if ($dados['boleto_pago'] == 'sim') {
                                                    ?>

                                                    <label class="switch" title="Já foi Pago." 

                                                           data-id="<?php echo $dados['boleto_id']; ?>" data-value="nao"

                                                           data-nome-cliente="<?php echo $row['cliente_nome']; ?>"

                                                           data-cpf-cliente="<?php echo $row['cliente_cpf']; ?>" >

                                                        <input type="checkbox" checked="" id="checkbox_<?php echo $dados['boleto_id']; ?>">

                                                        <div class="slider round"></div>

                                                    </label>

                                                    <?php
                                                } else {
                                                    ?>

                                                    <label class="switch" title="Não foi Pago."

                                                           data-nome-cliente="<?php echo $row['cliente_nome']; ?>"

                                                           data-cpf-cliente="<?php echo $row['cliente_cpf']; ?>"

                                                           data-id="<?php echo $dados['boleto_id']; ?>"  data-value="sim">

                                                        <input type="checkbox" id="checkbox_<?php echo $dados['boleto_id']; ?>">

                                                        <div class="slider round"></div>

                                                    </label>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>

                                    </td>

                                    <td style="text-align: center;">

                                        <b><?php
                                            if ($dados['excluido'] != 'sim') {

                                                if ($dados['boleto_data_pagamento'] != null) {

                                                    echo date('d/m/Y \à\s H:i:s', $dados['boleto_data_pagamento']);
                                                }
                                            }
                                            ?></b> 

                                    </td>

                                    <?php
                                } else {
                                    ?>

                                    <td style="text-align: center;">

                                        <?php ?>

                                        <!-- Rounded switch -->

                                        <?php
                                        if ($dados['excluido'] != 'sim') {

                                            if ($c > 0) {

                                                if ($dados['boleto_pago'] == 'sim') {
                                                    ?>

                                                    <label class="switch" title="Já foi Pago."

                                                           data-id="<?php echo $dados['boleto_id']; ?>" data-value="nao">

                                                        <input type="checkbox" id="checkbox_<?php echo $dados['boleto_id']; ?>" checked="" disabled="">

                                                        <div class="slider round"></div>

                                                    </label>

                                                    <?php
                                                } else {
                                                    ?>

                                                    <label class="switch" title="Não foi Pago."

                                                           data-nome-cliente="<?php echo $row['cliente_nome']; ?>"

                                                           data-cpf-cliente="<?php echo $row['cliente_cpf']; ?>"

                                                           data-id="<?php echo $dados['boleto_id']; ?>"  data-value="sim">

                                                        <input type="checkbox" id="checkbox_<?php echo $dados['boleto_id']; ?>" >

                                                        <div class="slider round"></div>

                                                    </label>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>

                                    </td>

                                    <td style="text-align: center;">

                                        <b><?php
                                            if ($dados['excluido'] != 'sim') {

                                                if ($dados['boleto_data_pagamento'] != null) {

                                                    echo date('d/m/Y \à\s H:i:s', $dados['boleto_data_pagamento']);
                                                }
                                            }
                                            ?></b>

                                    </td>

                                    <?php
                                }

                                if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador') {
                                    $id_cliente = $row['cliente_id'];
                                    ?>
                                    <td style="text-align: right !important;">
                                        <div class="row-fluid text-center">
                                            <div class="span7 text-right">
                                                <label class="span12" for="<?php echo $id_cliente; ?>">Marcar como visto</label>
                                            </div>
                                            <div class="span2">
                                                <input type="checkbox" class="input_visto"
                                                       data-boleto-id="<?php echo $boletoId; ?>" 
                                                       class="span12" style="text-align: right !important;" id="<?php echo $id_cliente; ?>"
                                                       data-cliente-id="<?php echo $id_cliente; ?>"  />
                                                <label class="span12" for="<?php echo $id_cliente; ?>"
                                                       style="text-align: right !important;width:15px !important;" ></label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>

                            </tr>

                            <?php
                        }
                        ?>

                    </tbody>
                </table> 
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <button class="btn yellow pull-right" id="btnMarcarBoletoComoVisto"
                        style="padding-top:15px;padding-bottom:15px;">Marcar como visto</button>
            </div>
        </div>
        <div class="clearfix"></div><br/>
        <script>

            $(document).ready(function () {

                /*$('#example').DataTable();*/

            });

        </script>

        <?php
        if ($_SESSION['tx_dados_usuario']['conta_nivel'] == 'administrador' || $_SESSION['tx_dados_usuario']['conta_nivel'] == 'padrao') {
            ?>

            <div id="modalEnviarBoleto" class="telecom-modal">

                <!-- Modal content -->

                <div class="modal-content">

                    <div class="tel-modal-header">

                        <span class="tel-close">&times;</span>

                        <h2 style="padding:0px !important;">Enviar boletos</h2>

                    </div>

                    <div class="modal-body">

                        <div class="row-fluid">

                            <div class="span12">

                                <form enctype="multipart/form-data" action="../boletos/models/enviar_upload.php"

                                      method="POST" id="form-enviar-boleto">

                                    <div class="row-fluid">

                                        <div class="row-fluid">

                                            <label><b>Cliente:</b></label>

                                            <h2 id="bol_cliente_nome"></h2>

                                            <label><b>CPF:</b></label>

                                            <h2  id="bol_cliente_cpf"></h2>

                                            <label><b>Procurar Arquivo:</b></label>

                                            <input type="hidden" name="cliente_id" id="bol_cliente_id" />

                                        </div>

                                        <div class="row-fluid">

                                            <div class="enviarBoleto"></div>

                                        </div>

                                        <div class="row-fluid">

                                            <div class="alert alert-success" style="display: none;" id="resultado"></div>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    <div class="tel-modal-footer">

                        <div class="row-fluid text-center">

                            <button class="button-sys cancelar-modal" 

                                    style="background: #d84a38;font-size:18px;"><i class="fa fa-window-close"></i> Cancelar</button>

                            <button class="button-sys" form="form-enviar-boleto" id="btnEnviarArquivo"

                                    type="submit" style="background: #0362fd;font-size:18px;">

                                <i class="fa fa-upload" aria-hidden="true" /></i> Enviar Boleto</button>

                        </div>

                    </div>

                </div>

            </div>

            <!-- The Modal -->

            <div id="myModal" class="telecom-modal">

                <!-- Modal content -->

                <div class="modal-content">

                    <div class="tel-modal-header">

                        <span class="tel-close">&times;</span>

                        <h2 style="padding:0px !important;">Atenção!</h2>

                    </div>

                    <div class="modal-body">

                        <?php
                        $Configuracoes = new Configuracoes($connection);

                        $config = $Configuracoes->get_config(1);
                        ?>

                        <div class="row-fluid">

                            <div class="alert alert-info">

                                <label><strong>Cliente:</strong></label>

                                <h1 id="getNomeCliente"></h1>

                                <label><strong>CPF:</strong></label>

                                <h1 id="getCPFCliente"></h1>

                            </div>

                        </div>
                        <h3 style="font-size:15px;line-height: 25px;text-align: justify;
                            margin:0 !important;padding:0px !important;">Tem certeza de que deseja marcar este boleto como 
                            <mark><strong id="tipoPagamento" style="font-weight:900;text-transform: uppercase;"></strong></mark>? Lembrando que se marcar como pago, 
                            não poderá mais alterar para não pago. Qualquer coisa, entrar em contato com o administrador pelo número:</h3>
                        <h1 class="text-center alert"><?php echo $config['telefone']; ?></h1>
                    </div>
                    <div class="tel-modal-footer">
                        <div class="row-fluid text-center">
                            <button class="button-sys cancelar-modal" style="background: #d84a38;font-size:18px;">Cancelar</button>
                            <button class="button-sys confirmar-modal" style="background: #0362fd;font-size:18px;">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {

                    $('.enviarBoleto')._neoPluginUpload({

                        accept: ".pdf",

                        tiposPermitidos: ['application/pdf', 'application/force-download'],

                        tamanhoPermitido: 1073741824

                    });

                    var _loc = window.localStorage;

                    $('#form-enviar-boleto').ajaxForm({

                        beforeSend: function () {

                        },
                        uploadProgress: function (event, position, total, percentComplete) {

                            var percentVal = percentComplete + '%';

                            $('#btnEnviarArquivo').html(percentVal + ' Enviando arquivo...');

                        },

                        success: function (data) {

                            if (data == '1') {

                                alert('Boleto inserido comsuceso!');

                                $('#cadastrar-boleto').fadeOut('slow');

                                $('#btnEnviarArquivo').html('Enviar');

                                $('#_s').val(_loc.getItem('s'));

                                $('#btnPesquisarClientes').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Pesquisando...').attr('disabled', true);

                                $.post('clientes/views/pesquisar_clientes.php', {

                                    s: _loc.getItem('s'),

                                    tipo_filtro: _loc.getItem('tipoFiltro')

                                }, function (data) {

                                    $('#btnPesquisarClientes').html('<i class="fa fa-search" aria-hidden="true" /></i> Pesquisar').attr('disabled', false);

                                    $(".result").html(data);

                                });

                            } else {

                                alert('Não foi possível incluir o boleto.\n\nMensagem do erro: ' + data);

                                $('#btnEnviarArquivo').html('Enviar');

                            }

                        },

                        complete: function (xhr) {

                            /*status.html(xhr.responseText);*/

                        }

                    });

                    var _modalBoleto = document.getElementById('modalEnviarBoleto');

                    $('.cancelar-modal,.tel-close').click(function () {

                        _modalBoleto.style.display = "none";

                    });

                    $('.gerar-boleto').click(function () {

                        var bolCliNome = $(this).attr('data-nome');

                        var bolCliCpf = $(this).attr('data-cpf');

                        var bolCliId = $(this).attr('data-id');

                        $("#bol_cliente_nome").html(bolCliNome);

                        $("#bol_cliente_cpf").html(bolCliCpf);

                        $("#bol_cliente_id").val(bolCliId);

                        _modalBoleto.style.display = "block";

                        return false;

                    });

                    var __loc = window.localStorage;

                    /*EXCLUIR CLIENTE*/

                    $('.excluir-boleto').click(function () {

                        var _boleto_id = $(this).attr('data-boleto-id');

                        if (confirm("Tem certeza de que deseja excluir este boleto permanentemente?")) {

                            $('#cliente_' + _boleto_id).remove();

                            $.post('boletos/models/excluir_boleto.php', {

                                boleto_id: _boleto_id,

                                acao: 'delete'

                            }, function (data) {

                                if (data == '1') {

                                    alert('Sucesso!');

                                    $('#_s').val(__loc.getItem('s'));

                                    $('#btnPesquisarClientes').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Pesquisando...').attr('disabled', true);

                                    $.post('clientes/views/pesquisar_clientes.php', {

                                        s: __loc.getItem('s'),

                                        tipo_filtro: __loc.getItem('tipoFiltro')

                                    }, function (data) {

                                        $('#btnPesquisarClientes').html('<i class="fa fa-search" aria-hidden="true" /></i> Pesquisar').attr('disabled', false);

                                        $(".result").html(data);

                                    });

                                } else {

                                    alert(data);

                                }

                            });

                        }

                    });

                    var _tipoUser = '<?php echo $_SESSION['tx_dados_usuario']['conta_nivel']; ?>';

                    /*Get the modal*/

                    var modal = document.getElementById('myModal');

                    /*When the user clicks on <span> (x), close the modal*/

                    $('.tel-close').click(function () {

                        modal.style.display = "none";

                    });

                    $('.cancelar-modal').click(function () {

                        modal.style.display = "none";

                    });

                    $('.confirmar-modal').click(function () {

                        var _thisBtn = $(this);

                        var _valor;

                        var _chk = $('#checkbox_' + __loc.getItem('boleto_id'));

                        if (_tipoUser == 'padrao') {

                            if (_chk.prop('checked') == true) {

                                _valor = 'sim';

                            }

                        } else {

                            if (_chk.prop('checked') == true) {

                                _chk.prop('checked', false);

                                _valor = 'nao';

                            } else {

                                _valor = 'sim';

                                _chk.prop('checked', true);

                            }

                        }

                        _thisBtn.attr('disabled', true).html('Salvando, aguarde...');

                        $.post('boletos/models/marcar_como_pago.php', {

                            boleto_id: __loc.getItem('boleto_id'),

                            valor: _valor

                        }, function (data) {

                            if (data == '1') {

                                _thisBtn.attr('disabled', false).html('Salvar');

                                alert('Operação realizada com sucesso!');

                                modal.style.display = "none";

                                window.location.reload();

                                return false;

                            } else {

                                alert('Ops! Houve um erro.\n Código do erro:' + data);

                            }

                        });

                    });

                    /*Get the <span> element that closes the modal*/

                    var span = document.getElementsByClassName("tel-close")[0];

                    /*When the user clicks on <span> (x), close the modal*/

                    span.onclick = function () {

                        modal.style.display = "none";

                    };

                    /*When the user clicks anywhere outside of the modal, close it*/

                    window.onclick = function (event) {

                        if (event.target == modal) {

                            modal.style.display = "none";

                        }

                    };

                    /*SALVA SE FOI OU NÃO PAGO*/

                    $('.switch').click(function () {

                        var _this = $(this);

                        var _nome = $(this).attr('data-nome-cliente');

                        var cpf = $(this).attr('data-cpf-cliente');

                        var tipoPagamento = $('#tipoPagamento');

                        $('#getNomeCliente').html(_nome);

                        $('#getCPFCliente').html(cpf);

                        __loc.setItem('boleto_id', _this.attr("data-id"));

                        if (_tipoUser == 'padrao') {

                            if ($('#checkbox_' + __loc.getItem('boleto_id')).prop('checked') == false) {

                                tipoPagamento.html('pago');

                                /*When the user clicks the button, open the modal */

                                $(this).click(function () {

                                    modal.style.display = "block";

                                    return false;

                                });

                            }

                        } else {

                            /*When the user clicks the button, open the modal */

                            $(this).click(function () {

                                if ($('#checkbox_' + __loc.getItem('boleto_id')).prop('checked') == false) {

                                    tipoPagamento.html('não pago');

                                } else {

                                    tipoPagamento.html('pago');

                                }

                                modal.style.display = "block";

                                return false;

                            });

                        }

                    });

                    /**
                     * 
                     */
                    $('#btnMarcarBoletoComoVisto').click(function () {

                        var boletoVisto = document.getElementsByClassName('input_visto');

                        var dados = [];

                        var isSelect = false;

                        var i = 0;
                        
                        for (var x = 0; x < boletoVisto.length; x++) {

                            if (boletoVisto[x].checked === true) {
                                //Se pelo menos uma vez for marcado algum checkbox
                                isSelect = true;
                                ++i;
                                //dados[x] = [boletoVisto[x].checked, boletoVisto[x].getAttribute("data-boleto-id")];
                                dados[x] = boletoVisto[x].getAttribute("data-boleto-id");
                            }

                        }
                        if (isSelect === true) {
                            if (confirm("Deseja realmente marcar como visto?")) {
                                
                                $("#btnMarcarBoletoComoVisto").attr("disabled", true).html("Salvando, aguarde...");
                                
                                $.post("clientes/models/definir_visto_admin.php", {
                                    boletos: dados
                                }, function (data) {
                                    if (data > 0) {
                                        alert("Operação realizada com sucesso!");

                                        window.location.reload();

                                    } else if (data === 0) {
                                        $("#btnMarcarBoletoComoVisto").attr("disabled", false).html("Tentar novamente");
                                        alert("Nenhum dado foi alterado!");
                                    } else {
                                        $("#btnMarcarBoletoComoVisto").attr("disabled", false).html("Tentar novamente");
                                        alert("Houve um erro. \nMensagem do erro:" + data);
                                        console.log(data);
                                    }
                                });
                            }
                        } else {
                            alert("Por favor, marque algum registro para poder marcar como visto.");
                        }

                    });
                });
            </script>

            <?php
        }
    }
}