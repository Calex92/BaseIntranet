<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationsController extends Controller
{
    public function indexAction()
    {
        $applications = $this->getDoctrine()->getRepository("FrontAppBundle:Application")->findAll();

        return $this->render('FrontAppBundle:Applications:index.html.twig', array("applications" => $applications));
    }

    public function externalAccessAction($applicationId)
    {
        $key = "le exigue, Ou l'obese jury mur Fete l'hai volapuk, ane ex aequo au whist, otez ce voeu decu. Vieux pelage que  de boeuf au 
        wallon, de graphie en kit mais bref. Portez ce vieux whiskueux. Vif P DG mentor, exhibez la squaw jockey. Juge, flambez l'exquis 
        patchwork d'Yvon.Voyez ce jeu exquis wallon, de graphie en kit mais bref. Portez ce vieux whisky au juge blond qui fumephyr, 
        prefere les jattes de kiwis. Mon pauvre zebu ankylose choque eux whisky au juge bloois ton wagon jaune. Perchez dix, vingt woks. 
        Qu y flambe je ? Le moujik equipe de faux breitschwanz voyage. Kiwi fade";


        $length = 20;
        $today = date("m.y.d"); // e.g. "03.10.01"
        $key = substr(hash('md5', $key . $today), 0, $length); // Hash it

        return $this->redirect("http://vanina/external_access.php?login=acastelain&application=".$applicationId."&password=$key");
    }
}
