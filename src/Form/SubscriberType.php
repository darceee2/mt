<?php

namespace App\Form;

use App\Document\Category;
use App\Document\Subscriber;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * App\Form\SubscriberType
 */
class SubscriberType extends AbstractType
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * SubscriberType constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                ['constraints' => [new NotBlank()]]
            )
            ->add(
                'email',
                EmailType::class,
                ['constraints' => [new NotBlank()]]
            )
            ->add(
                'categories',
                ChoiceType::class,
                [
                    'choices'     => $this->getCategoriesChoices(),
                    'multiple'    => true,
                    'constraints' => [new Count(['min' => 1])]
                ]
            )
            ->add('save', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Subscriber::class]);
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    protected function getCategoriesChoices()
    {
        $choices = [];
        /** @var Category[] $categories */
        $categories = $this->categoryRepository->find();

        foreach ($categories as $category) {
            $choices[$category->getName()] = $category->getId();
        }

        return $choices;
    }
}
