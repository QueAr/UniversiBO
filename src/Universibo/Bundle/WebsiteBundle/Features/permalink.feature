Feature: Permalink
    In order to directly reach a news
    As user
    I need to access a permalink

    Scenario: Show permalink from fixture
        When I visit "/permalink/1/"
        Then the response should contain "Test news"
        And the response should contain "Test content"

    Scenario: Expired news is Not found
        When I visit "/permalink/2/"
        Then the response should contain "Not found"

