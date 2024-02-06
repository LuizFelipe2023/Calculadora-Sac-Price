<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Sac/Price</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Calculadora Sac/Price</h2>
        <form action="index.php" method="post" class="text-center">
            <div class="form-group">
                <label for="valor_emprestimo">Valor do Empréstimo:</label>
                <input type="text" class="form-control" id="valor_emprestimo" name="valor_emprestimo" required>
            </div>

            <div class="form-group">
                <label for="taxa_juros">Taxa de Juros (% ao ano):</label>
                <input type="text" class="form-control" id="taxa_juros" name="taxa_juros" required>
            </div>

            <div class="form-group">
                <label for="num_parcelas">Número de Parcelas:</label>
                <input type="text" class="form-control" id="num_parcelas" name="num_parcelas" required>
            </div>

            <div class="form-group">
                <label for="tipo_calculo">Tipo de Cálculo:</label>
                <select class="form-control" id="tipo_calculo" name="tipo_calculo" required>
                    <option value="sac">SAC</option>
                    <option value="price">Price</option>
                </select>
            </div>

            <button type="submit" name="calcular" class="btn btn-primary">Calcular</button>
        </form>

        <?php
        require 'funcoes_sac_price.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['valor_emprestimo'], $_POST['taxa_juros'], $_POST['num_parcelas'], $_POST['tipo_calculo'])) {
                if (empty($_POST['valor_emprestimo']) || empty($_POST['taxa_juros']) || empty($_POST['num_parcelas']) || empty($_POST['tipo_calculo'])) {
                    echo "<div class='alert alert-danger mt-4'>Preencha todos os campos!</div>";
                } else {
                    if ($_POST['tipo_calculo'] == 'sac') {
                        $resultado = calcularSac($_POST['valor_emprestimo'], $_POST['taxa_juros'], $_POST['num_parcelas']);
                    } elseif ($_POST['tipo_calculo'] == 'price') {
                        $resultado = calcularPrice($_POST['valor_emprestimo'], $_POST['taxa_juros'], $_POST['num_parcelas']);
                    }

                    if (isset($resultado)) {
                        echo "<div class='resultado mt-4'>";
                        echo "<h3 class='text-center'>Resultados para ".($_POST['tipo_calculo'] == 'sac' ? 'SAC' : 'PRICE')."</h3>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr>";
                        echo "<th scope='col'>Parcela</th>";
                        echo "<th scope='col'>Prestação Total</th>";
                        echo "<th scope='col'>Amortização</th>";
                        echo "<th scope='col'>Juros</th>";
                        echo "<th scope='col'>Saldo Devedor</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach ($resultado['prestacoes'] as $prestacao) {
                            echo "<tr>";
                            echo "<td>{$prestacao['parcela']}</td>";
                            echo "<td>R$ " . number_format($prestacao['prestacao_total'], 2, ',', '.') . "</td>";
                            echo "<td>R$ " . number_format($prestacao['amortizacao'], 2, ',', '.') . "</td>";
                            echo "<td>R$ " . number_format($prestacao['juros'], 2, ',', '.') . "</td>";
                            echo "<td>R$ " . number_format($prestacao['saldo_devedor'], 2, ',', '.') . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            }
        }
        ?>
    </div>
</body>

</html>
