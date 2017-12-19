<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Action;
use AppBundle\Entity\Advertisement;
use AppBundle\Entity\TableHistory;
use AppBundle\Service\AuditService;
use AppBundle\Service\ConfigService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VGA\FileSystem;

class AdvertManagerController extends Controller
{
    public function indexAction(EntityManagerInterface $em)
    {
        $query = $em->createQueryBuilder();
        $adverts = $query
            ->select('a')
            ->from(Advertisement::class, 'a')
            ->indexBy('a', 'a.id')
            ->orderBy('a.special', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('advertManager.html.twig', [
            'adverts' => $adverts
        ]);
    }

    public function postAction(ConfigService $configService, Request $request, EntityManagerInterface $em, AuditService $auditService)
    {
        if ($configService->isReadOnly()) {
            return $this->json(['error' => 'The site is currently in read-only mode. No changes can be made.']);
        }

        $post = $request->request;
        $action = $post->get('action');

        if (!in_array($action, ['new', 'edit', 'delete'], true)) {
            return $this->json(['error' => 'Invalid action specified.']);
        }

        if ($action === 'new') {
            $advert = new Advertisement();
        } else {
            $advert = $em->getRepository(Advertisement::class)->find($post->get('id'));
            if (!$advert) {
                $this->json(['error' => 'Invalid advert specified.']);
            }
        }

        if ($action === 'delete') {
            $em->remove($advert);
            $auditService->add(
                new Action('advert-delete', $advert->getId())
            );
            $em->flush();

            return $this->json(['success' => true]);
        }

        if (strlen(trim($post->get('name', ''))) === 0) {
            return $this->json(['error' => 'You need to enter a name.']);
        }

        if (!filter_var($post->get('link', ''), FILTER_VALIDATE_URL)) {
            return $this->json(['error' => 'You need to enter a valid link.']);
        }

        $advert
            ->setName($post->get('name'))
            ->setLink($post->get('link'))
            ->setSpecial((bool)$post->get('special', false));

        $em->persist($advert);
        $em->flush();

        if ($request->files->get('image')) {
            if ($advert->getImage()) {
                FileSystem::deleteFile(
                    'memes',
                    sha1($advert->getName() . ' ' . $advert->getLink()) . substr($advert->getImage(), -4)
                );
            }

            try {
                $imagePath = FileSystem::handleUploadedFile(
                    $request->files->get('image'),
                    'memes',
                    sha1($advert->getName() . ' ' . $advert->getLink())
                );
            } catch (\Exception $e) {
                return $this->json(['error' => $e->getMessage()]);
            }

            $advert->setImage($imagePath);
            $em->persist($advert);
            $em->flush();
        }

        $auditService->add(
            new Action('advert-' . $action, $advert->getId()),
            new TableHistory(Advertisement::class, $advert->getId(), $post->all())
        );

        $em->flush();

        return $this->json(['success' => true]);
    }
}