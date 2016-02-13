<?php

namespace Uniregistry\Listener\Serializer;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Uniregistry\Model\Edge;
use Uniregistry\Model\Graph;

class PostDeserializeSubscribe implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.post_deserialize', 'method' => 'onPostDeserialize'),
        );
    }

    /**
     * @param ObjectEvent $event
     */
    public function onPostDeserialize(ObjectEvent $event)
    {
        /** @var Graph $graph */
        $graph = $event->getObject();

        if ($graph instanceof Graph) {
            /** @var Edge $edge */
            foreach ($graph->getEdges() as $edge) {
                $edge->setTo($graph->getNode($edge->getTo()));
                $edge->setFrom($graph->getNode($edge->getFrom()));
            }
        }
    }
}