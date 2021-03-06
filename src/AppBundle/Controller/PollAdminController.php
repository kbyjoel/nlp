<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Poll\Poll;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/polls")
 */
class PollAdminController extends Controller
{
    /**
     * @Route("/list", name="admin_polls")
     */
    public function listPollAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        $polls = $em->getRepository('AppBundle:Poll\Election')->findAll();

        return $this->render('admin/poll/list.html.twig', array(
            'polls' => $polls,
        ));
    }
}
