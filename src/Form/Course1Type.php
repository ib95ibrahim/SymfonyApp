<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Enseignant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Course1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id',null,['label'=>'Course ID :','disabled'=>'true'])
            ->add('courseName',null,['label'=>'Course Name :','required'=>'true'])
            ->add('Enseignant',EntityType::class,[
                'class'=>Enseignant::class,'label'=>'Enseignant Name :'
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
