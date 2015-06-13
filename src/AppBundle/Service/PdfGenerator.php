<?php

namespace AppBundle\Service;

use Exception;
use AppBundle\Service\NumberParser;
use AppBundle\Entity\Invoice;
use Appbundle\Entity\Organization;
use Appbundle\Entity\Subscription;
use DateInterval;

/**
*Class FactuurPDF
*/
class FactuurPDF extends \FPDF_FPDF {

  function Header() {
  	$this->setFillColor(205, 222, 255);
  	$this->Rect(175, 30, 25, 10, 'F');
  	$this->setFillColor(159, 207, 255);
  	$this->Rect(20, 10, 170, 25, 'F');
  	$this->setFillColor(0, 0, 0);
  	$this->setXY(90, 10);
  	$this->SetFont('Arial','I', 18);
  	$this->Cell(30, 10, 'Tijdschrift');
  	$this->setXY(75, 20);
  	$this->Cell(60, 10, 'voor Geneeskunde');
  	$this->setXY(40, 28);
  	$this->SetFont('Arial','', 9);
  	$this->Cell(130, 8, iconv('UTF-8', 'windows-1252','Gesticht door de Nederlandstalige medische faculteiten in België en hun alumniverenigingen'));
  }

  function Footer() {
  	//Gegevens TVG - bankrekeningnummer etc
  	$this->SetFont('Arial','', 12);
  	$this->setXY(20, 230);
  	$this->Cell(170, 5, 'i.o. prof. dr. J. Lauweryns');
  	$this->setXY(20, 235);
  	$this->Cell(170, 5, 'Leen Hernalsteen');
  	$this->setXY(20, 240);
  	$this->Cell(170, 5, 'Redactiemedewerker');
  	$this->setXY(20, 245);
  	$this->Cell(170, 5, 'IBAN: BE08 0000 4857 8913    BIC: BPOTBEB1');
  	$this->setXY(20, 250);
  	$this->Cell(170, 5, 'Niet onderworpen aan de bepalingen van de BTW');


  	//Contact info
  	$this->Line(20, 261, 190, 261);
  	$this->SetFont('Arial','', 11);
  	$this->SetTextColor(138, 138, 138);
  	$this->setXY(20, 262);
  	$this->Cell(170, 10, 'Minderbroedersstraat 12, 3000 LEUVEN    (Tel. 016/33.66.25 / Fax 016/33 66 24)    (info@tvg.be)');
  }

}

/**
*Class PdfGenerator
*/
class PdfGenerator{

	public function generateTransferForm($imagePath, $amount, $nameOrderer, $streetAddressOrderer, $municipalityAddressOrderer, $ibanReceiver, $bicReceiver, $nameReceiver, $streetAddressReceiver, $municipalityAddressReceiver, $ogm){
		$pdf  = new \FPDF_FPDF();

        $amountstring = sprintf("%.2f",$amount); 
        $strlenamount = strlen($amountstring);

        $amountY = 216;
        $nameOrdererY = 231;
        $streetAddressOrdererY = 235;
        $municipalityAddressOrdererY = 238.75;
        $ibanReceiverY = 246.75;
        $bicReceiverY = 254.75;
        $nameReceiverY = 261.75;
        $streetAddressReceiverY = 265.75;
        $municipalityAddressReceiverY = 269.75;
        $messageY = 277.5;


        $pdf->AddPage();
        $pdf->SetFont('Arial','B', 16);
        $pdf->Cell(190, 10, 'Betalingsinformatie tijdschrift voor geneesheren', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','', 14);
        $pdf->Write(5, 'Beste abonnee, hieronder vindt u de betalingsinformatie voor de betaling van uw abonnement. Van zodra wij uw betaling gecontroleerd hebben wordt uw nieuwe abonnement geactiveerd.');
        $pdf->Ln(20);
        $pdf->Write(5, 'Na activatie blijft uw abonnement 12 maanden geldig, u ontvangt dus 24 nummers van het magazine.');
        $pdf->Ln(20);
        $pdf->Write(5, 'Dit overschrijvingsformulier kan NIET gepost worden naar de bank.');


        $pdf->SetFont('Arial','B', 13);

        $pdf->Image($imagePath . 'overschrijvingsformulier.png', 10, 190, 190, 90);

        //BEDRAG
        //veld tienduizendtallen
        if(strlen($amountstring) > 7) $pdf->Text(161.25, $amountY, $amountstring{$strlenamount -8});
        //veld duizendtallen
        if(strlen($amountstring) > 6) $pdf->Text(165.75, $amountY, $amountstring{$strlenamount -7});
        //veld honderdtallen
        if(strlen($amountstring) > 5) $pdf->Text(170.50, $amountY, $amountstring{$strlenamount -6});
        //veld tientallen
        if(strlen($amountstring) > 4) $pdf->Text(175.25, $amountY, $amountstring{$strlenamount -5});
        //veld pdf
        $pdf->Text(180.0, $amountY, $amountstring{$strlenamount -4});
        //veld tienden
        $pdf->Text(188.75, $amountY, $amountstring{$strlenamount -2});
        //veld honderdsten
        $pdf->Text(193.5, $amountY, $amountstring{$strlenamount -1});

        //NAAM KLANT
        $pdf->SetFont('Arial','', 11);
        for($i = 0; $i < min(26,strlen($nameOrderer)); $i++){
            $pdf->Text(42 + 4.575 * $i, $nameOrdererY, $nameOrderer{$i});
        }
        //STRAAT KLANT
        for($i = 0; $i < min(26,strlen($streetAddressOrderer)); $i++){
            $pdf->Text(42 + 4.575 * $i, $streetAddressOrdererY, $streetAddressOrderer{$i});
        }
        //GEMEENTE KLANT
        for($i = 0; $i < min(26,strlen($municipalityAddressOrderer)); $i++){
            $pdf->Text(42 + 4.575 * $i, $municipalityAddressOrdererY, $municipalityAddressOrderer{$i});
        }
        //IBAN TVG
        $pdf->SetFont('Arial','', 14);
        for($i = 0; $i < 16; $i++){
            $pdf->Text(41.5 + 4.575 * $i, $ibanReceiverY, $ibanReceiver{$i});
        }

         //BIC TVG
        $pdf->SetFont('Arial','', 14);
        for($i = 0; $i < 8; $i++){
            $pdf->Text(41.5 + 4.575 * $i, $bicReceiverY, $bicReceiver{$i});
        }

        //NAAM TVG
        $pdf->SetFont('Arial','', 11);
        for($i = 0; $i < min(26,strlen($nameReceiver)); $i++){
            $pdf->Text(42 + 4.575 * $i, $nameReceiverY, $nameReceiver{$i});
        }
        //STRAAT TVG
        for($i = 0; $i < min(26,strlen($streetAddressReceiver)); $i++){
            $pdf->Text(42 + 4.575 * $i, $streetAddressReceiverY, $streetAddressReceiver{$i});
        }
        //GEMEENTE TVG
        for($i = 0; $i < min(26,strlen($municipalityAddressReceiver)); $i++){
            $pdf->Text(42 + 4.575 * $i, $municipalityAddressReceiverY, $municipalityAddressReceiver{$i});
        }

        //OGM
        // +kes
        $pdf->SetFont('Arial','', 14);
        $pdf->Text(41.5, $messageY,'+');
        $pdf->Text(46.25, $messageY,'+');
        $pdf->Text(50.25, $messageY,'+');

        //
        $pdf->Text(55.50, $messageY, $ogm{0});

        $pdf->Text(60.25, $messageY, $ogm{1});

        $pdf->Text(64.5, $messageY, $ogm{2});

        $pdf->Text(69.75, $messageY,'/');

        $pdf->Text(73.75, $messageY, $ogm{3});

        $pdf->Text(78.5, $messageY, $ogm{4});

        $pdf->Text(83, $messageY, $ogm{5});

        $pdf->Text(87.5, $messageY, $ogm{6});

        $pdf->Text(92.75, $messageY,'/');

        $pdf->Text(97, $messageY, $ogm{7});

        $pdf->Text(101.25, $messageY, $ogm{8});

        $pdf->Text(106, $messageY, $ogm{9});

        $pdf->Text(110.75, $messageY, $ogm{10});

        $pdf->Text(115.5, $messageY, $ogm{11});

        // +kes
        $pdf->Text(120.25, $messageY,'+');
        $pdf->Text(125, $messageY,'+');
        $pdf->Text(129.75, $messageY,'+');

        $pdf->Output();
	}

  /**
  * @param Invoice invoice
  */
  public function generateInvoicePdf($invoice){
    if(isset($invoice->getOrganization)){
      $subscriberNumbers = array();
      foreach ($invoice->getOrganization()->getSubscribers() as $subscriber) {
        array_push($subscriberNumbers, $subscriber->getId());
      }
      $this->generateOrganizationInvoice($invoice->getDate(), $invoice->getName(), $invoice->getStreet(), $invoice->getPostalCode() . " " . $invoice->getMunicipality(), $invoice->getvatNumber(), $invoice->getOrderNumber(), $invoice->getInvoiceNumber(), $subscriberNumbers, $invoice->getPrice(), $invoice->getDiscount(), $invoice->getOgm(), $output = "", $fileName = "");
    }else{
      $this->generateSubscriberInvoice($invoice->getDate(), $invoice->getName(), $invoice->getStreet(), $invoice->getPostalCode() . " " . $invoice->getMunicipality(), $invoice->getvatNumber(), $invoice->getOrderNumber(), $invoice->getInvoiceNumber(), $invoice->getSubscription()->getSubscriber()->getId(), $invoice->getPrice(), $invoice->getDiscount(), $invoice->getOgm(), $output = "", $filePath = "");
    }
  }

	public function generateSubscriberInvoice($date, $name, $streetAddress, $municipalityAddress, $vatNumber, $orderNumber, $invoiceNumber, $subscriberNumber, $price, $discount, $ogm, $output = "", $filePath = ""){
		$pdf = $this->generateInvoiceDefaults($date, $name, $streetAddress, $municipalityAddress, $vatNumber, $orderNumber, $invoiceNumber, 1, $price, $discount, $ogm);

		//Abonneenummer in geval het een abonnee is en geen organisatie
		$pdf->setXY(20, 80);
		$pdf->Cell(75, 5, 'Abonneenummer:    ' .  strval($subscriberNumber));
		if($output === "F"){
			if(!isset($output) || trim($output) === '') throw new Exception("Filepath can not be null or empty if you want to output the pdf to a file."); 
			$pdf->Output($filePath, "F");
		}else{
			$pdf->Output();
		}
	}

	public function generateOrganizationInvoice($date, $name, $streetAddress, $municipalityAddress, $vatNumber, $orderNumber, $invoiceNumber, $subscriberNumbers, $price, $discount, $ogm, $output = "", $fileName = ""){
		
		$numberOfSubscriptions = count($subscriberNumbers);
		$pdf = $this->generateInvoiceDefaults($name, $streetAddress, $municipalityAddress, $vatNumber, $orderNumber, $invoiceNumber, $numberOfSubscriptions, $price, $discount, $ogm);
		
		$pdf->AddPage();
		$pdf->SetFont('Arial','B', 16);
		$pdf->setXY(20, 45);
		$pdf->Cell(50, 10, 'Abonneenummers voor wie wordt betaald:');

		//Plaats en datum
		$pdf->SetFont('Arial','', 11);
		$pdf->setXY(20, 55);

		$subscribersString = '';
		foreach($subscriberNumbers as $subscriberNumber){
			$subscribersString .= strval($subscriberNumber) . ', ';
		}

		$subscribersString = substr($subscribersString, 0, -2) . '.';
		$pdf->Write(5, $subscribersString);

		if($output === "F"){
			if(!isset($output) || trim($output) === '') throw new Exception("Filepath can not be null or empty if you want to output the pdf to a file."); 
			$pdf->Output($filePath, "F");
		}else{
			$pdf->Output();
		}
	}

	private function generateInvoiceDefaults($date, $name, $streetAddress, $municipalityAddress, $vatNumber, $orderNumber, $invoiceNumber, $numberOfSubscriptions, $price, $discount, $ogm){

		if(strlen($name) > 35) $name = substr($name, 0, 35);
		if(strlen($streetAddress) > 35) $streetAddress = substr($streetAddress, 0, 35);
		if(strlen($municipalityAddress) > 35) $municipalityAddress = substr($municipalityAddress, 0, 35);

		$reductionTotal = 0.0;

		$pdf = new factuurPDF();
		$pdf->SetLeftMargin(20);
		$pdf->AddPage();
		//Titel
		$pdf->SetFont('Arial','B', 16);
		$pdf->setXY(20, 45);
		$pdf->Cell(50, 10, 'Factuur');

		//Plaats en datum
		$pdf->SetFont('Arial','', 11);
		$pdf->setXY(20, 55);
		$pdf->Cell(50, 10, 'Leuven, ' . date('d/m/Y', $date->getTimestamp()));

		//Gegevens klant
		$pdf->setXY(138, 47.5);
		$pdf->Cell(50, 5, $name, 0, 0, 'R');

		$pdf->setXY(138, 52.5);
		$pdf->Cell(50, 5, $streetAddress, 0, 0, 'R');

		$pdf->setXY(138, 57.5);
		$pdf->Cell(50, 5, $municipalityAddress, 0, 0, 'R');

		//Factuurnummer
		$pdf->setXY(20, 75);
		$pdf->Cell(75, 5, 'Factuurnummer:    ' .  strval($invoiceNumber));

		//Bestelbon nummer
		if($orderNumber !== ''){
			$pdf->setXY(86, 75);
			$pdf->Cell(50, 5, 'Bestelbon nummer:', 0, 0, 'R');

			$pdf->setXY(138, 75);
			$pdf->Cell(50, 5, $orderNumber, 0, 0, 'R');
		}
		//BTW nummer
		$pdf->setXY(86, $orderNumber !== '' ? 80 : 75);
		$pdf->Cell(50, 5, 'BTW of VAT nummer:', 0, 0, 'R');

		$pdf->setXY(138, $orderNumber !== '' ? 80 : 75);
		$pdf->Cell(50, 5, $vatNumber, 0, 0, 'R');

		//Ordergegevens
		$pdf->setXY(20, 95);
		$pdf->Cell(50, 5, 'Voor levering van:');

		//Headers
		//$pdf->setXY(120, 95);
		//$pdf->Cell(20, 5, 'Aantal');
		//$pdf->setXY(135, 95);
		//$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252','Prijs/stuk(€)'));

		$pdf->setXY(20, 100);
		$pdf->Cell(95, 5, strval($numberOfSubscriptions) . ' ' . ($numberOfSubscriptions > 1 ? 'abonnementen' : 'abonnement') . ' Tijdschrift voor Geneeskunde');

		$pdf->setXY(117, 100);
		$pdf->Cell(15, 5, strval($numberOfSubscriptions), 0, 0 , 'R');

		$pdf->setXY(133, 100);
		$pdf->Cell(5, 5, 'x', 0, 0 , 'R');

		$pdf->setXY(139, 100);
		$pdf->Cell(10, 5, strval($price), 0, 0 , 'R');

		$pdf->setXY(150, 100);
		$pdf->Cell(5, 5, '=', 0, 0 , 'R');

		$pdf->setXY(157, 100);
		$pdf->Cell(19, 5, sprintf("%.2f", $numberOfSubscriptions * $price), 0, 0 , 'R');

		$pdf->setXY(178, 100);
		$pdf->Cell(10, 5, 'EUR', 0, 0 , 'R');

		//Korting
		if($discount > 0){
			$reductionTotal = ($discount * $numberOfSubscriptions * $price) / 100.0;

			$pdf->setXY(117, 107);
			$pdf->Cell(32, 5, '-' . $discount . '% discount', 0, 0 , 'R');

			$pdf->setXY(150, 107);
			$pdf->Cell(5, 5, '=', 0, 0 , 'R');

			$pdf->setXY(157, 107);
			$pdf->Cell(19, 5, '- ' . sprintf("%.2f", $reductionTotal), 0, 0 , 'R');

			$pdf->setXY(178, 107);
			$pdf->Cell(10, 5, 'EUR', 0, 0 , 'R');
		}

		//Totaal
		$total = round(($numberOfSubscriptions * $price), 2) - round($reductionTotal, 2);

		$pdf->setXY(133, 114);
		$pdf->Cell(22, 5, 'TOTAAL', 0, 0 , 'R');

		$pdf->setXY(157, 114);
		$pdf->Cell(19, 5, sprintf("%.2f", $total), 0, 0 , 'R');

		$pdf->setXY(178, 114);
		$pdf->Cell(10, 5, 'EUR', 0, 0 , 'R');

		$numberParser = new NumberParser();
		$totalAsString = $numberParser->parseNumber($total);

		$pdf->setXY(20, 127);
		$pdf->Write(5, 'Voor waar en echt verklaard voor de som van ' . $totalAsString . ' euro.');

		//Mededelingen betaling

		$pdf->setXY(20, 147);
		$pdf->Cell(150, 5, 'Deze factuur dient betaald te worden ten laatste op ' . date('d/m/Y', date_add($date, DateInterval::createFromDateString('1 month'))->getTimestamp()) . '.');

		$pdf->setXY(20, 152);
		$pdf->Cell(150, 5, "Gelieve als gestructureerde mededeling '" . $ogm . "' te vermelden bij betaling.");

		return $pdf;
	}

}