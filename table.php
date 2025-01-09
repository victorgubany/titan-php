<?php require_once('./dbconn.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div>
            <form method="post" action="./table.php">
                <label for="company_name">Empresa:</label>
                <input type="text" id="company_name" name="company_name">

                <label for="amount_condition">Condição do Valor:</label>
                <select id="amount_condition" name="amount_condition">
                    <option disabled selected value="">Selecione</option>
                    <option value="=">Igual</option>
                    <option value=">">Maior</option>
                    <option value="<">Menor</option>
                </select>

                <label for="amount_value">Valor:</label>
                <input type="number" id="amount_value" name="amount_value" step="0.01" min="0">

                <label for="payment_date">Data de Pagamento:</label>
                <input type="date" id="payment_date" name="payment_date">

                <button type="submit">Filtrar</button>
            </form>
        </div>
        <table>
            <thead>
                <th>
                    Companie
                </th>
                <th>
                    Amount
                </th>
                <th>
                    Date
                </th>
                <th>
                    Status
                </th>
                <th>
                    Action
                </th>
                <th>
                    Payment
                </th>
            </thead>
            <tbody>
                <?php 
                foreach($results as $result){
                    echo "<tr>
                    <td>
                        $result[nome]
                    </td>
                    <td>
                        R$". number_format($result['valor'],2,',','.')."
                    </td>
                    <td>".
                        DateTime::createFromFormat('Y-m-d', $result['data_pagar'])->format('d/m/Y')."
                    </td>
                    <td>".
                        ($result['pago'] == 1 ? "Pago" : "Inadimplente") ."
                    </td>
                        <td>
                        <button class='modal-button'  data-date=".$result['data_pagar']." data-amount=".$result['valor']." data-payed=".$result['pago']." data-id=".$result['id_conta_pagar'].">
                        Editar
                        </button>
                    </td>
                    <td>
                        <form action='./table.php' method='post'>
                            <div style='display: none;' class='hidden'>
                                <input name='id' value=".$result['id_conta_pagar']." type='text' readonly>
                                <input name='type' value='pay' type='text' readonly>
                            </div>
                        <button type=submit class='pagar-button' ".($result['pago'] == 1 ?  "disabled": "") .">
                        Pagar
                        </button>
                         </form>
                    </td>
                </tr>";
                }
                ?>

            </tbody>
        </table>

        <!-- Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Editar Conta Pagar</h2>
                <form action="./table.php" method="post" id="editForm">
                    <div class="form-group" style="display: none;">
                        <label for="modal-id">ID</label>
                        <input name="id_register" type="text" id="modal-id" readonly>
                        <input name="type" value="update" type="text" readonly>
                    </div>
                    <div class="form-group">
                        <label for="modal-date">Data a Pagar</label>
                        <input required name="date" type="date" id="modal-date">
                    </div>
                    <div class="form-group">
                        <label for="modal-amount">Valor</label>
                        <input required name="value" min="0" value="0" step="0.01" type="number" id="modal-amount">
                    </div>
                    <div class="form-group">
                        <label for="modal-payed">Status</label>
                        <select required id="modal-payed" name="modal-payed">
                            <option value="1">Pago</option>
                            <option value="0">Inadimplente</option>
                        </select>
                    </div>
                    <div class="form-group buttons">
                        <button type="submit" id="saveButton">Salvar</button>
                </form>
                <form action="./table.php" method="post">
                    <div style="display: none;" class="hidden">
                        <input name="id_register2" type="text" id="modal-id2" readonly>
                        <input name="type" value="delete" type="text" readonly>
                    </div>
                    <button type="submit" id="deleteButton" class="delete-button">Apagar</button>
                </form>
            </div>

        </div>
    </div>
    </div>
</body>
<script src="./script.js"></script>

</html>