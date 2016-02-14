<?php

namespace Uniregistry\Listener\Serializer;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use Uniregistry\Model\Edge;
use Uniregistry\Model\Graph;

class PreDeserializeSubscribe implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.pre_deserialize', 'method' => 'onPreDeserialize'),
        );
    }

    /**
     * @param PreDeserializeEvent $event
     */
    public function onPreDeserialize(PreDeserializeEvent $event)
    {
        $data = $event->getData();
        $type = $event->getType();

        if (is_array($data) && array_key_exists('queries', $data)) {
            $event->setData($data['queries']);
        }
    }
}