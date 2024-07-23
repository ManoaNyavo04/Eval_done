<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\V_classement_equipe;

class ExportPdf_controller extends Controller
{
    public function getVainqueur(){
        $vainc = V_classement_equipe::all()->first();

        return view('pdf.vainqueur', compact('vainc'));
    }

    public function exportPdf(){
        $vainc = V_classement_equipe::all()->first();

        $pdf = PDF::loadView('pdf.template_vainceur', compact('vainc'));
        return $pdf->download('vainqueur.pdf');

        // Charger la vue PDF avec les données actuelles
        /*$html = view('pdf.vainqueur', compact('vainc'))->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html); // Utilisez $html ici
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream("details_devis.pdf"); */
    }
}
