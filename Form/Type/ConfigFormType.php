<?php

namespace MauticPlugin\CrateReplicationBundle\Form\Type;

use Mautic\CoreBundle\Form\Type\FormButtonsType;
use Mautic\CoreBundle\Form\Type\YesNoButtonGroupType;
use Mautic\PluginBundle\Entity\Integration;
use MauticPlugin\IntegrationsBundle\Helper\IntegrationsHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigFormType extends AbstractType
{
    /**
     * @var IntegrationsHelper
     */
    private $integrationsHelper;

    public function __construct(IntegrationsHelper $integrationsHelper)
    {
        $this->integrationsHelper = $integrationsHelper;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $integrationObject = $this->integrationsHelper->getIntegration($options['integration']);

        // isPublished
        $builder->add(
            'isPublished',
            YesNoButtonGroupType::class,
            [
                'label'      => 'mautic.integration.enabled',
                'label_attr' => ['class' => 'control-label'],
            ]
        );

        $builder->add('buttons', FormButtonsType::class);

        $builder->setAction($options['action']);
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return 'crate_configuration';
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(
            [
                'integration',
            ]
        );

        $resolver->setDefined(
            [
                'data_class'  => Integration::class,
            ]
        );
    }
}
