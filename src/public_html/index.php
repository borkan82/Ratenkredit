<?php
require_once __DIR__ . '/../vendor/autoload.php';

$offers = [];
$submitted  = filter_input(INPUT_GET, 'submit') !== null;
$amount     = filter_input(INPUT_GET, 'amount', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);

if ($submitted && $amount !== false && $amount !== null) {
    $ratenkredit = new RatenKredit();
    $offers      = $ratenkredit->get($amount);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Offers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-style: italic;
        }
        th {
            background-color: #f2f2f2;
            color: green;
        }
    </style>
</head>
<body>
<h2>Ratenkredit</h2>
<form method="get">
    <input type="text" name="amount" value="<?= htmlspecialchars((string) ($_GET['amount'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" placeholder="$100" required>
    <input type="submit" name="submit" value="Check" />
</form>
<?php if ($submitted){ ?>
    <?php if ($amount === null || $amount === false){ ?>
        <p>Please enter a valid amount.</p>
    <?php } elseif ($offers === []){ ?>
        <p>No offers could be retrieved. Please try again later.</p>
    <?php } else { ?>
        <table>
            <tr>
                <th>Provider</th>
                <th>Interest rate</th>
                <th>Duration</th>
            </tr>
            <?php foreach ($offers as $providerKey => $offer){ ?>
                <tr>
                    <td><?= htmlspecialchars($providerKey, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars(number_format($offer, 2) . '%', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= $offer->durationMonths ?> months</td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
<?php } ?>
</body>
</html>