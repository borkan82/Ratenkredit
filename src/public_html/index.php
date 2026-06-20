<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Ratenkredit;

$offers    = [];
$submitted = filter_input(INPUT_GET, 'submit') !== NULL;
$amount    = filter_input(INPUT_GET, 'amount', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);

// If form is submitted - Run all API requests to show table with data
if($submitted && $amount !== false && $amount !== NULL) {
    $errorMessage = NULL;

    try {
        // 1. Try to get the data
        $ratenkredit = new RatenKredit();
        $offers      = $ratenkredit->get($amount);
    } catch(RuntimeException $e) {
        // 2. Catch the exception and grab its message
        $errorMessage = $e->getMessage();
    }
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
    <input type="number" name="amount" min="1" step="1" value="<?= htmlspecialchars((string) ($_GET['amount'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" placeholder="100" required>
    <input type="submit" name="submit" value="Check" />
</form>
<?php
if (!empty($errorMessage)){
    echo "<p>$errorMessage</p>";
}

if ($submitted){ ?>
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
                    <td><?= htmlspecialchars(number_format($offer->interestRate, 2) . '%', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= $offer->durationMonths ?> months</td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
<?php } ?>
</body>
</html>