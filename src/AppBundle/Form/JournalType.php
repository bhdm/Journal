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
            ->add('title', null, ['label' => 'Название журнала'])
            ->add('photo', null, ['label' => 'Фото обложки'])
            ->add('year', null, ['label' => 'Год выпуска'])
            ->add('month', null, ['label' => 'Месяц выпуска'])
            ->add('enabled', 'choice', ['label' => 'Доступ', 'choice_list' => [1 => 'Открыт', 0 => 'Закрыт']])
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
