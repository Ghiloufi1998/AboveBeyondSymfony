<?php

namespace App\Controller;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PdfController extends AbstractController
{
    /**
     * @Route("/FacturePDF", name="app_pdf")
     */
    public function index(): Response
    {
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
        ]);
    }
    /**
     * @Route("/pdf", name="pdf")
     */
    public function AffichePDF(ReservationRepository $repository){

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled',true);

       // Instantiate Dompdf with our options
       $dompdf = new Dompdf($pdfOptions);
       $montant =$this->getDoctrine()->getRepository(Reservation::class)->showall();
       $detail =$this->getDoctrine()->getRepository(Reservation::class)->showdetail();
       $prix =$this->getDoctrine()->getRepository(Reservation::class)->showdetailVOl();
   //  dd($detail);
        // Retrieve the HTML generated in our twig file
        $html = $this->render('pdf/pdf.html.twig',
       ['montant'=> $montant,
       'details'=>$detail,
        'x'=>$prix,
       ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
      }

}
