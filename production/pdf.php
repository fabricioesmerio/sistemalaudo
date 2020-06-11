<?php 
require_once '../pdf/fpdf.php';
require_once '../Config/functions.php';
require_once '../DAO/StudyDAO.php';
require_once '../class/Study.php';

function prepareStringUtf($srt) {
    return iconv(mb_detect_encoding($srt), 'windows-1252', $srt);
}

if (isset($_GET['ref']) && $_GET['ref'] !== "") {

    $id = filter_input(INPUT_GET, 'ref', FILTER_SANITIZE_NUMBER_INT);

    $study = new Study();
    $studyDAO = new StudyDAO();
    $study = $studyDAO->getById($id);

    $pdf= new FPDF("P","pt","A4");
    
    $pdf->AddPage();
    $pdf->Image('../img/logo.jpeg', 28,10, 80);
    
    $title = "Hospital Santo Ângelo";
    $title = prepareStringUtf($title);
    
    $pdf->SetFont('arial','B',18);
    $pdf->SetTextColor(61,176,247);
    $pdf->Cell(0,55,$title,0,1,'C');
    $pdf->Cell(0,5,"","B",1,'C');
    $pdf->Ln(8);
    
    //nome
    $pdf->SetFont('arial','B',12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90,20,"Nome:",0,0,'R');
    $pdf->setFont('arial','',12);
    $nomePaciente = prepareStringUtf(str_replace(["^^^^"], "", $study->getNomePaciene()));
    $pdf->Cell(0,20,$nomePaciente,0,1,'L');
    
    //data
    $pdf->SetFont('arial','B',12);
    // $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90,20,"Data Exame:",0,0,'R');
    $pdf->setFont('arial','',12);
    $dataExame = date('d/m/Y H:i', strtotime($study->getStudy_datetime()));
    $pdf->Cell(0,20,$dataExame,0,1,'L');
    
    //tipo
    $pdf->SetFont('arial','B',12);
    // $pdf->SetTextColor(0,0,0);
    $pdf->Cell(90,20,"Tipo Exame:",0,0,'R');
    $pdf->setFont('arial','',12);
    $pdf->Cell(0,20,$study->getStudy_desc(),0,1,'L');
    
    //laudo
    $pdf->SetFont('arial','B',12);
    $pdf->Cell(90,20,"Laudo:",0,1,'R');
    $pdf->setFont('arial','',12);
    $laudo = prepareStringUtf($study->getLaudo_texto());
    $laudo = strip_tags($laudo);
    $pdf->ln(10);
    $pdf->MultiCell(0,20,$laudo,1,'J');
    
    $nameFile = $study->getStudy_desc() . "_" . $nomePaciente . '_' . date('d/m/Y', strtotime($study->getStudy_datetime()));
    // output
    $pdf->Output($nameFile . ".pdf","D");
}
