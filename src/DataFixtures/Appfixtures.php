<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Appfixtures extends Fixture
{
    private $encoder; 

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker     = Factory::create('FR-fr');

        // Nous gérons les utilisateurs
        $users=[];
        $genres = ['male','female'];
        for ($i=1; $i<=10; $i++) {
            $user = new User;

            $genre     = $faker->randomElement($genres);
            $picture   = "https://randomuser.me/api/portraits/";
            $pictureId = $faker->numberBetween(1, 99) .'.jpg';

            if($genre == "male") {
                $picture = $picture . 'men/' . $pictureId;
            } else {
                $picture = $picture . 'women/' . $pictureId;
            }

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstname($genre))
                 ->setLastName($faker->lastname)
                 ->setEmail($faker->email)
                 ->setAvatar($picture)
                 ->setHash($hash);

            $manager->persist($user);

            $users[]= $user;
        }

        // Nous gérons les catégory
        $categories = ['berline','4*4','suv','cabriolet'];
            foreach ($categories as $cat) {
                $category = new Category;

                $category->setName($cat); 
                $manager ->persist($category);

                // Nous gérons les voitures
                for ($j=0; $j<= mt_rand(10,15); $j++) {
                    $car = new Car();

                    $title           = $faker->sentence(2);
                    $backgroundColor = trim($faker->safeHexcolor, '#');
                    $foregroundColor = trim($faker->safeHexcolor, '#');
                    $imageCars       = "https://dummyimage.com/600x400/" . $backgroundColor . "/". $foregroundColor ."&text=" . "Voiture" ;
                    $imageP          = "https://dummyimage.com/600x400/" . $backgroundColor . "/". $foregroundColor ."&text=" . "photos appartement" ;
                    $content         = "<p>" .join("</p><p>", $faker->paragraphs(3))."</p>";
                    
                    // Ont met le -1 car ont commence a 0
                    $user = $users[mt_rand(0, count($users) -1)];

                    $car->setTitle($title)
                        ->setCoverImage($imageCars)
                        ->setContent($content)
                        ->setPrice(mt_rand(100, 500))
                        ->setCategory($category)
                        ->setUser($user);

                    // Gestions des reservation.
                    for($r=1; $r <= mt_rand(0, 10); $r++) {
                        $booking = new Booking();

                        $createdAt = $faker->dateTimeBetween('-6 months');
                        $startDate = $faker->dateTimeBetween('-3 months');

                        $duration  = mt_rand(3, 10);

                        // Ont clone la startDate pour ne pas modifier la startDate.
                        $endDate   = (clone $startDate)->modify("+$duration days");

                        $amount    = $car->getPrice() * $duration;

                        $booker    = $users[mt_rand(0,count($users) -1)];

                        $booking->setCreatedAt($createdAt)
                                ->setStartDate($startDate)
                                ->setEndDate($endDate)
                                ->setAmount($amount)
                                ->setBooker($user)
                                ->setCar($car);

                        $manager->persist($booking);
                    }
                    $manager->persist($car);
                }
            }   
        $manager->flush();
    }
}
