<?php

namespace App\Controller\Admin;

use App\Entity\News;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return News::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Notices')
            ->setEntityLabelInSingular('Notice')
            ->setPageTitle('index', 'Manage Notices')
            ->setPaginatorPageSize(3);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            AssociationField::new('category')->setFormTypeOptions(
                ['choice_label'=>'title','choice_value'=>'id']
            )->setLabel('Category'),
  

            TextField::new('title'),
            TextField::new('image'),
            TextareaField::new('description')->hideOnIndex()->setFormTypeOption('disabled', true),
            TextareaField::new('content')->hideOnIndex(),
            DateTimeField::new('createAt')->setFormTypeOption('disabled', true),
            TextField::new('slug')->setFormTypeOption('disabled', true)->hideOnIndex(),
        ];
    }
}
