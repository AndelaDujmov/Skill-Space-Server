<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixture extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $course = new Course();
        $course->setName('Programiranje u C#');
        $course->setTotalPoints(180);
        $course->setLecturesPoints(34);
        $manager->persist($course);
        $manager->flush();
    }

}
