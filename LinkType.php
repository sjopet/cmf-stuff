<?php

namespace Netvlies\Bundle\OmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Netvlies\Bundle\OmsBundle\Document\LinkInterface;
use Sonata\AdminBundle\Form\DataTransformer\ModelToIdTransformer;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class LinkType extends AbstractType implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options['sonata_field_description']->setHelp($options['help_text']);

        $choices = array(
            LinkInterface::LINK_TYPE_EXTERNAL => 'Extern',
            LinkInterface::LINK_TYPE_INTERNAL => 'Intern',
        );

        if($options['allow_none']){
            $choices[LinkInterface::LINK_TYPE_NONE] = 'Geen link';
        }

        $builder
            ->add('linkType', 'choice', array(
                'label' => 'Linktype',
                'choices' => $choices
            ))
            ->add('linkUrl', 'url', array(
                'label' => 'Externe link'
            ))
            ->add('linkDocument', 'hidden',
                array(
                    'constraints' => array(

                    ),
                    'attr' => array(
                        'class' => 'select2ajax',
                    )
                )
            )
            ->add('linkTarget', 'choice', array(
                'label' => 'Linkdoel',
                'choices' => array(
                    LinkInterface::LINK_TARGET_SELF  => 'Zelfde pagina of tab',
                    LinkInterface::LINK_TARGET_BLANK => 'Nieuw venster of tab',
                ),
                'required' => true,
            ))
        ;

        $builder->get('linkDocument')->addModelTransformer(new ModelToIdTransformer($this->container->get('sonata.admin.manager.doctrine_phpcr'), null));
        $builder->addValidator(new \Symfony\Component\Form\CallbackValidator(function ($form){
            /**
             * @var FormInterface $form
             */
            $linkType = $form->get('linkType')->getData();
            switch($linkType){
                case LinkInterface::LINK_TYPE_INTERNAL:
                    if($form->get('linkDocument')->getData() == ''){
                        $form->addError(new \Symfony\Component\Form\FormError('Pagina is verplicht bij interne link'));
                    }
                    break;
                case LinkInterface::LINK_TYPE_EXTERNAL:
                    if($form->get('linkUrl')->getData() == ''){
                        $form->addError(new \Symfony\Component\Form\FormError('Link is verplicht'));
                    }
                    break;
            }
        }));
    }

    /**
     * @param array $options
     * @return array
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'virtual' => true,
            'model_manager' => null,
            'document_roots' => array($this->container->get('oms_config')->getContentRoot(), '/netvlies/content/shared' ),
            'help_text' => '',
            'allow_none' => false,
        );
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['document_roots'] = $options['document_roots'];
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'oms_link';
    }
}

