<?php
include '../autoload.php';
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <title>Pagamentos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="../assets/js/jquery-1.10.1.min.js"></script>
        <style>
            table{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php
        $Pg = new Pagamentos($connection);


        $pgt = $Pg->getPagamentos();
        ?>
        <table border="" style="width: 100%;border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>MÊS</th>
                    <th>ANO</th>
                    <th>#</th>
                </tr>
            </thead>
            <?php
            while ($rows = $pgt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo $rows['id']; ?></td>
                    <td><?php echo $rows['mes']; ?></td>
                    <td><?php echo $rows['ano']; ?></td>
                    <?php
                    if ($rows['pago'] == 'nao') {
                        ?>
                        <td id="td4"><button 
                                data-id="<?php echo $rows['id']; ?>"
                                data-mes="<?php echo $rows['mes']; ?>"
                                data-ano="<?php echo $rows['ano']; ?>"
                                class="classPagamentos">Confirmar Pagamento</button></td>

                        <?php
                    } else {
                        ?>
                        <td id="td4"><label style="background: green;color:white;">&nbsp;Pago&nbsp;</label></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
            ?>
        </table>
        <script>
            $(document).ready(function () {
                $('.classPagamentos').click(function () {
                    var _ths = $(this);

                    var _id = _ths.attr('data-id');
                    var _mes = _ths.attr('data-mes');
                    var _ano = _ths.attr('data-ano');
                    _ths.attr("disabled", true).html("Salvando...");

                    if (confirm('Confirmação do \nId:------' + _id + '\nMês:---' + _mes + '\nAno:-- ' + _ano + '\n\nDeseja realmente pagar?')) {
                        $.post('models/update_pagamento.php', {
                            id: _id,
                            mes: _mes,
                            ano: _ano
                        }, function (data) {
                            if (data == '1') {
                                alert('Pagamento efetuado com sucesso!');
                                $('#td4').html('<label>Pago</label>');
                            } else if (data == '0') {
                                alert('Nenhum dado foi atualizado.');
                                _ths.attr("disabled", false).html("Confirmar Pagamento");
                            } else {
                                alert('Houve um erro.\nCódigo ou mensagem do erro: ' + data);
                                _ths.attr("disabled", false).html("Confirmar Pagamento");
                            }
                        });
                    }

                });
            });
        </script>
    </body>
</html>


