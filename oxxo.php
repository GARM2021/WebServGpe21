
<?php
//print_r($_POST);
class DV {
	public function generate($ref) {
		$suma = $this->sumAllCharacters($ref, FALSE);
		$mod = ($suma % 10);
		if ($mod == 0) {
			return 0;
		} else {
			return (10 - $mod);
		}
	}
	
	protected function sumAllCharacters($ref, $hasVerificationDigit) {
		$suma = 0;
		$needsDoubleValue = !$hasVerificationDigit;
		for ($i = (strlen($ref) - 1); ($i >= 0); --$i) {
            //$valor = $this->getCharacterValue($ref->charAt($i));
			$valor = $this->getCharacterValue($ref{$i});
			$suma += $this->getValueToSum($valor, $needsDoubleValue);
			$needsDoubleValue = !$needsDoubleValue;
		}
		return $suma;
	}
	
	protected  function getValueToSum($valor, $doubleValue) {
		$sumando = (($doubleValue) ? (($valor * 2)) : $valor);
		if ($sumando > 9) {
			return ($sumando - 9);
		} else {
			return $sumando;
		}
	}
	
	protected function getCharacterValue ($currChar) {
		if ($currChar >= '0' && $currChar <= '9') {
			return $currChar - '0';
		} else if ($currChar == 'A' || $currChar == 'J') {
			return 1;
		} else if ($currChar == 'B' || $currChar == 'K' || $currChar == 'S') {
			return 2;
		} else if ($currChar == 'C' || $currChar == 'L' || $currChar == 'T') {
			return 3;
		} else if ($currChar == 'D' || $currChar == 'M' || $currChar == 'U') {
			return 4;
		} else if ($currChar == 'E' || $currChar == 'N' || $currChar == 'V') {
			return 5;
		} else if ($currChar == 'F' || $currChar == 'O' || $currChar == 'W') {
			return 6;
		} else if ($currChar == 'G' || $currChar == 'P' || $currChar == 'X') {
			return 7;
		} else if ($currChar == 'H' || $currChar == 'Q' || $currChar == 'Y') {
			return 8;
		} else if ($currChar == 'I' || $currChar == 'R' || $currChar == 'Z') {
			return 9;
		} else {
			return 0;
		}		
	}
	
	public function validate($ref) {
		$suma = $this->sumAllCharacters($ref, TRUE);
		return ((($suma % 10)) == 0);
	}
}


function generar_dv($codigo)
{
	$suma = 0;
	$size = strlen($codigo) - 1;
	$factor = 2;
	for($c = $size; $c >= 0; $c--)
	{
		$prod = $codigo{$c} * $factor;
		if ($prod > 9)
		{
			$prod -= 9;
		}

		$suma += $prod;
		$factor = ($factor == 2) ? 1 : 2;
	}

	$mod = ($suma % 10);
	if ($mod == 0) {
		$dv = 0;
	} else {
		$dv = (10 - $mod);
	}

	return $dv;
}

//$_POST["monto"] = "10.00";
//$_POST["fecha"] = date("Y-m-d", strtotime("+1 MONTH"));
$issuer = "9901";
//$issuer = "9501";
$expediente = @$_POST["expediente"]; //"2801010010";
if (strlen($expediente ) == 8 && substr($expediente, 0,2) != "28")
{
	$expediente = "28".$expediente;
}

if (strlen($expediente) <> 10)
{
	die($expediente . " EXPEDIENTE INVALIDO, FAVOR DE COMUNICARSE CON TESORERIA MUNICIPAL");
}

$fecha = date("Ymd", strtotime(@$_POST["fecha"]));
//echo $_POST["monto"];
$monto = $_POST["monto"];
$monto = number_format($monto, 2);
$monto = str_replace(",", "", $monto);
$armonto = explode(".", $monto);
if(count($armonto)>1)
{

    //print_r($armonto);
	$monto = $armonto[0].str_pad($armonto[1], 2, "0", STR_PAD_RIGHT);
} else {
	$monto = $monto.".00";
}

//echo "<br>$monto";
$monto = str_replace(".", "", $monto);
$monto = str_pad($monto, 7, "0", STR_PAD_LEFT);

$ref1 = $issuer.$expediente.$fecha.$monto;

$digitoverificador = new DV();
//$cv1 = $digitoverificador->generate($ref1);
$cv1 = generar_dv($ref1);
$referencia = $ref1.$cv1;

$montoreal = number_format($_POST["monto"],2);
$montoreal = str_replace(",", "", $montoreal);
$arm = explode(".", $montoreal);

?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Municipio de Guadalue</title>
	<link href="paynet/pago.css" rel="stylesheet" type="text/css">
</head>

<body onload='window.print()'>
	<!--<body>-->

		<div class="whitepaper">
			<div class="Header">
				<div class="Logo_empresa">
					<img src="paynet/logoguadalupe300.png" alt="Logo">
				</div>
				<div class="Logo_paynet">
					<div>PAGAR EN OXXO</div>
					<img src="Images/logo-oxxo.jpg" alt="Logo Oxxo">
				</div>
			</div>
			<div class="Data">
				<div class="Big_Bullet">
					<span></span>
				</div>
				<div class="col1">
					<h3>Fecha límite de pago</h3>
					<h4><?php echo $_POST["fecha"] ?>, a las 11:59 PM</h4>
					<!--<img width="300" src="http://www.barcodes4.me/barcode/i2of5/<?php echo $referencia; ?>.png?width=400&height=100&istextdrawn=0" alt="Código de Barras">-->
					<!--<img style="height: 1cm; width: 6cm;" src="http://bwipjs-api.metafloor.com/?bcid=code128&text=<?php echo $referencia; ?>" alt="Código de Barras">-->
					<!--<img width="300" src="http://generator.barcodetools.com/barcode.png?gen=0&data=<?php echo $referencia; ?>&bcolor=FFFFFF&fcolor=000000&tcolor=000000&fh=14&bred=0&w2n=2.5&xdim=2&w=&h=120&debug=1&btype=7&angle=0&quiet=1&balign=2&talign=0&guarg=1&text=0&tdown=0&stst=1&schk=0&cchk=1&ntxt=1&c128=0" alt="Código de Barras">-->
					<!--<img width="300" src="https://www.scandit.com/wp-content/themes/bridge-child/wbq_barcode_gen.php?symbology=code128&value=<?php echo $referencia; ?>&size=100&ec=L" alt="Código de Barras">-->
					<img style="height: 1cm; width: 6cm;" src="http://www.barcodegenerator.online/barcode.asp?bc1=<?php echo $referencia; ?>&bc2=8&bc3=440&bc4=120&bc5=0&bc6=1&bc7=Arial&bc8=15&bc9=3" alt="Código de Barras">


					<span><?php echo $referencia?></span>
					<small>En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra.</small>

				</div>
				<div class="col2">
					<h2>Total a pagar</h2>
					<h1><?php echo $arm[0] ?><span>.<?php echo $arm[1] ?></span><small> MXN</small></h1>
					<h2 class="S-margin"></h2>
				</div>
			</div>
			<div class="DT-margin"></div>
			<div class="Data">
				<div class="Big_Bullet">
					<span></span>
				</div>
				<div class="col1">
					<h3>Detalle del pago</h3>
				</div>
			</div>
			<div class="Table-Data">
				<div class="table-row color1">
					<div>Descripción</div>
					<span>IMPUESTO PREDIAL</span>
				</div>
				<div class="table-row color2">
					<div>Fecha l&iacute;mite</div>
					<span><?php echo $_POST["fecha"] ?></span>
				</div>
				<div class="table-row color1">
					<div>Referencia</div>
					<span><?php echo $expediente ?></span>
				</div>
				<div class="table-row color2"  style="display:none">
					<div>&nbsp;</div>
					<span>&nbsp;</span>
				</div>
				<div class="table-row color1" style="display:none">
					<div>&nbsp;</div>
					<span>&nbsp;</span>
				</div>
			</div>
			<div class="DT-margin"></div>
			<div>
				<div class="Big_Bullet">
					<span></span>
				</div>
				<div class="col1">
					<h3>Como realizar el pago</h3>
					<ol>
						<li>Acude a cualquier tienda afiliada</li>
						<li>Entrega al cajero el código de barras y menciona que realizarás un pago de servicio </li>
						<li>Realizar el pago en efectivo por $ <?php echo $montoreal ?>MXN</li>
						<li>Conserva el ticket para cualquier aclaración</li>
						<li>El pago se reflejará 96 horas despues de realizarlo.</li>
					</ol>
					<small>Si tienes dudas comunicate a Municipio de Guadalupe al teléfono (81) 8007-6500</small>
				</div>
				<div class="col1">
					<h3>Instrucciones para el cajero</h3>
					<ol>
						<li>Ingresar al menú de Pago de Servicios</li>
						<li>Escanear el código de barras o ingresar el núm. de referencia</li>
						<li>Ingresa la cantidad total a pagar</li>
						<li>Confirmar la transacción y entregar el ticket al cliente</li>
					</ol>
					<small>Para cualquier duda sobre como cobrar, por favor llamar al teléfono 01 800 300 08 08 en un horario de 8am a 9pm de lunes a domingo</small>
				</div>    
			</div>

			<div class="Powered">
				<!-- img src="images/powered_openpay.png" alt="Powered by Openpay" width="150" -->
			</div>




		</div>

	</body>
	</html>