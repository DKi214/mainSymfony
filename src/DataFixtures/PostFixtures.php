<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('uk_UA');

        for ($i = 0; $i < 15; $i++) {
            $post = new Post();
            $title = $faker->sentence(5);
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));

            $post->setTitle($title);
            $post->setSlug($slug);
            $post->setContent($faker->paragraphs(3, true));
            $post->setCreatedAt(\DateTimeImmutable::createFromMutable(
                $faker->dateTimeBetween('-2 years', 'now')
            ));
            $post->setUpdatedAt(\DateTimeImmutable::createFromMutable(
                $faker->dateTimeBetween('-1 year', 'now')
            ));

            $randomUser = $this->getReference('user_' . rand(0, 9), User::class);
            $post->setAuthorId($randomUser);

            $manager->persist($post);
            $this->addReference('post_' . $i, $post);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
