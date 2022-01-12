<?php


namespace App\Http\Controllers\api;


use App\Http\Controllers\api\DigitoVerificador\DVPaynet;
use App\Http\Controllers\Controller;
use Codedge\Fpdf\Fpdf\Fpdf;

class PredialPDF extends Controller
{
    public function paynet(){
        //dump("paynet");
        $expediente = @$_POST["expediente"];
        $adeudo = PredialModel::getEstadoCuenta($expediente);
        //print_r($adeudo); die();
        $fecha = $adeudo->venceFecha;
        $totalAdeudo = $adeudo->totalAdeudo;
        
        
        /*if($adeudo->bonEnero > 0)
        {
            $totalAdeudo = $totalAdeudo - $adeudo->bonEnero;
        }*/
        
        
        $referencia = PredialModel::getReferenciaPaynet($expediente, $fecha, $totalAdeudo);

        $pdf = new Fpdf('P', 'cm', 'Letter');
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $pdf->AddFont('Verdana', '', 'verdana.php');
        $pdf->AddFont('Verdana', 'B', 'verdanab.php');

        $pdf->SetFont('Verdana', 'B', 11);

        $y = 1;

        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/logo-gpe.png')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/logo-gpe.png', 1, $y, 5, null);
        }

        $y += 0.2;
        $pdf->Text(15, $y, 'Servicio a Pagar');
        $y += 0.5;
        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/paynet_logo.png')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/paynet_logo.png', 15, $y, 3, null);
        } else {
            $pdf->Text(15, $y, 'PAYNET');
        }

        $y += 3;
        $pdf->SetFillColor(13, 150, 97);
        $pdf->Rect(1, $y, 0.6,1, 'F');


        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Fecha límite de pago'));
        $pdf->SetFont('Verdana', '', 9);
        $pdf->Text(2, $y + 1.1, utf8_decode(@$adeudo->vence));
        $pdf->Image('https://api.openpay.mx/barcode/'.$referencia.'.jpg', 2, $y + 1.3, 7);
        $pdf->SetFont('Verdana', '', 9);
        $pdf->Text(2, $y + 2.9, utf8_decode($referencia));
        $pdf->SetXY(2, $y + 3);
        $pdf->SetFont('Verdana', '', 6);
        $pdf->MultiCell(7, 0.3, utf8_decode('En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra.'));

        $pdf->Rect(10, $y, 10, 4, 'F');
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Verdana', 'B', 14);
        $pdf->Text(11, $y + 1, 'Total a pagar.');
        $pdf->SetFont('Verdana', 'B', 32);
        $pdf->SetXY(10, $y + 1.5);
        $pdf->Cell(7.5, 1, number_format($totalAdeudo,2), 0, 0, 'R');
        $pdf->SetFont('Verdana', 'B', 13);
        $pdf->MultiCell(1.5, 0.45, "\nMXN", 0, 'L');
        $pdf->Text(13.5, $y + 3.2, utf8_decode('+8 pesos de comisión'));

        $pdf->SetTextColor(0,0,0);
        $y += 5;
        $pdf->Rect(1, $y, 0.6,1, 'F');
        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Detalle del pago'));

        $y += 1.5;
        $pdf->SetXY(1, $y);
        $pdf->SetFont('Verdana', '', 10);
        $pdf->SetFillColor(243, 243, 243);
        $pdf->SetDrawColor(255, 255, 255);
        $pdf->SetLineWidth(0.1);
        $pdf->Cell(9.5, 1, utf8_decode(' Descripción'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, utf8_decode(' IMPUESTO PREDIAL'), 'L', 0, 'L', true);
        $y += 1;
        $pdf->SetFillColor(235, 235, 235);
        $pdf->SetXY(1, $y);
        $pdf->Cell(9.5, 1, utf8_decode(' Fecha límite'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, date(" d/m/Y", strtotime($fecha)), 'L', 0, 'L', true);
        $pdf->SetFillColor(243, 243, 243);
        $y += 1;
        $pdf->SetXY(1, $y);
        $pdf->Cell(9.5, 1, utf8_decode(' Referencia'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, " ".$expediente, 'L', 0, 'L', true);

        $y += 1.8;
        $pdf->SetFillColor(13, 150, 97);
        $pdf->Rect(1, $y, 0.6,1, 'F');
        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Como realizar el pago.'));

        $pdf->Text(11, $y + 0.6, utf8_decode('Instrucciones para el cajero'));

        $text1 = "1. Acude a cualquier tienda afiliada\n";
        $text1 .= "2. Entrega al cajero el código de barras y menciona que realizarás un pago de servicio Paynet\n";
        $text1 .= "3. Realizar el pago en efectivo por $ ".number_format($totalAdeudo)." MXN (más $8 pesos por comisión)\n";
        $text1 .= "4. Conserva el ticket para cualquier aclaración\n";
        $text1 .= "5. El pago se reflejará 96 horas despues de realizarlo.\n";
        $text1 .= "\n\n Si tienes dudas comunicate a Municipio de Guadalupe al teléfono (81) 8007-6500";

        $text2 = "1. Ingresar al menú de Pago de Servicios\n";
        $text2 .= "2. Seleccionar Paynet\n";
        $text2 .= "3. Escanear el código de barras o ingresar el núm. de referencia\n";
        $text2 .= "4. Ingresa la cantidad total a pagar\n";
        $text2 .= "5. Cobrar al cliente el monto total más la comisión de $8 pesos\n";
        $text2 .= "6. Confirmar la transacción y entregar el ticket al cliente\n";
        $text2 .= "\n Para cualquier duda sobre como cobrar, por favor llamar al teléfono 01 800 300 08 08 en un horario de 8am a 9pm de lunes a domingo";

        $y += 1.5;
        $pdf->SetXY(1.7, $y);
        $pdf->SetFont('Verdana', '', 8);
        $pdf->MultiCell(8.5, 0.4, utf8_decode($text1), 0, 'L');
        $pdf->SetXY(11, $y);
        $pdf->MultiCell(8.5, 0.4, utf8_decode($text2), 0, 'L');

        $y = 25;
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.02);
        $pdf->Line(1, $y, 20, $y);
        $y += 0.2;
        if (is_file($_SERVER["DOCUMENT_ROOT"]. '/7eleven.png')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/7eleven.png', 2, $y, null, 1);
        }

        if (is_file($_SERVER["DOCUMENT_ROOT"]. '/extra.png')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/extra.png', 3.5, $y, null, 1);
        }

        if (is_file($_SERVER["DOCUMENT_ROOT"]. '/farmacia_ahorro.png')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/farmacia_ahorro.png', 7.2, $y, null, 1);
        }

        if (is_file($_SERVER["DOCUMENT_ROOT"]. '/benavides.png')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/benavides.png', 10.2, $y, null, 1);
        }

        $pdf->SetFont('Verdana', '', 6);
        $pdf->Text(16, $y + 0.5, utf8_decode('¿Quieres pagar en otras tiendas?'));
        $pdf->Text(16, $y + 0.8, utf8_decode('visita: www.openpay.mx/tiendas'));


        $fecha = date("YmdHis");
        $archivo ='./tmp/' . md5($expediente . $fecha) . ".pdf";
        $pdf->Output('F', $archivo);

        echo asset('tmp/' . md5($expediente . $fecha) . ".pdf");
    }
    
    
    
    
    
    
    public function oxxo(){
        $expediente = @$_POST["expediente"];
        $adeudo = PredialModel::getEstadoCuenta($expediente);
        //print_r($adeudo); die();
        $fecha = $adeudo->venceFecha;
        $totalAdeudo = $adeudo->totalAdeudo;
        
        /*if($adeudo->bonEnero > 0)
        {
            $totalAdeudo = $totalAdeudo - $adeudo->bonEnero;
        }*/
        
        $referencia = PredialModel::getReferenciaOxxo($expediente, $fecha, $totalAdeudo);
        if(!$referencia)
        {
            return response('EXPEDIENTE INVALIDO, FAVOR DE COMUNICARSE CON TESORERIA MUNICIPAL', 500);
        }

        $pdf = new Fpdf('P', 'cm', 'Letter');
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $pdf->AddFont('Verdana', '', 'verdana.php');
        $pdf->AddFont('Verdana', 'B', 'verdanab.php');

        $pdf->SetFont('Verdana', 'B', 11);

        $y = 1;

        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/logo-gpe.png')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/logo-gpe.png', 1, $y, 5, null);
        }

        $y += 0.2;
        $pdf->Text(15, $y, 'Servicio a Pagar');
        $y += 0.5;
        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/logo-oxxo.jpg')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/logo-oxxo.jpg', 15, $y, 3, null);
        } else {
            $pdf->Text(15, $y, 'OXXO');
        }

        $y += 3;
        $pdf->SetFillColor(13, 150, 97);
        $pdf->Rect(1, $y, 0.6,1, 'F');


        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Fecha límite de pago'));
        $pdf->SetFont('Verdana', '', 9);
        $pdf->Text(2, $y + 1.1, utf8_decode(@$adeudo->vence));
        $imagen = 'http://www.barcodegenerator.online/barcode.asp?bc1='.$referencia.'&bc2=8&bc3=440&bc4=120&bc5=0&bc6=1&bc7=Arial&bc8=15&bc9=3';
        $imagen = 'https://api.openpay.mx/barcode/'.$referencia.'.jpg';
        //$pdf->Image('https://api.openpay.mx/barcode/'.$referencia.'.jpg', 2, $y + 1.3, 7);
        //echo $imagen; die();
        $pdf->Image($imagen, 2, $y + 1.3, 6, 1.2, 'JPG');
        $pdf->SetFont('Verdana', '', 9);
        $pdf->Text(2, $y + 2.9, utf8_decode($referencia));
        $pdf->SetXY(2, $y + 3);
        $pdf->SetFont('Verdana', '', 6);
        $pdf->MultiCell(7, 0.3, utf8_decode('En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra.'));

        $pdf->Rect(10, $y, 10, 4, 'F');
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Verdana', 'B', 14);
        $pdf->Text(11, $y + 1, 'Total a pagar');
        $pdf->SetFont('Verdana', 'B', 32);
        $pdf->SetXY(10, $y + 1.5);
        $pdf->Cell(7.5, 1, number_format($totalAdeudo,2), 0, 0, 'R');
        $pdf->SetFont('Verdana', 'B', 13);
        $pdf->MultiCell(1.5, 0.45, "\nMXN", 0, 'L');
        $pdf->Text(13.5, $y + 3.2, utf8_decode('+12 pesos de comisión'));

        $pdf->SetTextColor(0,0,0);
        $y += 5;
        $pdf->Rect(1, $y, 0.6,1, 'F');
        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Detalle del pago'));

        $y += 1.5;
        $pdf->SetXY(1, $y);
        $pdf->SetFont('Verdana', '', 10);
        $pdf->SetFillColor(243, 243, 243);
        $pdf->SetDrawColor(255, 255, 255);
        $pdf->SetLineWidth(0.1);
        $pdf->Cell(9.5, 1, utf8_decode(' Descripción'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, utf8_decode(' IMPUESTO PREDIAL'), 'L', 0, 'L', true);
        $y += 1;
        $pdf->SetFillColor(235, 235, 235);
        $pdf->SetXY(1, $y);
        $pdf->Cell(9.5, 1, utf8_decode(' Fecha límite'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, date(" d/m/Y", strtotime($fecha)), 'L', 0, 'L', true);
        $pdf->SetFillColor(243, 243, 243);
        $y += 1;
        $pdf->SetXY(1, $y);
        $pdf->Cell(9.5, 1, utf8_decode(' Referencia'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, " ".$expediente, 'L', 0, 'L', true);

        /*
        $y += 1;
        $pdf->SetXY(1, $y);
        $pdf->Cell(9.5, 1, utf8_decode(' Código'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, " ".$referencia, 'L', 0, 'L', true);
        */

        $y += 1.8;
        $pdf->SetFillColor(13, 150, 97);
        $pdf->Rect(1, $y, 0.6,1, 'F');
        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Como realizar el pago'));

        $pdf->Text(11, $y + 0.6, utf8_decode('Instrucciones para el cajero'));

        $text1 = "1. Acude a cualquier tienda afiliada\n";
        $text1 .= "2. Entrega al cajero el código de barras y menciona que realizarás un pago de servicio\n";
        $text1 .= "3. Realizar el pago en efectivo por $ ".number_format($totalAdeudo)." MXN\n";
        $text1 .= "4. Conserva el ticket para cualquier aclaración\n";
        $text1 .= "5. El pago se reflejará 96 horas despues de realizarlo.\n";
        $text1 .= "\n\n Si tienes dudas comunicate a Municipio de Guadalupe al teléfono (81) 8007-6500";

        $text2 = "1. Ingresar al menú de Pago de Servicios\n";
        $text2 .= "2. Escanear el código de barras o ingresar el núm. de referencia\n";
        $text2 .= "3. Ingresa la cantidad total a pagar\n";
        $text2 .= "4. Confirmar la transacción y entregar el ticket al cliente\n";
        //$text2 .= "\n Para cualquier duda sobre como cobrar, por favor llamar al teléfono 01 800 300 08 08 en un horario de 8am a 9pm de lunes a domingo";

        $y += 1.5;
        $pdf->SetXY(1.7, $y);
        $pdf->SetFont('Verdana', '', 8);
        $pdf->MultiCell(8.5, 0.4, utf8_decode($text1), 0, 'L');
        $pdf->SetXY(11, $y);
        $pdf->MultiCell(8.5, 0.4, utf8_decode($text2), 0, 'L');

        $y = 25;
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.02);
        $pdf->Line(1, $y, 20, $y);


        $fecha = date("YmdHis");
        $archivo ='./tmp/' . md5($expediente . $fecha) . ".pdf";
        $pdf->Output('F', $archivo);

        echo asset('tmp/' . md5($expediente . $fecha) . ".pdf");
    }
    
    
    
    
    
    
    public function azteca(){
        $expediente = @$_POST["expediente"];
        $adeudo = PredialModel::getEstadoCuenta($expediente);
        //print_r($adeudo); die();
        $fecha = $adeudo->venceFecha;
        $totalAdeudo = $adeudo->totalAdeudo;
        
        
        /*if($adeudo->bonEnero > 0)
        {
            $totalAdeudo = $totalAdeudo - $adeudo->bonEnero;
        }*/
        
        
        $referencia = PredialModel::getReferenciaBancoAzteca($expediente, $fecha, $totalAdeudo);
        if(!$referencia)
        {
            return response('EXPEDIENTE INVALIDO, FAVOR DE COMUNICARSE CON TESORERIA MUNICIPAL', 500);
        }

        $pdf = new Fpdf('P', 'cm', 'Letter');
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $pdf->AddFont('Verdana', '', 'verdana.php');
        $pdf->AddFont('Verdana', 'B', 'verdanab.php');

        $pdf->SetFont('Verdana', 'B', 11);

        $y = 1;

        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/logo-gpe.png')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/logo-gpe.png', 1, $y, 5, null);
        }

        $y += 0.2;
        $pdf->Text(15, $y, 'Servicio a Pagar');
        $y += 0.5;
        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/logo_azteca.jpg')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/logo_azteca.jpg', 13.4, $y, 3, null);
        } else {
            $pdf->Text(15, $y, 'Banco Azteca');
        }

        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/logo_elektra.jpg')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/logo_elektra.jpg', 16.6, $y+0.2, 3, null);
        }

        $y += 3;
        $pdf->SetFillColor(13, 150, 97);
        $pdf->Rect(1, $y, 0.6,1, 'F');


        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Fecha límite de pago'));
        $pdf->SetFont('Verdana', '', 9);
        $pdf->Text(2, $y + 1.1, utf8_decode(@$adeudo->vence));
        //$imagen = 'http://www.barcodegenerator.online/barcode.asp?bc1='.$referencia.'&bc2=8&bc3=440&bc4=120&bc5=0&bc6=1&bc7=Arial&bc8=15&bc9=3';
        $imagen = 'https://api.openpay.mx/barcode/'.$referencia.'.jpg';
        //echo $imagen; die();
        $pdf->Image($imagen, 2, $y + 1.3, 6, 1.2, 'JPG');
        $pdf->SetFont('Verdana', '', 9);
        $pdf->Text(2, $y + 2.9, utf8_decode($referencia));
        $pdf->SetXY(2, $y + 3);
        $pdf->SetFont('Verdana', '', 6);
        $pdf->MultiCell(7, 0.3, utf8_decode('En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra.'));

        $pdf->Rect(10, $y, 10, 4, 'F');
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Verdana', 'B', 14);
        $pdf->Text(11, $y + 1, 'Total a pagar');
        $pdf->SetFont('Verdana', 'B', 32);
        $pdf->SetXY(10, $y + 1.5);
        $pdf->Cell(7.5, 1, number_format($totalAdeudo,2), 0, 0, 'R');
        $pdf->SetFont('Verdana', 'B', 13);
        $pdf->MultiCell(1.5, 0.45, "\nMXN", 0, 'L');
        //$pdf->Text(13.5, $y + 3.2, utf8_decode('+8 pesos de comisión'));

        $pdf->SetTextColor(0,0,0);
        $y += 5;
        $pdf->Rect(1, $y, 0.6,1, 'F');
        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Detalle del pago'));

        $y += 1.5;
        $pdf->SetXY(1, $y);
        $pdf->SetFont('Verdana', '', 10);
        $pdf->SetFillColor(243, 243, 243);
        $pdf->SetDrawColor(255, 255, 255);
        $pdf->SetLineWidth(0.1);
        $pdf->Cell(9.5, 1, utf8_decode(' Descripción'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, utf8_decode(' IMPUESTO PREDIAL'), 'L', 0, 'L', true);
        $y += 1;
        $pdf->SetFillColor(235, 235, 235);
        $pdf->SetXY(1, $y);
        $pdf->Cell(9.5, 1, utf8_decode(' Fecha límite'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, date(" d/m/Y", strtotime($fecha)), 'L', 0, 'L', true);
        $pdf->SetFillColor(243, 243, 243);
        $y += 1;
        $pdf->SetXY(1, $y);
        $pdf->Cell(9.5, 1, utf8_decode(' Clave Catastral'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, " ".$expediente, 'L', 0, 'L', true);

        $y += 1.8;
        $pdf->SetFillColor(13, 150, 97);
        $pdf->Rect(1, $y, 0.6,1, 'F');
        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Como realizar el pago'));

        $pdf->Text(11, $y + 0.6, utf8_decode('Instrucciones para el cajero'));

        $text1 = "1. Acude a cualquier sucursal de Banco Azteca o Elektra\n";
        $text1 .= "2. Entrega al cajero el código de barras y menciona que realizarás un Deposito Azteca\n";
        $text1 .= "3. Realizar el pago en efectivo por $ ".number_format($totalAdeudo)." MXN\n";
        $text1 .= "4. Conserva el ticket para cualquier aclaración\n";
        $text1 .= "5. El pago se reflejará 96 horas despues de realizarlo.\n";
        $text1 .= "\n\n Si tienes dudas comunicate a Municipio de Guadalupe al teléfono (81) 8007-6500";

        $text2 = "1. Ingresar al menú Deposito Azteca\n";
        $text2 .= "2. Buscar al Emisor: MUNICIPIO DE GUADALUPE NL y selecciona el contrato 4782\n";
        $text2 .= "3. Ingresa la Referencia de 30 digitos que viene en el formato de pago\n";
        $text2 .= "4. Selecciona la Forma de Pago Efectivo y teclea el importe a pagar que viene en el formato de pago\n";
        //$text2 .= "\n Para cualquier duda sobre como cobrar, por favor llamar al teléfono 01 800 300 08 08 en un horario de 8am a 9pm de lunes a domingo";

        $y += 1.5;
        $pdf->SetXY(1.7, $y);
        $pdf->SetFont('Verdana', '', 8);
        $pdf->MultiCell(8.5, 0.4, utf8_decode($text1), 0, 'L');
        $pdf->SetXY(11, $y);
        $pdf->MultiCell(8.5, 0.4, utf8_decode($text2), 0, 'L');

        $y = 25;
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.02);
        $pdf->Line(1, $y, 20, $y);


        $fecha = date("YmdHis");
        $archivo ='./tmp/' . md5($expediente . $fecha) . ".pdf";
        $pdf->Output('F', $archivo);

        echo asset('tmp/' . md5($expediente . $fecha) . ".pdf");
    }

    public function hsbc(){
        $expediente = @$_POST["expediente"];
        $adeudo = PredialModel::getEstadoCuenta($expediente);
        //print_r($adeudo); die();
        $fecha = $adeudo->venceFecha;
        $totalAdeudo = $adeudo->totalAdeudo;
        //9797979797979797979797979797979797979797979797997
        

        //9797979797979797979797979797979797979797979797997

        /*if($adeudo->bonEnero > 0)
        {
            $totalAdeudo = $totalAdeudo - $adeudo->bonEnero;
        }*/
        
        
        $referencia = PredialModel::getReferenciaBancoHsbc($expediente, $fecha, $totalAdeudo);
        if(!$referencia)
        {
            return response('EXPEDIENTE INVALIDO, FAVOR DE COMUNICARSE CON TESORERIA MUNICIPAL', 500);
        }

        $pdf = new Fpdf('P', 'cm', 'Letter');
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $pdf->AddFont('Verdana', '', 'verdana.php');
        $pdf->AddFont('Verdana', 'B', 'verdanab.php');

        $pdf->SetFont('Verdana', 'B', 11);

        $y = 1;

        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/logo-gpe.png')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/logo-gpe.png', 1, $y, 5, null);
        }

        $y += 0.2;
        $pdf->Text(15, $y, 'Servicio a Pagar');
        $y += 0.5;
        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/logo_hsbc.jpg')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/logo_hsbc.jpg', 13.4, $y, 3, null);
        } else {
            $pdf->Text(15, $y, 'Banco Hsbc');
        }

        if (is_file($_SERVER["DOCUMENT_ROOT"] . '/logo_elektra.jpg')) {
            $pdf->Image($_SERVER["DOCUMENT_ROOT"] . '/logo_elektra.jpg', 16.6, $y+0.2, 3, null);
        }

        $y += 3;
        $pdf->SetFillColor(13, 150, 97);
        $pdf->Rect(1, $y, 0.6,1, 'F');


        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Fecha límite de pago'));
        $pdf->SetFont('Verdana', '', 9);
        $pdf->Text(2, $y + 1.1, utf8_decode(@$adeudo->vence));
        //$imagen = 'http://www.barcodegenerator.online/barcode.asp?bc1='.$referencia.'&bc2=8&bc3=440&bc4=120&bc5=0&bc6=1&bc7=Arial&bc8=15&bc9=3';
        $imagen = 'https://api.openpay.mx/barcode/'.$referencia.'.jpg';
        //echo $imagen; die();
        $pdf->Image($imagen, 2, $y + 1.3, 6, 1.2, 'JPG');
        $pdf->SetFont('Verdana', '', 9);
        $pdf->Text(2, $y + 2.9, utf8_decode($referencia));
        $pdf->SetXY(2, $y + 3);
        $pdf->SetFont('Verdana', '', 6);
        $pdf->MultiCell(7, 0.3, utf8_decode('En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra.'));

        $pdf->Rect(10, $y, 10, 4, 'F');
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Verdana', 'B', 14);
        $pdf->Text(11, $y + 1, 'Total a pagar');
        $pdf->SetFont('Verdana', 'B', 32);
        $pdf->SetXY(10, $y + 1.5);
        $pdf->Cell(7.5, 1, number_format($totalAdeudo,2), 0, 0, 'R');
        $pdf->SetFont('Verdana', 'B', 13);
        $pdf->MultiCell(1.5, 0.45, "\nMXN", 0, 'L');
        //$pdf->Text(13.5, $y + 3.2, utf8_decode('+8 pesos de comisión'));

        $pdf->SetTextColor(0,0,0);
        $y += 5;
        $pdf->Rect(1, $y, 0.6,1, 'F');
        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Detalle del pago'));

        $y += 1.5;
        $pdf->SetXY(1, $y);
        $pdf->SetFont('Verdana', '', 10);
        $pdf->SetFillColor(243, 243, 243);
        $pdf->SetDrawColor(255, 255, 255);
        $pdf->SetLineWidth(0.1);
        $pdf->Cell(9.5, 1, utf8_decode(' Descripción'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, utf8_decode(' IMPUESTO PREDIAL'), 'L', 0, 'L', true);
        $y += 1;
        $pdf->SetFillColor(235, 235, 235);
        $pdf->SetXY(1, $y);
        $pdf->Cell(9.5, 1, utf8_decode(' Fecha límite'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, date(" d/m/Y", strtotime($fecha)), 'L', 0, 'L', true);
        $pdf->SetFillColor(243, 243, 243);
        $y += 1;
        $pdf->SetXY(1, $y);
        $pdf->Cell(9.5, 1, utf8_decode(' Clave Catastral'), 'R', 0, 'L', true);
        $pdf->Cell(9.5, 1, " ".$expediente, 'L', 0, 'L', true);

        $y += 1.8;
        $pdf->SetFillColor(13, 150, 97);
        $pdf->Rect(1, $y, 0.6,1, 'F');
        $pdf->SetFont('Verdana', 'B', 11);
        $pdf->Text(2, $y + 0.6, utf8_decode('Como realizar el pago'));

        $pdf->Text(11, $y + 0.6, utf8_decode('Instrucciones para el cajero'));

        $text1 = "1. Acude a cualquier sucursal de Banco Hsbc o Elektra\n";
        $text1 .= "2. Entrega al cajero el código de barras y menciona que realizarás un Deposito Hsbc\n";
        $text1 .= "3. Realizar el pago en efectivo por $ ".number_format($totalAdeudo)." MXN\n";
        $text1 .= "4. Conserva el ticket para cualquier aclaración\n";
        $text1 .= "5. El pago se reflejará 96 horas despues de realizarlo.\n";
        $text1 .= "\n\n Si tienes dudas comunicate a Municipio de Guadalupe al teléfono (81) 8007-6500";

        $text2 = "1. Ingresar al menú Deposito Hsbc\n";
        $text2 .= "2. Buscar al Emisor: MUNICIPIO DE GUADALUPE NL y selecciona el contrato 4782\n";
        $text2 .= "3. Ingresa la Referencia de 30 digitos que viene en el formato de pago\n";
        $text2 .= "4. Selecciona la Forma de Pago Efectivo y teclea el importe a pagar que viene en el formato de pago\n";
        //$text2 .= "\n Para cualquier duda sobre como cobrar, por favor llamar al teléfono 01 800 300 08 08 en un horario de 8am a 9pm de lunes a domingo";

        $y += 1.5;
        $pdf->SetXY(1.7, $y);
        $pdf->SetFont('Verdana', '', 8);
        $pdf->MultiCell(8.5, 0.4, utf8_decode($text1), 0, 'L');
        $pdf->SetXY(11, $y);
        $pdf->MultiCell(8.5, 0.4, utf8_decode($text2), 0, 'L');

        $y = 25;
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.02);
        $pdf->Line(1, $y, 20, $y);


        $fecha = date("YmdHis");
        $archivo ='./tmp/' . md5($expediente . $fecha) . ".pdf";
        $pdf->Output('F', $archivo);

        echo asset('tmp/' . md5($expediente . $fecha) . ".pdf");
    }
}