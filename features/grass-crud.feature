Feature: I would like to edit grass

  Scenario Outline: Insert records
   Given I am on homepage
     And I follow "Login"
     And I fill in "Username" with "admin"
     And I fill in "Password" with "loremipsum"
     And I press "Login"
     And I go to "/admin/grass/"
    Then I should not see "<grass>"
     And I follow "Create a new entry"
    Then I should see "Grass creation"
    When I fill in "Name" with "<grass>"
     And I fill in "Lenght" with "<lenght>"
     And I press "Create"
    Then I should see "<grass>"
     And I should see "<lenght>"

  Examples:
    | grass    | lenght |
    | england       | 15  |
    | irland      | 190 |



  Scenario Outline: Edit records
   Given I am on homepage
     And I follow "Login"
     And I fill in "Username" with "admin"
     And I fill in "Password" with "loremipsum"
     And I press "Login"
     And I go to "/admin/grass/"
    Then I should not see "<new-grass>"
    When I follow "<old-grass>"
    Then I should see "<old-grass>"
    When I follow "Edit"
     And I fill in "Name" with "<new-grass>"
     And I fill in "Lenght" with "<new-lenght>"
     And I press "Update"
     And I follow "Back to the list"
    Then I should see "<new-grass>"
     And I should see "<new-lenght>"
     And I should not see "<old-grass>"

  Examples:
    | old-grass     | new-grass  | new-lenght    |
    | england       | spain       | 9876       |
    | irland        | poland       | 3333       |


  Scenario Outline: Delete records
   Given I am on homepage
     And I follow "Login"
     And I fill in "Username" with "admin"
     And I fill in "Password" with "loremipsum"
     And I press "Login"
     And I go to "/admin/grass/"
    Then I should see "<grass>"
    When I follow "<grass>"
    Then I should see "<grass>"
    When I press "Delete"
    Then I should not see "<grass>"

  Examples:
    |  grass    |
    | spain   |
    | poland |
