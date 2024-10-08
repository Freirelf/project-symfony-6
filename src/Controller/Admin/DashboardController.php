<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Entity\NewsCategory;
use App\Entity\User;
use App\Repository\NewsCategoryRepository;
use App\Repository\NewsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private NewsRepository $newsRepository, private NewsCategoryRepository $newsCategoryRepository)
    {
    }

    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {   
        if($this->isGranted('ROLE_ADMIN')){
            return $this->render('admin/dashboard.html.twig',[
                'lastNews' => $this->newsRepository->findLastNews(),
                'bestCategories' => $this->newsCategoryRepository->findBestCategories(10),
            ]);
        } else {
            return $this->render('admin/dashboard.html.twig',[
                'lastNews' => $this->newsRepository->findLastNews(),
                'bestCategories' => $this->newsCategoryRepository->findBestCategories(5),
            ]);
        }

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Project Symfony 6');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-bars', NewsCategory::class);
        yield MenuItem::linkToCrud('Notices', 'fa fa-newspaper-o', News::class);
        yield MenuItem::linkToRoute('Send Email Personal', 'fa fa-envelope-o', 'app_send_mail_personal');
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()->add(Crud::PAGE_INDEX, Action::DETAIL); 
    }
}
