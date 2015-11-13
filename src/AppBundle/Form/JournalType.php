<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JournalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Название'])
            ->add('photo', 'file', ['label' => 'Фото обложки', 'data_class' => null])
            ->add('year', null, ['label' => 'Год выпуска'])
            ->add('month', null, ['label' => 'Месяц выпуска'])
            ->add('description', null, ['label' => 'Описание', 'attr' => ['class' => 'ckeditor']])
            ->add('keywords', null, ['label' => 'Ключевые слова'])
            ->add('tom', null, ['label' => 'Том'])

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
            'data_class' => 'AppBundle\Entity\Journal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_journal';
    }
}
