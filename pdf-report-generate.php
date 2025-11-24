<?php
require __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// 1. Twig setup
$loader = new FilesystemLoader(__DIR__ . '/pdf-report-templates');
$twig = new Environment($loader);

// 2. Example data (in real ERP: fetch from MSSQL)
$data = [
    'invoice_number' => 'INV-2025-001',
    'customer' => 'XYZ Fabrics',
    'items' => [
        ['desc' => 'Cotton Shirt', 'qty' => 10, 'price' => 250],
        ['desc' => 'Silk Saree', 'qty' => 5, 'price' => 1200],
    ],
    'total' => 6250
];

// 3. Render HTML via Twig
$html = $twig->render('invoice.html', $data);

// 4. Send HTML to mPDF
// $mpdf = new Mpdf();
$mpdf = new \Mpdf\Mpdf([
    'format' => $templateRow['PageSize'] ?? 'A4',
    'orientation' => $templateRow['Orientation'] ?? 'P'
]);

$mpdf->WriteHTML($html);
$mpdf->Output('invoice.pdf', 'I');
