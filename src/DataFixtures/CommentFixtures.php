<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('uk_UA');

        for ($i = 0; $i < 30; $i++) {
            $comment = new Comment();
            $randomUser = $this->getReference('user_' . rand(0, 9), User::class);
            $comment->setAuthorId($randomUser);

            $comment->setContent($faker->sentence(12));
            $comment->setCreatedAt(\DateTimeImmutable::createFromMutable(
                $faker->dateTimeBetween('-2 years', 'now')
            ));

            $randomPost = $this->getReference('post_' . rand(0, 14), Post::class);
            $comment->setPostId($randomPost);

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [PostFixtures::class];
    }
}
