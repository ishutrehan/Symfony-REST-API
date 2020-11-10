<?php

 namespace App\Controller;
 use App\Entity\History;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\JsonResponse;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\Routing\Annotation\Route;

 class HistoryController extends AbstractController
 {
    /**
     * @Route("/api/account/history/{account_id}", name="account_history", methods={"GET"})
     */
    public function getHistory($account_id){
        try{
            $repository = $this->getDoctrine()->getRepository(History::class);
            $history = $repository->findBy(['account_id' => $account_id]);
            
            return $this->response(array('history' => $history), 200);

        }catch (\Exception $e){
            $data = [
                'status' => 422,
                'errors' => $e->getMessage()
            ];
            return $this->response($data, 422);
        }
    }
    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }
}