<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpParser\Node\Expr\Cast\Bool_;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
			->onlyOnIndex();

		yield AvatarField::new('avatar', 'Icon')
			->formatValue(static function ($value, User $user)
			{
				return $user->getAvatarUrl();
			})
			->hideOnForm();

		yield ImageField::new('avatar', 'Icon')
			->setBasePath('uploads/avatars')
			->setUploadDir('public/uploads/avatars')
			->setUploadedFileNamePattern('[randomhash].[extension]')
			->onlyOnForms();

		yield EmailField::new('email');

		yield TextField::new('fullName')
			->hideOnForm();

		yield TextField::new('firstName')
			->onlyOnForms();

		yield TextField::new('lastName')
			->onlyOnForms();

		yield BooleanField::new('enabled')
			->renderAsSwitch(false);

		yield DateField::new('createdAt')
			->hideOnForm();

		yield TextField::new('password')
			->onlyOnForms();

		$roles = ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_MODERATOR', 'ROLE_USER'];
		yield ChoiceField::new('roles')
			->setChoices(array_combine($roles, $roles))
			->allowMultipleChoices()
			->renderExpanded()
			->renderAsBadges();
    }
}
