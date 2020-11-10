<?php

 namespace App\Controller;
 use App\Entity\Account;
 //use App\Repository\PostRepository;
 use Doctrine\ORM\EntityManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\JsonResponse;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\Routing\Annotation\Route;

 class AccountController extends AbstractController
 {

  /**
   * @Route("/api/account/create", name="account_create", methods={"POST"})
   */
  public function createAccount(Request $request, EntityManagerInterface $entityManager) {
    
    try{
     
      $request = $this->transformJsonBody($request);
    
      if (!$request || !$request->get('name') || !$request->request->get('email') || !$request->request->get('password') || !$request->request->get('initial_amount')){
        throw new \Exception();
      }
      $post = new Account();
      $post->setName($request->get('name'));
      $post->setEmail($request->get('email'));
      $post->setPassword($request->get('password'));
      $post->setInitialAmount($request->get('initial_amount'));
      
      $entityManager->persist($post);
      $entityManager->flush();

      $data = [
        'id' => $post->getId(),
        'success' => "Account created successfully"
      ];
      return $this->response($data);
    }
    catch (\Exception $e){
      $data = [
      'status' => 422,
      'errors' => $e->getMessage(),
      ];
      return $this->response($data, 422);
    }
  }

  /** 
  * @Route("/api/account/balance/{id}", name="account_balance", methods={"GET"})
  */
  public function getBalance($id)
  {
    $repository = $this->getDoctrine()->getRepository(Account::class);
    $account = $repository->find($id);
    // dynamic method names to find a single product based on a column value
    $account = $repository->findOneById($id);
    $data = [
      'balance' => $account->getInitialAmount()
    ];

    return $this->response($data, 200);
  }

  /** 
   * @Route("/api/customers/") 
  */ 
  public function displayAction() { 
    $customers = $this->getDoctrine() 
    ->getRepository('App:Account') 
    ->findAll();
    return $this->response(array('customers' => $customers), 200);
  }   

  /**
   * @param Request $request
   * @param EntityManagerInterface $entityManager
   * @param PostRepository $postRepository
   * @param $id
   * @return JsonResponse
   * @Route("/api/account/transfer", name="amount_transfer", methods={"POST"})
   */
  public function transferAmount(Request $request){

   try{
    $request = $this->transformJsonBody($request);
  
    if (!$request->get('sender_id') || !$request->get('receiver_id') || !$request->get('amount')){
      throw new \Exception();
    }
    $em = $this->getDoctrine()->getManager(); 

    $sender_id = $request->get('sender_id');
    $receiver_id = $request->get('receiver_id');
    $amount = $request->get('amount');
    $sender = $em->getRepository(Account::class)->find($sender_id);
    if (!$sender) { 
      throw $this->createNotFoundException( 
         'No sender found for id '.$sender_id 
      ); 
    }
    
    $sender_balance = $sender->getInitialAmount();

    $receiver = $em->getRepository(Account::class)->find($receiver_id);
    
    $receiver_balance = $receiver->getInitialAmount();

    $remaining_sender_balance =  $sender_balance - $amount;
    $remaining_receiver_balance =  $receiver_balance + $amount;
    
    $sender->setInitialAmount($remaining_sender_balance);
    $receiver->setInitialAmount($remaining_receiver_balance);
    $em->flush(); 

    $data = [
     'status' => 200,
     'errors' => "Amount transferred successfully.",
    ];
    return $this->response($data, 200);

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

  protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
  {
   $data = json_decode($request->getContent(), true);

   if ($data === null) {
    return $request;
   }

   $request->request->replace($data);

   return $request;
  }

 }