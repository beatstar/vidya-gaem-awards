<?php
namespace VGA\Controllers;

use Moment\Moment;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use VGA\Model\Category;
use VGA\Model\Config;

class VotingController extends BaseController
{
    public function indexAction($category = null)
    {
        $tpl = $this->twig->loadTemplate('voting.twig');

        // Fetch all of the enabled categories
        $repo = $this->em->getRepository(Category::class);
        $query = $repo->createQueryBuilder('c', 'c.id');
        $query->select('c')
            ->where('c.enabled = true')
            ->orderBy('c.order', 'ASC');
        $categories = $query->getQuery()->getResult();

        // Fetch the active category (if given)
        if ($category) {
            /** @var Category $category */
            $category = $this->em->getRepository(Category::class)->find($category);

            if (!$category || !$category->isEnabled()) {
                $this->session->getFlashBag()->add('error', 'Invalid award specified.');
                $response = new RedirectResponse(
                    $this->generator->generate('voting', [], UrlGenerator::ABSOLUTE_URL)
                );
                $response->send();
                return;
            }
        }

        /** @var Config $config */
        $config = $this->em->getRepository(Config::class)->findOneBy([]);

        $start = $config->getVotingStart();
        $end = $config->getVotingEnd();

        $votingNotYetOpen = $config->isVotingNotYetOpen();
        $votingClosed = $config->hasVotingClosed();
        $votingOpen = $config->isVotingOpen();

        if ($votingNotYetOpen) {
            if (!$start) {
                $voteText = 'Voting will open soon.';
            } else {
                $voteText = 'Voting will open in ' . Config::getRelativeTimeString($start) . '.';
            }
        } elseif ($votingOpen) {
            if ($end) {
                $voteText = 'Voting is now open!';
            } else {
                $voteText = ' You have ' . Config::getRelativeTimeString($end) . ' left to vote.';
            }
        } else {
            $voteText = 'Voting is now closed.';
        }

        //////// TESTING ////////
        $time = $this->request->get('time');
        if ($time === 'before') {
            $votingNotYetOpen = true;
            $votingOpen = $votingClosed = false;
            $voteText = 'Voting will open soon.';
        } elseif ($time === 'after') {
            $votingClosed = true;
            $votingNotYetOpen = $votingOpen = false;
            $voteText = 'Voting is now closed.';
        } elseif ($time === 'during') {
            $votingOpen = true;
            $votingNotYetOpen = $votingClosed = false;
            $voteText = 'Voting is now open!';
        }
        //////// TESTING ////////

        $response = new Response($tpl->render([
            'title' => 'Voting',
            'categories' => $categories,
            'category' => $category,
            'votingNotYetOpen' => $votingNotYetOpen,
            'votingClosed' => $votingClosed,
            'votingOpen' => $votingOpen,
            'voteText' => $voteText,
        ]));
        $response->send();
    }
}
