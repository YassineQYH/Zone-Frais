<?php

namespace App\Controller\Admin;

use App\Entity\Illustration;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IllustrationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Illustration::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('product'),
            ImageField::new('image')->setBasePath('uploads/')
                                        ->setUploadDir('public/uploads')
                                        ->setUploadedFileNamePattern('[name].[extension]') /* ->setFormTypeOptions(['mapped' => false, 'required' => false]) */
                                        ->setFormTypeOptions(['required' => false]),     
        ];
    }
   
}
