<?php

namespace App\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;





use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class QrcodeService
{
    /**
     * @var BuilderInterface
     */
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function qrcode($query,$qr,$img)
    {
       /* $url = 'https://www.google.com/search?q=';

        $objDateTime = new \DateTime('NOW');
        $dateString = $objDateTime->format('d-m-Y H:i:s');

        $path = dirname(__DIR__, 2).'/public/assets/';

        // set qrcode
        $result = $this->builder
            ->data($url.$query)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(400)
            ->margin(10)
            ->labelText($dateString)
            ->labelAlignment(new LabelAlignmentCenter())
            ->labelMargin(new Margin(15, 5, 5, 5))
            ->logoPath($path.'img/logo.png')
            ->logoResizeToWidth('100')
            ->logoResizeToHeight('100')
            ->backgroundColor(new Color(221, 158, 3))
            ->build()
        ;

        //generate name
        $namePng = uniqid('', '') . '.png';

        //Save img png
        $result->saveToFile($path.'qr-code/'.$namePng);

        return $result->getDataUri();*/

        $writer = new PngWriter();
        $path = dirname(__DIR__, 2).'/public/assets/';

// Create QR code
$qrCode = QrCode::create($qr)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

// Create generic logo
$logo = Logo::create($path.'img/abv.png')
    ->setResizeToWidth(50);

// Create generic label
$label = Label::create('Label')
    ->setTextColor(new Color(255, 0, 0));

$result = $writer->write($qrCode, $logo, $label);
//generate name
//$namePng = uniqid('', '') . '.png';
$namePng = $img.'.png';

//Save img png
$result->saveToFile($path.'qr-code/'.$namePng);


return  'qr-code/'.$namePng;

    }


    public function qrcode1($query,$qr,$img)
    {
       
        $writer = new PngWriter();
        $path = dirname(__DIR__, 2).'/public/assets/';

// Create QR code
$qrCode = QrCode::create($qr)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

// Create generic logo
$logo = Logo::create($path.'img/abv.png')
    ->setResizeToWidth(50);

// Create generic label
$label = Label::create('Hebergement')
    ->setTextColor(new Color(255, 0, 0));

$result = $writer->write($qrCode, $logo, $label);
//generate name
//$namePng = uniqid('', '') . '.png';
$namePng = $img.'.png';

//Save img png
$result->saveToFile($path.'qr-code/'.$namePng);


return  'qr-code/'.$namePng;

    }


}