<?php

namespace App\Controller\Admin;

use App\Entity\News;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

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
            ->setPaginatorPageSize(3)
            ->addFormTheme(themePath:'@FOSCKEditor/Form/ckeditor_widget.html.twig');
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
            // ImageField::new('image')->setBasePath('/uploads/images')->setUploadDir('public/uploads/images')->setUploadedFileNamePattern('[slug]-[timesramp].[extension]')->setRequired(false),
            TextareaField::new('description')->hideOnIndex()->setFormTypeOption('disabled', true),
            TextareaField::new('content')->hideOnIndex()->setFormType(CKEditorType::class),
            DateTimeField::new('createAt')->setFormTypeOption('disabled', true),
            TextField::new('slug')->setFormTypeOption('disabled', true)->hideOnIndex(),
        ];
    }
}
