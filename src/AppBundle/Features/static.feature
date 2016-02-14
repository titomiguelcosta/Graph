Feature:
  As a guest
  I can visit the homepage and access other content
  So I can interact with the pages

  Scenario: I can visit the homepage
    When I go to "/"
    Then the response status code should be 200
    And I should see "Graphistry" in the "h1" element
    And I should see "Validate" in the "h2" element
    And I should see "Query"
    And I should see "Populate"

  Scenario: I can check the xml create graph example
    When I go to "/graph/example/create"
    Then the response status code should be 200
    And the response should be in XML
    And the XML element "id" should exist
    And the XML element "name" should exist
    And the XML element "nodes" should exist
    And the XML element "nodes" should have 2 elements
    And the XML element "edges" should exist
    And the XML element "edges" should have 2 elements
    And the XML element "//edges/*[1]/id" should be equal to "e1"
    And the XML element "//edges/*[1]/cost" should be equal to "42"
    And the XML element "//edges/*[2]/from" should be equal to "a"
    And the XML element "//edges/*[2]/cost" should not exist

  Scenario: I can check the json query graph example
    When I go to "/graph/example/query"
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON node "queries" should exist
    And the JSON node "queries.paths" should exist
    And the JSON node "queries.paths" should have 2 elements
    And the JSON node "queries.paths[0].start" should be equal to "a"
    And the JSON node "queries.cheapest" should exist
    And the JSON node "queries.cheapest" should have 2 elements