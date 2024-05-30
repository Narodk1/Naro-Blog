<?php  


namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextareaType::class,
            [
                'attr' => [
                    'style' => 'width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;',
                    'rows' => 5,  // Vous pouvez également définir le nombre de lignes ici
                ],])
            ->add('save', SubmitType::class, [
                'label' => 'Post comment',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'style' => 'padding: 10px 20px; font-size: 16px;  border-color: #007bff; color: #fff;',
                ],

        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
