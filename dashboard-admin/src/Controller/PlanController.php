<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Plan;
use App\Form\ClientImportType;
use App\Form\ClientType;
use App\Form\PlanType;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/plan")
 */
class PlanController extends AbstractController
{
    /**
     * @Route("/{_locale}/plan", name="app_plan_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $plans = $entityManager->getRepository(Plan::class)->findAll();

        return $this->render('plan/index.html.twig', [
            'plans' => $plans,
        ]);
    }

    /**
     * @Route("/{_locale}/plan/new", name="app_plan_new", methods={"GET"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plan = new Plan();

        $form = $this->createForm(PlanType::class, $plan);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plan);
            $entityManager->flush();

            return $this->redirectToRoute('app_plan_index');
        }

        return $this->render('plan/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{_locale}/plan/{id}/edit', name: 'app_plan_edit', requirements: ['id' => '\d+'])]

    public function edit(Request $request, Plan $plan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanType::class, $plan);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_plan_index');
        }

        return $this->render('plan/edit.html.twig', [
            'form' => $form->createView(),
            'plan' => $plan,
        ]);
    }

    #[Route('/{_locale}/plan/{id}/delete', name: 'app_plan_delete', requirements: ['id' => '\d+'])]
    public function delete(Plan $plan, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($plan);
        $entityManager->flush();

        return $this->redirectToRoute('app_plan_index');
    }
}