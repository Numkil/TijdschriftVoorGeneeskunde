<?php

namespace AppBundle\Service;

use Exception;

/**
*Class NumberParser
*/
class NumberParser{

	protected $_smallNumberMapping = array(
		0 => '',
		1 => 'een',
		2 => 'twee',
		3 => 'drie',
		4 => 'vier',
		5 => 'vijf',
		6 => 'zes',
		7 => 'zeven',
		8 => 'acht',
		9 => 'negen',
		10 => 'tien',
		11 => 'elf',
		12 => 'twaalf',
		13 => 'dertien',
		14 => 'veertien',
		15 => 'vijftien',
		16 => 'zestien',
		17 => 'zeventien',
		18 => 'achttien',
		19 => 'negentien',
		20 => 'twintig',
		21 => 'eenentwintig',
		22 => 'tweeëntwintig',
		23 => 'drieëntwintig',
		24 => 'vierentwintig',
		25 => 'vijfentwintig',
		26 => 'zesentwintig',
		27 => 'zevenentwintig',
		28 => 'achtentwintig',
		29 => 'negenentwintig',
		30 => 'dertig',
		31 => 'eenendertig',
		32 => 'tweeëndertig',
		33 => 'drieëndertig',
		34 => 'vierendertig',
		35 => 'vijfendertig',
		36 => 'zesendertig',
		37 => 'zevenendertig',
		38 => 'achtendertig',
		39 => 'negenendertig',
		40 => 'veertig',
		41 => 'eenenveertig',
		42 => 'tweeënveertig',
		43 => 'drieënveertig',
		44 => 'vierenveertig',
		45 => 'vijfenveertig',
		46 => 'zesenveertig',
		47 => 'zevenenveertig',
		48 => 'achtenveertig',
		49 => 'negenenveertig',
		50 => 'vijftig',
		51 => 'eenenvijftig',
		52 => 'tweeënvijftig',
		53 => 'drieënvijftig',
		54 => 'vierenvijftig',
		55 => 'vijfenvijftig',
		56 => 'zesenvijftig',
		57 => 'zevenenvijftig',
		58 => 'achtenvijftig',
		59 => 'negenenvijftig',
		60 => 'zestig',
		61 => 'eenenzestig',
		62 => 'tweeënzestig',
		63 => 'drieënzestig',
		64 => 'vierenzestig',
		65 => 'vijfenzestig',
		66 => 'zesenzestig',
		67 => 'zevenenzestig',
		68 => 'achtenzestig',
		69 => 'negenenzestig',
		70 => 'zeventig',
		71 => 'eenenzeventig',
		72 => 'tweeënzeventig',
		73 => 'drieënzeventig',
		74 => 'vierenzeventig',
		75 => 'vijfenzeventig',
		76 => 'zesenzeventig',
		77 => 'zevenenzeventig',
		78 => 'achtenzeventig',
		79 => 'negenenzeventig',
		80 => 'tachtig',
		81 => 'eenentachtig',
		82 => 'tweeëntachtig',
		83 => 'drieëntachtig',
		84 => 'vierentachtig',
		85 => 'vijfentachtig',
		86 => 'zesentachtig',
		87 => 'zevenentachtig',
		88 => 'achtentachtig',
		89 => 'negenentachtig',
		90 => 'negentig',
		91 => 'eenennegentig',
		92 => 'tweeënnegentig',
		93 => 'drieënnegentig',
		94 => 'vierennegentig',
		95 => 'vijfennegentig',
		96 => 'zesennegentig',
		97 => 'zevenennegentig',
		98 => 'achtennegentig',
		99 => 'negenennegentig'
	);

 	public function __construct(){}

	/**
	*@param takes a float value smaller than 1000 000 000 000
	*@return returns a string representing the number in full Dutch text
	*/
	public function parseNumber($number){
		if($number > 1000000000000) throw new Exception('Number must be smaller than 1000 000 000 000.');

		$result = '';

		if($number > 1000000000){
			$rest = fmod($number, 1000000000);
			$billions = ($number - $rest) / 1000000000;
			$number = $rest;
			$result .= $this->parseSmallNumber($billions) . ' miljard ';
		}

		if($number > 1000000){
			$rest = fmod($number, 1000000);
			$millions = ($number - $rest) / 1000000;
			$number = $rest;
			$result .= $this->parseSmallNumber($millions)  . ' miljoen ';
		}

		if($number >= 1000){
			$rest = fmod($number,1000);
			$thousands = ($number - $rest) / 1000;
			$number = $rest;
			if($thousands > 1) $result .= $this->parseSmallNumber($thousands);
			$result .= 'duizend ';
		}

		$rest = $number - intval($number);
		$number = $number - $rest;
		$result .= $this->parseSmallNumber($number);

		//honderdsten apart doen	
		if($rest > 0) $result .= ' en ' . $this->parseSmallNumber($rest * 100) . ' honderdsten';

		return trim($result);
	}

	/**
	*@param takes an integer value lower than 1000
	*@return returns a string representing the number in full Dutch text
	*/
	private function parseSmallNumber($smallNumber){
		if($smallNumber >= 1000) throw new Exception('Number must be smaller than 1000.');
		if($smallNumber < 100){
			return $this->_smallNumberMapping[$smallNumber];
		}
		$tenthsAndOnes = $smallNumber % 100;
		$hundreds = ($smallNumber - $tenthsAndOnes) / 100;
		return $this->_smallNumberMapping[$hundreds] . 'honderd' . $this->_smallNumberMapping[$tenthsAndOnes];
	}
}