<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 4/15/18
 * Time: 23:14
 */

require __DIR__ . "/../vendor/autoload.php";

$link = "https://www.dropbox.com/s/e0sxjkhgqnl6idt/Document%20%281%29.docx?dl=1";
//$link = "https://www.dropbox.com/s/y691tiakfyh5k8l/themeforest-11989202-remark-responsive-bootstrap-4-admin-template.zip?dl=1";

//$link = "http://www.crea-sc.org.br/portal/lib/download-guia-manuais-formularios.php?id=45";
//$link = "http://www.voluntariado.org.br/sms/files/col_faca_parte_11.pdf";
//$link = "http://www.voluntariado.org.br/sms/files/Voluntariado%20%20e%20os%20ODS%20%20apresentações%20VNU%20%20Monica%20e%20Lola%20%20e%20CVSP%20Silvia.pdf";

$link = "http://www.pgq.ufrpe.br/sites/www.pgq.ufrpe.br/files/formulario_correcao_historico.pdf";
$link = "http://pdftags.com/ptview?t=COLET%C3%82NEA+DE+EXERC%C3%8DCIOS+DE+MEC%C3%82NICA+DOS+FLUIDOS+...&u=https%3A%2F%2Fedisciplinas.usp.br%2Fpluginfile.php%2F2876009%2Fmod_folder%2Fcontent%2F0%2FApostila%25201%2520%25E2%2580%2593%2520Propriedades%2520f%25C3%25ADsicas%2520dos%2520fluidos.pdf%3Fforcedownload%3D1";
//$link = "https://sites.google.com/site/termodinamicaaplicada32010/home/aulas/Apresenta%C3%A7%C3%A3o%20do%20Curso%202oQ2017_final.pdf?attredirects=0&d=1";

//$link = "https://lillizen.wordpress.com/exercises/";
$link = "https://www.ufca.edu.br/portal/files/formularios%20progep/CAD_ColaboraoTcnica.pdf";
$link = "https://www.ufca.edu.br/portal/files/PROGEP/CAP_Frias_1.pdf";
$link = "http://fisicadivertida.com.br/media/2015/07/a-fisica-analisa-o-filme-titanic.pdf";
$link = "http://www.ansr.pt/Contraordenacoes/Formularios/Documents/F301%20-%20Pedido%20de%20Certid%C3%A3o%20de%20Registo%20de%20Infra%C3%A7%C3%B5es%20do%20Condutor%202018.docx";
$link = "http://www.ansr.pt/Contraordenacoes/Formularios/Documents/F305%20-%20Apresentação%20de%20Defesa.docx";

$link = "http://anita.staff.gunadarma.ac.id/Downloads/files/41002/uji+non+parametrik.ppt";

$link = "https://galeazzi.jimdo.com/app/download/8921537369/HISTORIA+MÍNIMA+DE+LA+RADIO+EN+MÉXICO+%281920-1996%29.pdf?t=1438813385";

$start = microtime(true);

$type1 = \Dok123\FileTypeDetector\Detector::detectByContent( $link, false);

$error = error_get_last();print_r($error);var_dump($type1);die();

$end1 = microtime(true);

$type2 = \Dok123\FileTypeDetector\Detector::detectByContent(__DIR__. "/test005.ppt");


$end2 = microtime(true);

echo "Type 1 " . ($end1 - $start) . " \n";
print_r( $type1);
echo "\nType 2 " . ($end2 - $end1) . " \n";
print_r( $type2);

print_r(mime_content_type( __DIR__. "/test002.ppt"));
