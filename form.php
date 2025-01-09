<?php require_once('./dbconn.php');
$query = "
    SELECT * 
    FROM tbl_empresa
";
$companies = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Register</title>
</head>

<body>
    <div class="container">
        <form action="/form.php" method="post">
            <div class="field">
                <label for="">Companies</label>
                <select required name="companie" id="companie">
                    <?php 
                    foreach($companies as $companie){
                        // var_dump($companie);
                        echo "<option value=".$companie['id_empresa'].">".$companie['nome']."</option>"; // need to be a companie of databse
                    }
                    ?>
                </select>
            </div>
            <div class="field">
                <label for="">Date</label>
                <input required type="date" name="date" id="date">
            </div>
            <div class="field">
                <label>Amount</label>
                <input type="number" placeholder="0.00" required name="amount" min="0" value="0" step="0.01"
                    title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
            this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'
            ">
            </div>
            <div class="field">
                <button type="submit">Send</button>
            </div>

        </form>
        <div class="field">
            <a href="./table.php">All registers</a>
        </div>
    </div>
</body>

<?php 
if(sizeof($_POST) !=3 ){
    
}
else{
    var_dump($_POST);
    createRegister($_POST['companie'], DateTime::createFromFormat('Y-m-d', trim($_POST['date']))->format('Y-m-d'),$_POST['amount'],$connection);
}
?>

</html>