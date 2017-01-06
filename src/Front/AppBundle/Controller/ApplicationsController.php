<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationsController extends Controller
{
    public function indexAction()
    {
        //$applications = $this->getDoctrine()->getRepository("FrontAppBundle:Application")->findAll();

        $key = "le exigue, Ou l'obese jury mur Fete l'hai volapuk, ane ex aequo au whist, otez ce voeu decu. Vieux pelage que  de boeuf au 
        wallon, de graphie en kit mais bref. Portez ce vieux whiskueux. Vif P DG mentor, exhibez la squaw jockey. Juge, flambez l'exquis 
        patchwork d'Yvon.Voyez ce jeu exquis wallon, de graphie en kit mais bref. Portez ce vieux whisky au juge blond qui fumephyr, 
        prefere les jattes de kiwis. Mon pauvre zebu ankylose choque eux whisky au juge bloois ton wagon jaune. Perchez dix, vingt woks. 
        Qu y flambe je ? Le moujik equipe de faux breitschwanz voyage. Kiwi fade";

        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);

        $length = 20;
        $today = date("m.y.d"); // e.g. "03.10.01"
        $key = substr(hash('md5', $key . $today), 0, $length); // Hash it
        $test = (file_get_contents("http://vanina/external_application.php?login=acastelain&password=$key"));
        $test = mb_convert_encoding($test, 'UTF-8',
            mb_detect_encoding($test, 'UTF-8, ISO-8859-1', true));

        var_dump(json_decode($test));
        exit;

        //return $this->redirect("http://vanina/external_application.php?login=acastelain&password=$key");

        //return $this->render('FrontAppBundle:Applications:index.html.twig', array("applications" => $applications));
    }

    public function externalAccessAction($applicationId)
    {
        $application = $this->getDoctrine()->getRepository("FrontAppBundle:ApplicationExternal")->find($applicationId);
        $key = "le exigue, Ou l'obese jury mur Fete l'hai volapuk, ane ex aequo au whist, otez ce voeu decu. Vieux pelage que  de boeuf au 
        wallon, de graphie en kit mais bref. Portez ce vieux whiskueux. Vif P DG mentor, exhibez la squaw jockey. Juge, flambez l'exquis 
        patchwork d'Yvon.Voyez ce jeu exquis wallon, de graphie en kit mais bref. Portez ce vieux whisky au juge blond qui fumephyr, 
        prefere les jattes de kiwis. Mon pauvre zebu ankylose choque eux whisky au juge bloois ton wagon jaune. Perchez dix, vingt woks. 
        Qu y flambe je ? Le moujik equipe de faux breitschwanz voyage. Kiwi fade";

        $length = 20;
        $today = date("m.y.d"); // e.g. "03.10.01"
        $key = substr(hash('md5', $key . $today), 0, $length); // Hash it

        return $this->redirect("http://vanina/external_access.php?login=acastelain&application=".$application->getUniqueIdentifier()."&password=$key");
    }
}
