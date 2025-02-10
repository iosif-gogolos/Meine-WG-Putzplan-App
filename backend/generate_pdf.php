<?php
require_once('tcpdf/tcpdf.php');

// Beispiel: Abrufen von Putzplandaten aus der Datenbank
// Hier als Beispiel einfach ein statischer Inhalt
$calendarWeek = date('W');
$filename = "Putzplan_KW" . $calendarWeek . ".pdf";

// Erstelle ein neues PDF-Dokument
$pdf = new TCPDF();
$pdf->AddPage();

// Setze Farben gemäß deiner Farbpalette
// Hintergrundfarbe: #F2EFE7 (RGB: 242,239,231)
// Akzentfarbe: #2973B2 (RGB: 41,115,178)
$pdf->SetFillColor(242, 239, 231);
$pdf->SetTextColor(41, 115, 178);
$pdf->SetFont('helvetica', 'B', 16);

// Füge Titel hinzu
$html = '<h1>WG-Putzplan</h1>';
$html .= '<p>Putzplan für Kalenderwoche ' . $calendarWeek . '</p>';
// Hier kannst du weitere Inhalte (z.B. Tabellen mit Aufgaben) einfügen

$pdf->writeHTML($html, true, false, true, false, '');

// PDF-Ausgabe (Download)
$pdf->Output($filename, 'D');
?>
