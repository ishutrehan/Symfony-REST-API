<?php
 namespace App\Entity;
 use Doctrine\ORM\Mapping as ORM;
 use Symfony\Component\Validator\Constraints as Assert;
 
 use Symfony\Component\Routing\Annotation\Route;
 
 /**
  * @ORM\Entity
  * @ORM\Table(name="history")
  * @ORM\HasLifecycleCallbacks()
  */
 class History implements \JsonSerializable  {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="text", length=100)
   *
   */
  private $account_id;
  
  /**
   * @ORM\Column(type="text")
   */
  private $debit;
  
  /**
   * @ORM\Column(type="text")
   */
  private $credit;
  
  /**
   * @ORM\Column(type="text")
   */
  private $total;
  

  /**
   * @ORM\Column(type="datetime")
   */
  private $date;

  /**
   * @return mixed
   */
  public function getId()
  {
   return $this->id;
  }
  /**
   * @param mixed $id
   */
  public function setId($id)
  {
   $this->id = $id;
  }

  /**
   * @param mixed $account_id
   */
  public function setAccountID($account_id)
  {
   $this->account_id = $account_id;
  }
  
  /**
   * @param mixed $debit
   */
  public function setDebitAmount($debit)
  {
   $this->debit = $debit;
  }
  /**
   * @param mixed $credit
   */
  public function setCreditAmount($credit)
  {
   $this->credit = $credit;
  }
  
  /**
   * @param mixed $total
   */
  public function setTotal($total)
  {
   $this->total = $total;
  }
  
  /**
   * @param \DateTime $create_date
   * @return Account
   */
  public function setDate(\DateTime $date): self
  {
   $this->date = $date;
   return $this;
  }

  /**
   * Specify data which should be serialized to JSON
   * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
   * @return mixed data which can be serialized by <b>json_encode</b>,
   * which is a value of any type other than a resource.
   * @since 5.4.0
   */
  public function jsonSerialize()
  {
   return [
   ];
  }
 }

 ?>