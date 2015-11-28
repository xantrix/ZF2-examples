<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Entity\Employee;
use Application\Model\Entity\Address;
use Application\Model\Entity\Project as Project;
use Application\Model\Entity\Manager;
use DateTime;
use Zend\Mvc\MvcEvent;
use Doctrine\ODM\MongoDB\Events;
use Application\Model\Listener\TestEventSubscriber;
use Doctrine\ODM\MongoDB\DocumentManager as DocManager;
use Doctrine\Common\EventManager;

use Zend\Paginator\Paginator;
use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator as ODMPaginatorAdapter;

class IndexController extends AbstractActionController
{
    /**
     * @var DocManager
     */
    protected $dm;

    /**
     * @var \Doctrine\Common\EventManager
     */
    protected $evm;

    public function onDispatch(MvcEvent $e)
    {
        $this->dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
        $this->evm = $this->getServiceLocator()->get('doctrine.eventmanager.odm_default');
        parent::onDispatch($e);
    }

    public function indexAction()
    {
        return $this->forward()->dispatch('Application\Controller\Index', ['action' => 'test']);
        //return new ViewModel();
    }

    public function testAction()
    {
        //Config
        $config = $this->getServiceLocator()->get('config');

        //Documents
        $project = new Project('New Project');
        $manager = new Manager();
        $manager->setName('Manager');
        $manager->setSalary(100000);
        $manager->setStarted(new DateTime());
        $manager->addProject($project);

        $employee = new Employee();
        $employee->setName('Employee');
        $employee->setSalary(50000);
        $employee->setStarted(new DateTime());
        $employee->setManager($manager);

        $address = new Address();
        $address->setAddress('555 Doctrine Rd.');
        $address->setCity('Nashville');
        $address->setState('TN');
        $address->setZipcode('37209');
        $employee->setAddress($address);

        //Event
        //$testNew = new TestEventSubscriber();
        $test = $this->getServiceLocator()->get('Application\Model\Listener\TestEventSubscriber');//get subscriber obj
        $this->evm->addEventListener(Events::preFlush, $test);//add listener
        $this->evm->dispatchEvent('preFoo');//trigger subscriber

        //Persist
        $this->dm->persist($employee);
        $this->dm->persist($address);
        $this->dm->persist($project);
        $this->dm->persist($manager);
        $this->dm->flush();

        //relations
        $firstProject = $manager->getProjects()->first();

        //get results
        $repository = $this->dm->getRepository('Application\Model\Entity\Project');//Doctrine\ODM\MongoDB\DocumentRepository
        $query = $this->dm->createQueryBuilder('Application\Model\Entity\Project')->field('name')->equals('New Project')->getQuery();
        $result = $query->getSingleResult();

        //Paginator
        $query = $this->dm->createQueryBuilder('Application\Model\Entity\Project')->getQuery();
        $cursor = $query->execute();
        $adapter = new ODMPaginatorAdapter($cursor);
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $paginator->getCurrentItems();
        $page = (int)$this->params()->fromQuery('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }


        $view = new ViewModel();
        $view->setVariable('paginator', $paginator);

        return $view;
    }
}
