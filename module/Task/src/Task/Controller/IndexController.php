<?php
 namespace Task\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\Json\Json;
use \PDO;
use Zend\View\Model\JsonModel;
 class IndexController extends AbstractActionController
 {
         public function indexAction()
    {



        return new ViewModel();
 }
     public function dataAction()
     {

         $adapter = new Adapter( array(
                 'driver' => 'Pdo',
                 'dsn' => 'mysql:dbname=task;host=localhost',
                 'username' => 'root',
                 'password' => '',
                 PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',

             )
         );
         $response = $this->getResponse();
         $stmt = $adapter->createStatement('SELECT u.name,e.view_education,c.city,e.id FROM user as u INNER JOIN
                                           education as e ON e.id=u.education_id INNER JOIN user_city as uc ON uc.user_id=u.id
                                           INNER JOIN city as c ON c.id=uc.city_id  ' );
         $results = $stmt->execute();
         $data="[";
         foreach($results as $result){
             $data.=Json::encode($result).",";

         }
         $data=substr($data, 0,-1);
        $data.="]";
         $result = new JsonModel(array(
             'data' => $data,
             'success'=>true,
         ));

         return $result;
     }
     public function updateAction(){
         $adapter = new Adapter( array(
                 'driver' => 'Pdo',
                 'dsn' => 'mysql:dbname=task;host=localhost',
                 'username' => 'root',
                 'password' => '',
                 PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',

             )
         );
         $sql = "UPDATE education

        SET  view_education=?

        WHERE id=?";





         $stmt = $adapter->createStatement($sql);
         $stmt->execute([$_POST['id'],$_POST['view_education']]);
         $response = $this->getResponse();
         return $response;
     }

 }
