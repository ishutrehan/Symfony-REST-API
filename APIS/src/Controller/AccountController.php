<?php
 /**
  * Created by PhpStorm.
  * User: hicham benkachoud
  * Date: 02/01/2020
  * Time: 22:44
  */

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
   * @param PostRepository $postRepository
   * @param $id
   * @return JsonResponse
   * @Route("/posts/{id}", name="posts_get", methods={"GET"})
   */
  /*public function getPost(PostRepository $postRepository, $id){
   $post = $postRepository->find($id);

   if (!$post){
    $data = [
     'status' => 404,
     'errors' => "Post not found",
    ];
    return $this->response($data, 404);
   }
   return $this->response($post);
  }*/

  /**
   * @param Request $request
   * @param EntityManagerInterface $entityManager
   * @param PostRepository $postRepository
   * @param $id
   * @return JsonResponse
   * @Route("/api/amount/transfer", name="amount_transfer", methods={"POST"})
   */
  public function transferAmount(Request $request){

   try{
    $request = $this->transformJsonBody($request);
   
    if (!$request || !$request->get('sender') || !$request->request->get('receiver') || !$request->request->get('amount')){
     throw new \Exception();
    }

    $post = new Account();
    $post->setName($request->get('name'));
    $post->setEmail($request->get('email'));
    $post->setPassword($request->get('password'));
    $post->setInitialAmount($request->get('initial_amount'));
    
    $data = [
     'status' => 200,
     'errors' => "Amount transfered successfully",
    ];
    return $this->response($data);

   }catch (\Exception $e){
    $data = [
     'status' => 422,
     'errors' => "Data no valid",
    ];
    return $this->response($data, 422);
   }

  }

  /**
   * @param PostRepository $postRepository
   * @param $id
   * @return JsonResponse
   * @Route("/posts/{id}", name="posts_delete", methods={"DELETE"})
   */
  /*public function deletePost(EntityManagerInterface $entityManager, PostRepository $postRepository, $id){
   $post = $postRepository->find($id);

   if (!$post){
    $data = [
     'status' => 404,
     'errors' => "Post not found",
    ];
    return $this->response($data, 404);
   }

   $entityManager->remove($post);
   $entityManager->flush();
   $data = [
    'status' => 200,
    'errors' => "Post deleted successfully",
   ];
   return $this->response($data);
  }*/





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