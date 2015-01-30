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
                'dsn' => 'mysql:dbname=blog;host=localhost',
                'username' => 'root',
                'password' => 'root',
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',

            )
        );

        $request = $this->getRequest();

        //Получаем данные
        $start = $request->getPost('start') ? : 0;
        $limit = $request->getPost('limit') ? : 5;

        $offset = ' LIMIT '.$start.','.$limit;

        $stmt = $adapter->createStatement('SELECT u.id,u.name,e.view_education,c.city,e.id as ed_id FROM user as u INNER JOIN
                                           education as e ON e.id=u.education_id INNER JOIN user_city as uc ON uc.user_id=u.id
                                           INNER JOIN city as c ON c.id=uc.city_id  '.$offset );
        $results = $stmt->execute();

        $data="[";
        $i=1;
        foreach($results as $result){
            $result['userid']=$i;
            $data.=Json::encode($result).",";
            $i++;

        }

        $data=substr($data, 0,-1);
        $data.="]";
        $result = new JsonModel(array(
            'data' => $data,
            'total'=>'54',
            'success'=>true,
        ));

        return $result;
    }
    public function updateAction(){

        $adapter = new Adapter( array(
                'driver' => 'Pdo',
                'dsn' => 'mysql:dbname=blog;host=localhost',
                'username' => 'root',
                'password' => 'root',
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
