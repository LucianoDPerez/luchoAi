<?php


namespace App\Controller;


use App\Entity\MkConn;

use App\Form\MkConnType;

use Doctrine\ORM\EntityManagerInterface;

use RouterOS;
use RouterOS\Query;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;


class MkConnController extends AbstractController

{
    #[Route('/{_locale}/mk-conn/test', name: 'app_mk_conn_test')]
    public function test(EntityManagerInterface $entityManager): Response
    {
        $app_name = 'MK TEST';

        $client = new RouterOS\Client([
            'host' => '192.168.12.1',
            'user' => 'testApi',
            'pass' => 'luchop84',
            'port' => 8728
        ]);

        $query = new Query('/queue/simple/print');
        $response = $client->query($query)->read();

        dd($response);

        // Limpia los caracteres malformados
        function cleanUtf8($data) {
            return array_map(function($item) {
                return array_map(function($value) {
                    return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }, $item);
            }, $data);
        }

        $response = cleanUtf8($response);

        return new JsonResponse(var_dump($response));
    }

    #[Route('/{_locale}/mk-conn', name: 'app_mk_conn_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $app_name = 'My App';

        $mkConns = $entityManager->getRepository(MkConn::class)->findAll();

        return $this->render('mk_conn/index.html.twig', [
            'connections' => $mkConns,
            'app_name' => $app_name,
            'controller_name' => 'MK Conn'
        ]);

    }


    #[Route('/{_locale}/mk-conn/{id}', name: 'app_mk_conn_show', requirements: ['id' => '\d+'])]

    public function show(MkConn $mkConn): Response

    {

        return $this->render('mk_conn/show.html.twig', [

            'mk_conn' => $mkConn,

        ]);

    }


    #[Route('/{_locale}/mk-conn/new', name: 'app_mk_conn_new')]

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mkConn = new MkConn();

        $form = $this->createForm(MkConnType::class, $mkConn);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mkConn);
            $entityManager->flush();

            return $this->redirectToRoute('app_mk_conn_index');
        }

        return $this->render('mk_conn/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{_locale}/mk-conn/{id}/edit', name: 'app_mk_conn_edit', requirements: ['id' => '\d+'])]

    public function edit(Request $request, MkConn $mkConn, EntityManagerInterface $entityManager): Response

    {

        $form = $this->createForm(MkConnType::class, $mkConn);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();


            return $this->redirectToRoute('app_mk_conn_index');

        }


        return $this->render('mk_conn/edit.html.twig', [

            'form' => $form->createView(),

            'mk_conn' => $mkConn,

        ]);

    }


    #[Route('/{_locale}/mk-conn/{id}/delete', name: 'app_mk_conn_delete', requirements: ['id' => '\d+'])]
    public function delete(MkConn $mkConn, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($mkConn);
        $entityManager->flush();

        return $this->redirectToRoute('app_mk_conn_index');
    }
}
