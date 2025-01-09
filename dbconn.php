<?php
$connection = mysqli_connect('localhost', 'root', '');
if (!$connection) {
    die("Database Connection Failed: " . mysqli_connect_error()); 
}

$select_db = mysqli_select_db($connection, 'titan');
if (!$select_db) {
    die("Database Selection Failed: " . mysqli_error($connection));
}

if (isset($_POST['type']) && $_POST['type'] ==='update') {
    // var_dump($_POST);
    updateRegister($_POST['modal-payed'],DateTime::createFromFormat('Y-m-d', trim($_POST['date']))->format('Y-m-d'),$_POST['value'],$_POST['id_register'],$connection);
} elseif(isset($_POST['type']) && $_POST['type'] ==='delete') {
    deleteRegister($_POST['id_register2'],$connection);
}elseif(isset($_POST['type']) && $_POST['type'] ==='pay'){
    pay($_POST['id'],$connection);
}

$companyName = isset($_POST['company_name']) ? trim($_POST['company_name']) : '';
$amountCondition = isset($_POST['amount_condition']) ? $_POST['amount_condition'] : '';
$amountValue = isset($_POST['amount_value']) ? floatval($_POST['amount_value']) : 0;
$paymentDate = isset($_POST['payment_date']) ? trim($_POST['payment_date']) : '';

$query = "
    SELECT * 
    FROM tbl_conta_pagar
    INNER JOIN tbl_empresa ON tbl_conta_pagar.id_empresa = tbl_empresa.id_empresa
";

if (!empty($companyName)) {
    // var_dump($companyName); fix
    $query .= " AND tbl_empresa.nome LIKE '%" . $companyName . "%'";
}

if (!empty($amountCondition) && in_array($amountCondition, ['>', '<', '='])) {
    $query .= " AND tbl_conta_pagar.valor $amountCondition $amountValue";
}

if (!empty($paymentDate)) {
    var_dump($paymentDate);
    $query .= " AND tbl_conta_pagar.data_pagar = '" . mysqli_real_escape_string($connection, $paymentDate) . "'";
}
// echo $query;
$results = mysqli_query($connection, $query);

function createRegister($id , $date, $amount, $connection){
    try{
        $register = "INSERT INTO tbl_conta_pagar (id_empresa, data_pagar, valor)
        VALUES ('$id', '$date', '$amount')";
        mysqli_query($connection, $register);
    }
    catch(Exception $e){
        echo "error";
    }
}

function updateRegister($is_payed,$date, $amount,$id_register, $connection){
    try{
        $register = "UPDATE tbl_conta_pagar
        SET  data_pagar ='$date' , valor = '$amount', pago = '$is_payed'
        WHERE id_conta_pagar = '$id_register'";
        mysqli_query($connection, $register);
    }
    catch(Exception $e){
        echo "error";
    }
}

function deleteRegister($id_register, $connection){
    try{
        $register = "DELETE FROM tbl_conta_pagar
        WHERE id_conta_pagar = $id_register";
        mysqli_query($connection, $register);
    }
    catch(Exception $e){
        echo $e;
    }
}

function pay($id, $connection) {
    try {
        $register = "SELECT * FROM tbl_conta_pagar WHERE id_conta_pagar = $id";
        $result = mysqli_query($connection, $register);

        if (!$result || mysqli_num_rows($result) == 0) {
            throw new Exception("Registro não encontrado.");
        }

        $row = mysqli_fetch_assoc($result);
        $data_pagar = $row['data_pagar'];
        $valor_atual = $row['valor'];

        $data_atual_datetime = new DateTime();
        $data_pagar_datetime = new DateTime($data_pagar);

        if ($data_atual_datetime < $data_pagar_datetime) {
            $valor_final = $valor_atual * 0.95;
        } elseif ($data_atual_datetime > $data_pagar_datetime) {
            $valor_final = $valor_atual * 1.10;
        } else {
            $valor_final = $valor_atual;
        }

        $pay = "UPDATE tbl_conta_pagar
                SET pago = 1, valor = $valor_final
                WHERE id_conta_pagar = $id";

        if (!mysqli_query($connection, $pay)) {
            throw new Exception("Erro ao atualizar o registro: " . mysqli_error($connection));
        }
        
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}