<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Poll\Election;
use AppBundle\Entity\Poll\Candidacy;
use AppBundle\Form\Type\CandidacyType;

/**
 * @Route("/polls")
 */
class PollController extends Controller
{
    /**
     * @Route("/", name="polls")
     */
    public function listPollsAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_PROFILE_LOCKED')) {
            return $this->redirect($this->generateUrl('profile_validate'));
        }

        $criterias = array_merge_recursive(
            $this->get('app.election_ruler')->getCandidateCriterias($this->getUser()),
            $this->get('app.election_ruler')->getVoteCriterias($this->getUser())
        );

        $em = $this->getDoctrine()->getManager();

        $userElections = array();
        foreach ($criterias as $groupName => $criteriaGroup) {
            $result = $em->createQuery(
                'SELECT e
                FROM AppBundle:Poll\Election e
                WHERE e.openCandidacyDate < CURRENT_TIMESTAMP()
                AND e.closeDate > CURRENT_TIMESTAMP()
                AND e.group = :groupName
                AND e.criteria IN(:criteriaGroup)'
            )->setParameter('groupName', $groupName)
                ->setParameter('criteriaGroup', $criteriaGroup)
                ->getResult();

            if ($result) {
                $userElections = array_merge($userElections, $result);
            }
        }

        $otherPolls = $em->getRepository('AppBundle:Poll\Poll')->findAllCurrent();
        $otherElections = $em->getRepository('AppBundle:Poll\Election')->findAllCurrent();

        return $this->render('poll/list.html.twig', array(
            'userElections' => $userElections,
            'otherPolls' => $otherPolls,
            'otherElections' => $otherElections,
        ));
    }

    /**
     * @Route("/election/show/{id}", name="election_show")
     * @Security("is_granted('IS_PROFILE_LOCKED')")
     */
    public function showElectionAction(Election $election)
    {
        $voteNumber = $this->get('app.election_ruler')->getVoteNumber($this->getUser(), $election);

        return $this->render('poll/election_show.html.twig', array(
            'election' => $election,
            'voteNumber' => $voteNumber,
        ));
    }

    /**
     * @Route("/election/candidate/{id}", name="election_candidate")
     * @Security("is_granted('IS_PROFILE_LOCKED') && is_granted('ELECTION_CANDIDATE', election)")
     */
    public function doCandidateAction(Election $election, Request $request)
    {
        $user = $this->getUser();
        $candidacy = new Candidacy($election);
        $candidacy->setUser($user);

        $form = $this->createForm(new CandidacyType(), $candidacy);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidacy);
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('flash.candidacy.sent', array(), 'flash')
            );

            return $this->redirect($this->generateUrl('polls'));
        }

        return $this->render('poll/election_candidate.html.twig', array(
            'election' => $election,
            'form' => $form->createView(),
        ));
    }
}
