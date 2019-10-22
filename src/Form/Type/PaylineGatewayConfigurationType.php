<?php

/**
 * This file was created by the developers from Waaz.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://www.studiowaaz.com and write us
 * an email on developpement@studiowaaz.com.
 */

namespace Waaz\PaylinePlugin\Form\Type;

use Waaz\PaylinePlugin\Legacy\Mercanet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
final class PaylineGatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('environment', ChoiceType::class, [
                'choices' => [
                    'waaz.payline.production' => 'PROD',
                    'waaz.payline.test' => 'HOMO',
                ],
                'label' => 'waaz.payline.environment',
            ])
            ->add('access_key', TextType::class, [
                'label' => 'waaz.payline.access_key',
                'constraints' => [
                    new NotBlank([
                        'message' => 'waaz.payline.access_key.not_blank',
                        'groups' => ['sylius']
                    ])
                ],
            ])
            ->add('merchant_id', TextType::class, [
                'label' => 'waaz.payline.merchant_id',
                'constraints' => [
                    new NotBlank([
                        'message' => 'waaz.payline.merchant_id.not_blank',
                        'groups' => ['sylius']
                    ])
                ],
            ])
            ->add('contract_number', TextType::class, [
                'label' => 'waaz.payline.contract_number',
                'constraints' => [
                    new NotBlank([
                        'message' => 'waaz.payline.contract_number.not_blank',
                        'groups' => ['sylius']
                    ])
                ],
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $data = $event->getData();
                $data['payum.http_client'] = '@waaz.payline.bridge.payline_bridge';
                $event->setData($data);
            })
        ;
    }
}
