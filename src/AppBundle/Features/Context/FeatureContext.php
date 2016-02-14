<?php

namespace AppBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    use KernelDictionary;

    /**
     * Opens specified page.
     *
     * @Given /^(?:|I )post to "(?P<page>[^"]+)"$/
     * @When /^(?:|I )submit to "(?P<page>[^"]+)"$/
     */
    public function submit($path)
    {
        $client = $this->getSession()->getDriver()->getClient();

        $client->request('POST', $this->locatePath($path));
    }

    /**
     * Opens specified page.
     *
     * @Given /^(?:|I )post to "(?P<page>[^"]+)" with body:$/
     * @When /^(?:|I )submit to "(?P<page>[^"]+)" with body:$/
     */
    public function submitWithBody($path, PyStringNode $body)
    {
        $client = $this->getSession()->getDriver()->getClient();

        $client->request('POST', $this->locatePath($path), [], [], [], $body->getRaw());
    }

    /**
     * Add an header element in a request.
     *
     * @Given the header :name equals to :value
     */
    public function theHeaderEqualsTo($name, $value)
    {
        $this->getSession()->getDriver()->getClient()->setServerParameter('HTTP_'.$name, $value);
    }
}
