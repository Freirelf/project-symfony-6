<?php

namespace App\Command;

use App\Entity\NewsCategory;
use App\Repository\NewsCategoryRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:add-categories',
    description: 'Add categories notice',
)]
class AddCategoriesCommand extends Command
{
    public function __construct(private NewsCategoryRepository $newsCategoryRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {   
        $io = new SymfonyStyle($input, $output);

        $allCategories = $this->newsCategoryRepository->findAll();
        
        if(sizeof($allCategories) > 0) {
            $io->warning('Categories already exists');
            exit;
        }

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Mundo');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Brasil');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Tecnologia');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Design');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Cultura');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Negócios');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Política');
        $this->newsCategoryRepository->save($newsCateory, true);
        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Opinião');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Ciência');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Saúde');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Estilo');
        $this->newsCategoryRepository->save($newsCateory, true);

        $newsCateory = new NewsCategory();
        $newsCateory->setTitle('Viagens');
        $this->newsCategoryRepository->save($newsCateory, true);

        $io->success('Categories created in success!');

        return Command::SUCCESS;
    }
}
