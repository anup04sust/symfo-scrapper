<?php

namespace App\Controller;

use App\Entity\CompanyProfile;
use App\Form\CompanyProfileType;
use App\Form\CompanyProfileScrape;
use App\Repository\CompanyProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


#[Route('/company-profile')]
class CompanyProfileController extends AbstractController {

    #[Route('/', name: 'app_company_profile_index', methods: ['GET'])]
    public function index(CompanyProfileRepository $companyProfileRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('company_profile/index.html.twig', [
                    'company_profiles' => $companyProfileRepository->findAll(),
        ]);
    }

    #[Route('/scrape', name: 'app_company_profile_scrape', methods: ['GET', 'POST'])]
    public function scrape(Request $request): Response {

        $defaultData = ['registration_code' => '125765596'];
        $form = $this->createFormBuilder($defaultData)
                ->add('registration_code', TextType::class,
                        ['label' => false],
                       
                        ['attr' => [['class' => 'form-control'], ['placeholder' => 'Enter registration number e.g 125765596']]],
                )
                ->add('scrape_me', SubmitType::class, ['label' => 'scrape'], ['attr' => ['class' => 'btn btn-primary']])
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();
        }

        return $this->render('company_profile/scrape.html.twig', [
                  
                    'form' => $form,
                    'data' => $data,
        ]);
    }

    #[Route('/new', name: 'app_company_profile_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $companyProfile = new CompanyProfile();
        $form = $this->createForm(CompanyProfileType::class, $companyProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($companyProfile);
            $entityManager->flush();

            return $this->redirectToRoute('app_company_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company_profile/new.html.twig', [
                    'company_profile' => $companyProfile,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_profile_show', methods: ['GET'])]
    public function show(CompanyProfile $companyProfile): Response {
        return $this->render('company_profile/show.html.twig', [
                    'company_profile' => $companyProfile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_company_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CompanyProfile $companyProfile, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(CompanyProfileType::class, $companyProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_company_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company_profile/edit.html.twig', [
                    'company_profile' => $companyProfile,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_profile_delete', methods: ['POST'])]
    public function delete(Request $request, CompanyProfile $companyProfile, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $companyProfile->getId(), $request->request->get('_token'))) {
            $entityManager->remove($companyProfile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_company_profile_index', [], Response::HTTP_SEE_OTHER);
    }
}
