<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Comment;
use Faker;
use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /**
     * Les propriétés qui vont accueillir les services nécessaires à la classe de Fixtures
     */
    private $connection;

    /**
     * On récupère les services utiles via le constructeur
     */
    public function __construct(Connection $connection)
    {
        // On récupère la connexion à la BDD (DBAL ~= PDO)
        // pour exécuter des requêtes manuelles en SQL pur
        $this->connection = $connection;
    }

    /**
     * Permet de TRUNCATE les tables et de remettre les AUTO_INCREMENT à 1
     */
    private function truncate()
    {
        // On passe en mode SQL ! On cause avec MySQL
        // Désactivation la vérification des contraintes FK
        $this->connection->executeQuery('SET foreign_key_checks = 0');
        // On tronque
        $this->connection->executeQuery('TRUNCATE TABLE post');
        $this->connection->executeQuery('TRUNCATE TABLE author');
        $this->connection->executeQuery('TRUNCATE TABLE comment');
        $this->connection->executeQuery('TRUNCATE TABLE user');
        // etc.
    }
    public function load(ObjectManager $manager): void
    {
        // On TRUNCATE manuellement
        $this->truncate();

        // ! config du faker et du populator
        $faker = Factory::create('fr_FR');

        // pour avoir toujours les mêmes résultats
        // @link https://fakerphp.github.io/#seeding-the-generator
        $faker->seed('11102022');

        // Nos users
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        // bin/console security:hash-password => admin
        $admin->setPassword('$2y$13$/LRHx9AA56jotW5UV40BjeB1N5NU4zkMyD34lOv8Lb8ozBDVpbh2u');

        // /!\ la variable $manager est déjà existante en paramètre de la méthode load() !
        $managerUser = new User();
        $managerUser->setEmail('manager@manager.com');
        $managerUser->setRoles(['ROLE_MANAGER']);
        // bin/console security:hash-password => manager
        $managerUser->setPassword('$2y$13$A30us9hMs04OMDrp387iiOzgpyN1RxWhQNE3DcFwsNhN9O0DYugdW');

        $user = new User();
        $user->setEmail('user@user.com');
        $user->setRoles(['ROLE_USER']);
        // bin/console security:hash-password => user
        $user->setPassword('$2y$13$OX9RoBNejyEYZaMx9JmR8Ogw5AIDWPRSmrwmf8To9fv6CuiFa4r2C');

        $manager->persist($admin);
        $manager->persist($managerUser);
        $manager->persist($user);
        
        // Author
        for ($i = 0; $i < 5; $i++) {

            $author = new Author();
            $author->setFirstname($faker->firstName);
            $author->setLastname($faker->lastName);
            $author->setCreatedAt(new DateTimeImmutable());

            $manager->persist($author);

             //Post
            for ($j = 0; $j <= mt_rand(1, 10); $j++) {

                $post = new Post();
                $post->setTitle($faker->sentence(5, true))
                    ->setPublishedAt(new DateTimeImmutable())
                    ->setBody($faker->realText(300))
                    ->setImage("https://picsum.photos/id/".mt_rand(1000, 1100)."/200/300")
                    ->setAuthor($author);

                $manager->persist($post);

            }
            // Comment
            for ($i = 0; $i <= mt_rand(1, 3); $i++) {
    
                $comment = new Comment();
                $comment->setUsername($faker->firstName)
                   ->setBody($faker->sentence(10))
                   ->setPublishedAt(new DateTimeImmutable())
                   ->setCreatedAt(new DateTimeImmutable())
                   ->setUpdatedAt(new DateTimeImmutable())
                   ->setPost($post);
    
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
