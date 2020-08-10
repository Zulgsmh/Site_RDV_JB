<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Customer;
use App\Entity\Appointment;
use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    /**
    * L'encodeur de mot de passe
    *
    * @var UserPasswordEncoderInterface
    */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }



    public function load(PersistenceObjectManager $manager)
    {
         
        $faker = Factory::create('fr_FR');
            $user = new User();
            $chrono = 1;
            $hash = $this->encoder->encodePassword($user, "password");

            $user->setName($faker->firstName())
                ->setEmail($faker->email)
                ->setPassword($hash);
            $manager->persist($user); 

            for($c = 0; $c<mt_rand(5,20) ; $c++){
                $customer = new Customer();
                $customer->setFirstName($faker->firstName())
                        ->setLastName($faker->lastName)
                        ->setCompany($faker->company)
                        ->setEmail($faker->email)
                        ->setUser($user);
                $manager->persist($customer);
                for($i =0; $i < mt_rand(3,10); $i++){
                    $appointment = new Appointment();
                    $appointment->setDate($faker->dateTimeBetween('-6 months'))
                            ->setStatus($faker->randomElement(['PENDING','FINISH','CANCELLED']))
                            ->setCustomer($customer);
                    $manager->persist($appointment);
                }
                for($i =0; $i < mt_rand(3,10); $i++){
                    $invoice = new Invoice();
                    $invoice->setAmount($faker->randomFloat(2,250,5000))
                            ->setSentAt($faker->dateTimeBetween('-6 months'))
                            ->setStatus($faker->randomElement(['SENT','PAID','CANCELLED']))
                            ->setCustomer($customer)
                            ->setChrono($chrono);
                    $chrono++;
                    $manager->persist($invoice);
                }
            }

        $manager->flush();
    }
}
