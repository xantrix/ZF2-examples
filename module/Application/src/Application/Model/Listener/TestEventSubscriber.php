<?php
namespace Application\Model\Listener;

class TestEventSubscriber implements \Doctrine\Common\EventSubscriber
{
    const preFoo = 'preFoo';

    public $preFooInvoked = false;

    public function preFoo()
    {
        $this->preFooInvoked = true;
    }

    public function getSubscribedEvents()
    {
        return array(self::preFoo);
    }
    
    /**
     * http://stackoverflow.com/questions/10730377/doctrine-listener-versus-subscriber
     * @param \Doctrine\ODM\MongoDB\Event\PreFlushEventArgs $eventArgs
     */
    public function preFlush(\Doctrine\ODM\MongoDB\Event\PreFlushEventArgs $eventArgs)
    {
        $dm = $eventArgs->getDocumentManager();
        $uow = $dm->getUnitOfWork();
        // do something
    }
    
}