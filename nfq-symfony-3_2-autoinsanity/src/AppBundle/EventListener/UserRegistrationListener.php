<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;

/**
 * Class UserRegistrationListener
 * Whenever user registers, it sets the username of an user to unique id
 * to use email only authentication
 */
class UserRegistrationListener implements EventSubscriberInterface
{
    /**
     * Subscribe to the registration event
     *
     * @return array Registration Event as key, method as value
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInit'
        );
    }

    /**
     * Set the username to a unique id at registration
     *
     * @param \FOS\UserBundle\Event\UserEvent $userevent
     */
    public function onRegistrationInit(UserEvent $userevent)
    {
        $user = $userevent->getUser();
        $user->setUsername(uniqid());
    }
}
