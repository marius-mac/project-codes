<?php

namespace AppBundle\Type;

use AppBundle\Entity\BodyType;
use AppBundle\Entity\Brand;
use AppBundle\Entity\City;
use AppBundle\Entity\ClimateControl;
use AppBundle\Entity\Color;
use AppBundle\Entity\Country;
use AppBundle\Entity\Defects;
use AppBundle\Entity\FuelType;
use AppBundle\Entity\Model;
use AppBundle\Entity\Provider;
use AppBundle\Entity\Transmission;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class VehicleSearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currentYear = intval(date('Y'));
        $modelModifier = function (FormInterface $form, Brand $brand = null) {
            $form->add(
                'model', EntityType::class, [
                'class' => Model::class,
                'label' => 'form.field.model',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) use ($brand) {
                    return $repo->createQueryBuilder('model')
                        ->where('model.brand = :brand')
                        ->setParameter('brand', $brand === null ? null : $brand->getId())
                        ->orderBy('model.name', 'ASC');
                },
                'required' => false,
                ]
            );
        };
        $cityModifier = function (FormInterface $form, Country $country = null) {
            $form->add(
                'city', EntityType::class, [
                'class' => City::class,
                'label' => 'form.field.city',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) use ($country) {
                    return $repo->createQueryBuilder('city')
                        ->where('city.country = :country')
                        ->setParameter('country', $country === null ? null : $country->getId())
                        ->orderBy('city.name', 'ASC');
                },
                'required' => false,
                ]
            );
        };
        $builder
            ->setMethod('GET')
            ->add(
                'brand', EntityType::class, [
                    'class' => Brand::class,
                    'label' => 'form.field.brand',
                    'placeholder' => 'form.placeholder.all.brand',
                    'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('brand')->orderBy('brand.name', 'ASC');
                    },
                    'required' => false,
                ]
            )
            ->add('price_from', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(0),
                ],
                'label' => 'form.field.price_from',
                'choice_translation_domain' => false,
                'choices' => array_merge(
                    $this->generateNumberRange(0, 5000, false, 200, ' €', false),
                    $this->generateNumberRange(5000, 10000, false, 500, ' €', false),
                    $this->generateNumberRange(10000, 20000, false, 1000, ' €', false),
                    $this->generateNumberRange(20000, 100000, false, 10000, ' €', false)
                    ),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add('price_to', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(0),
                ],
                'label' => 'form.field.price_to',
                'choice_translation_domain' => false,
                'choices' => array_merge(
                    $this->generateNumberRange(0, 5000, false, 200, ' €', false),
                    $this->generateNumberRange(5000, 10000, false, 500, ' €', false),
                    $this->generateNumberRange(10000, 20000, false, 1000, ' €', false),
                    $this->generateNumberRange(20000, 100000, false, 10000, ' €', false)
                ),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add('year_from', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(1900),
                    new LessThanOrEqual($currentYear),
                ],
                'label' => 'form.field.year_from',
                'choice_translation_domain' => false,
                'choices' => $this->generateNumberRange(1980, $currentYear, true, 1, ' m.', false),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add('year_to', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(1900),
                    new LessThanOrEqual($currentYear),
                ],
                'label' => 'form.field.year_to',
                'choice_translation_domain' => false,
                'choices' => $this->generateNumberRange(1980, $currentYear, true, 1, ' m.', false),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add(
                'fuel_type', EntityType::class, [
                'class' => FuelType::class,
                'label' => 'form.field.fuel_type',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('fuel_type')->orderBy('fuel_type.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add(
                'body_type', EntityType::class, [
                'class' => BodyType::class,
                'label' => 'form.field.body_type',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('body_type')->orderBy('body_type.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add(
                'provider', EntityType::class, [
                'class' => Provider::class,
                'label' => 'form.field.provider',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('provider')->orderBy('provider.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add(
                'country', EntityType::class, [
                'class' => Country::class,
                'label' => 'form.field.country',
                'placeholder' => 'form.placeholder.all.country',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('country')->orderBy('country.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add('engine_size_from', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(0),
                ],
                'label' => 'form.field.engine_size_from',
                'choice_translation_domain' => false,
                'choices' => array_merge(
                    $this->generateNumberRange(1000, 3000, false, 100, ' cm³', false),
                    $this->generateNumberRange(3000, 6000, false, 200, ' cm³', false)
                ),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add('engine_size_to', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(0),
                ],
                'label' => 'form.field.engine_size_to',
                'choice_translation_domain' => false,
                'choices' => array_merge(
                    $this->generateNumberRange(1000, 3000, false, 100, ' cm³', false),
                    $this->generateNumberRange(3000, 6000, false, 200, ' cm³', false)
                ),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add('power_from', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(0),
                ],
                'label' => 'form.field.power_from',
                'choice_translation_domain' => false,
                'choices' => array_merge(
                    $this->generateNumberRange(20, 100, false, 10, ' kW', false),
                    $this->generateNumberRange(100, 300, false, 30, ' kW', false)
                ),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add('power_to', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(0),
                ],
                'label' => 'form.field.power_to',
                'choice_translation_domain' => false,
                'choices' => array_merge(
                    $this->generateNumberRange(20, 100, false, 10, ' kW', false),
                    $this->generateNumberRange(100, 300, false, 30, ' kW', false)
                ),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add('doors_number', ChoiceType::class, [
                'choice_translation_domain' => false,
                'choices' => $this->generateNumberRange(2, 7),
                'label' => 'form.field.doors_number',
                'placeholder' => 'form.placeholder.all.doors_number',
                'required' => false,
            ])
            ->add('seats_number', ChoiceType::class, [
                'choice_translation_domain' => false,
                'choices' => $this->generateNumberRange(2, 7),
                'label' => 'form.field.seats_number',
                'placeholder' => 'form.placeholder.all.seats_number',
                'required' => false,
            ])
            ->add(
                'drive_type', ChoiceType::class, [
                'choices' => [
                    'form.choice.drive_type.manual' => 0,
                    'form.choice.drive_type.auto' => 1,
                ],
                'label' => 'form.field.drive_type',
                'placeholder' => 'form.placeholder.all.drive_type',
                'required' => false,
                ]
            )
            ->add(
                'climate_control', EntityType::class, [
                'class' => ClimateControl::class,
                'label' => 'form.field.climate_control',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('climate_control')->orderBy('climate_control.id', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add(
                'color', EntityType::class, [
                    'class' => Color::class,
                    'label' => 'form.field.color',
                    'multiple' => true,
                    'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('color')->orderBy('color.name', 'ASC');
                    },
                    'required' => false,
                ]
            )
            ->add(
                'defects', EntityType::class, [
                    'class' => Defects::class,
                    'label' => 'form.field.defects',
                    'multiple' => true,
                    'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('defects')->orderBy('defects.name', 'ASC');
                    },
                    'required' => false,
                ]
            )
            ->add(
                'transmission', EntityType::class, [
                    'class' => Transmission::class,
                    'label' => 'form.field.transmission',
                    'multiple' => true,
                    'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('transmission')->orderBy('transmission.id', 'ASC');
                    },
                    'required' => false,
                ]
            )
            ->add(
                'steering_wheel', ChoiceType::class, [
                    'choices' => [
                        'form.choice.steering_wheel.left' => 0,
                        'form.choice.steering_wheel.right' => 1,
                    ],
                    'label' => 'form.field.steering_wheel',
                    'placeholder' => 'form.placeholder.all.steering_wheel',
                    'required' => false,
                ]
            )
            ->add('wheelsDiameter', ChoiceType::class, [
                'choice_translation_domain' => false,
                'choices' => $this->generateNumberRange(12, 22, false, 1, 'R'),
                'label' => 'form.field.wheels_diameter',
                'placeholder' => 'form.placeholder.all.wheels_diameter',
                'required' => false,
            ])
            ->add('mileage_from', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(0),
                ],
                'label' => 'form.field.mileage_from',
                'choice_translation_domain' => false,
                'choices' => array_merge(
                    $this->generateNumberRange(0, 100000, false, 10000, ' km', false),
                    $this->generateNumberRange(100000, 400000, false, 100000, ' km', false)
                ),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add('mileage_to', ChoiceType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(0),
                ],
                'label' => 'form.field.mileage_to',
                'choice_translation_domain' => false,
                'choices' => array_merge(
                    $this->generateNumberRange(0, 100000, false, 10000, ' km', false),
                    $this->generateNumberRange(100000, 400000, false, 100000, ' km', false)
                ),
                'placeholder' => 'form.placeholder.all.not_specified',
                'required' => false,
            ])
            ->add(
                'sort_type', ChoiceType::class, [
                'choices' => [
                    'form.choice.sort.cost_min' => '0',
                    'form.choice.sort.cost_max' => '1',
                    'form.choice.sort.date_new' => '2',
                    'form.choice.sort.date_old' => '3',
                ],
                'label' => 'form.field.sort',
                'placeholder' => false,
                'required' => false,
                ]
            )
            ->add(
                'next_check_year', ChoiceType::class, [
                'choice_translation_domain' => false,
                'choices' => $this->generateNumberRange($currentYear, $currentYear+5, false, 1, ' m.', false),
                'label' => 'form.field.next_check',
                'placeholder' => 'form.placeholder.all.next_check',
                'required' => false,
                ]
            )
            ->add(
                'first_country', EntityType::class, [
                'class' => Country::class,
                'label' => 'form.field.first_country',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('first_country')->orderBy('first_country.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add('gears_number', ChoiceType::class, [
                'choice_translation_domain' => false,
                'choices' => $this->generateNumberRange(3, 7),
                'label' => 'form.field.gears_number',
                'placeholder' => 'form.placeholder.all.gears_number',
                'required' => false,
            ])
            ->add(
                'last_ad_update', ChoiceType::class, [
                'choices' => [
                    'form.choice.not_older_than.1_day' => 1,
                    'form.choice.not_older_than.3_days' => 3,
                    'form.choice.not_older_than.1_week' => 7,
                    'form.choice.not_older_than.2_weeks' => 14,
                    'form.choice.not_older_than.1_month' => 30,
                    'form.choice.not_older_than.3_months' => 90,
                ],
                'label' => 'form.field.not_older_than',
                'placeholder' => 'form.placeholder.all.not_older_than',
                'required' => false,
                ]
            );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($modelModifier) {
                $data = $event->getData();
                $brand = ($data === null) ? null : $data->getBrand();
                $modelModifier($event->getForm(), $brand);
            }
        );


        $builder->get('brand')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($modelModifier) {
                $brand = $event->getForm()->getData();
                $modelModifier($event->getForm()->getParent(), $brand);
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($cityModifier) {
                $data = $event->getData();
                $country = ($data === null) ? null : $data->getCountry();
                $cityModifier($event->getForm(), $country);
            }
        );


        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($cityModifier) {
                $country = $event->getForm()->getData();
                $cityModifier($event->getForm()->getParent(), $country);
            }
        );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => 'AppBundle\Entity\VehicleSearch'
        ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }

    private function generateNumberRange(
        int $from,
        int $to,
        bool $reorder = false,
        int $step = 1,
        string $text = '',
        bool $text_left = true
    ) {
    
        $range = [];
        for ($i = $from; $i <= $to; $i += $step) {
            if ($text_left) {
                $range[$text . $i] = $i;
            } else {
                $range[$i . $text] = $i;
            }
        }
        if ($reorder) {
            arsort($range);
        }
        return $range;
    }
}
