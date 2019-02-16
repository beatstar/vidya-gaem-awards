<?php
namespace App\Controller;

use App\Service\ConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\RouterInterface;

class StaticController extends AbstractController
{
    public function indexAction(RouterInterface $router, ConfigService $configService)
    {
        $defaultPage = $configService->getConfig()->getDefaultPage();
        $defaultRoute = $router->getRouteCollection()->get($defaultPage);

        return $this->forward($defaultRoute->getDefault('_controller'), $defaultRoute->getDefaults());
    }

    public function videosAction()
    {
        return $this->render('videos.html.twig');
    }

    public function soundtrackAction()
    {
        $tracks = [
            ['if only - rook1e', '2B Award'],
            ['Nostalgia - Tobu', 'Peebee Award'],
            ['Pyres - Broken Elegance', 'Who Cares Award'],
            ['Flow is Overflowing (Instrumental) - My room Records', 'Make it Stop Award'],
            ['Henry\'s Monstrocity - Nelward', 'The Little Game that Could Award'],
            ['Habanera - Kevin Macleod', 'PIXEL5 R A4T Award'],
            ['BarkerHQ - TEAL MANDALA', 'Seal of Quality Award'],
            ['Finger 11 - Paralyzer', 'Newgrounds Award'],
            ['ParagoX9 - Choaz Fantasy', 'Newgrounds Award'],
            ['Hong Kong 97 Theme', 'Kamige Award'],
            ['Nowtro - Neon Marathon (Droid Bishop remix)', '/v/3 Award'],
            ['Changing Every Day', 'Tablet Mode Award'],
            ['想死个人的兵哥哥', '4K ULTRA HD 2160P RETINA DISPLAY Award'],
            ['Affectionate Land', 'Button Masher Award'],
            ['Shenmue II - Ohshu Soba', 'Press X to Win the Award'],
            ['Hua\'er', 'Hate Machine Award'],
            ['Dreamscape - 009 Sound System', 'Downward Spiral Award'],
            ['Why Do I have 6000 Followers - McMangos', 'Hyperbole Award'],
            ['Windows 98 Introductory Music', 'Windows 98 Award'],
            ['草帽丢了', 'Aniki Award'],
            ['A Sunny Day', 'Plot and Backstory Award'],
            ['Let Go - Glue70', 'Most Hated Award'],
            ['Bad Dreams - whyetc', 'Least Worst Award'],
        ];

        return $this->render('soundtrack.html.twig', [
            'tracks' => $tracks
        ]);
    }

    public function creditsAction()
    {
        return $this->render('credits.html.twig');
    }
}
