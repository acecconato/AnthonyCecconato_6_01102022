<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Group;
use App\Form\Type\GroupType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/groupes')]
final class GroupController extends AbstractController
{
    #[Route('/creation', name: 'app_group_create')]
    public function createGroup(Request $request, EntityManagerInterface $manager, GroupRepository $groupRepository): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($group);
            $manager->flush();
        }

        return $this->render('groups/create_group.page.twig', [
            'form' => $form->createView(),
            'groups' => $groupRepository->findAll(),
        ]);
    }
}
