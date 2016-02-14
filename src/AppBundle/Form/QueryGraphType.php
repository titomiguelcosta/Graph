<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Uniregistry\Model\Graph;

class QueryGraphType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('graph', ChoiceType::class, [
                'choices' => $this->flattenChoices($options['graphs'])
            ])
            ->add('format', ChoiceType::class, [
                'choices' => [
                    'Html' => 'html',
                    'Json' => 'json'
                ],
                'label' => 'Response'
            ])
            ->add('json', TextareaType::class, [
                'required' => true,
                'attr' => ['rows' => '8']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Query',
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'graphs' => []
        ));
    }

    /**
     * @param $graphs
     * @return array
     */
    private function flattenChoices($graphs)
    {
        $choices  = [];
        /** @var Graph $graph */
        foreach ($graphs as $graph) {
            $choices[$graph->getName()] = $graph->getId();
        }

        return $choices;
    }
}
