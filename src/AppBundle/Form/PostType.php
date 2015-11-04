<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Название статьи'])
            ->add('description', null, ['label' => 'Описание статьи', 'attr' => ['class' => 'ckeditor']])
            ->add('body', null, ['label' => 'Текст статьи', 'attr' => ['class' => 'ckeditor']])

            ->add('titleEn', null, ['label' => 'Название статьи (Англ)'])
            ->add('descriptionEn', null, ['label' => 'Описание статьи (Англ)', 'attr' => ['class' => 'ckeditor']])
            ->add('bodyEn', null, ['label' => 'Текст статьи (Англ)', 'attr' => ['class' => 'ckeditor']])
            ->add('author', null, ['label' => 'Авторы'])
            ->add('enabled','choice',  array(
                'empty_value' => false,
                'choices' => array(
                    '1' => 'Открыт',
                    '0' => 'Закрыт',
                ),
                'label' => 'Доступ',
                'required'  => false,
            ))
            ->add('submit','submit', ['label' => 'Сохранить'])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_post';
    }
}
