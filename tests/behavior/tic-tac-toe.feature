Feature: Tic Tac Toe

  Scenario Outline: Create a game with some bad values
    Given a request target url "games"
    And a request method "POST"
    And I have the payload :
    """
    {
        "id": "<id>",
        "playerOne": "<playerOne>",
        "playerTwo": "<playerTwo>",
        "board": [
            "test",
            "test",
            "tst",
            "test",
            "test",
            "test",
            "tes"
        ]
    }
       """
    When I make request
    Then the response status code should be "400"
    Then I should receive a response error message "<errorMessage>"

    Examples:
      | id | playerOne | playerTwo | errorMessage                    |
      |    | playerOne | playerTwo | ID of the game has not been set |
      | 5  |           | playerTwo | Player One has not been set     |
      | 7  | playerOne |           | Player Two has not been set     |


  Scenario: Create a game with incorrect board
    Given a request target url "games"
    And a request method "POST"
    And I have the payload :
    """
    {
        "id": "1",
        "playerOne": "max",
        "playerTwo": "paul",
        "board": [
            "test",
            "test",
            "tst",
            "test",
            "test",
            "test",
            "tes"
        ]
    }
       """
    When I make request
    Then the response status code should be "400"
    Then I should receive a response error message "The game board has not been correct initialized"


  Scenario: Create a game
    Given a request target url "games"
    And a request method "POST"
    And I have the payload :
    """
    {
        "id": "1",
        "playerOne": "max",
        "playerTwo": "paul"
    }
       """
    When I make request
    Then the response status code should be "201"


  Scenario Outline: Make moves on game
    Given a request target url "games/1/makeMove"
    And a request method "POST"
    And I have the payload :
    """
    {
        "player": "<playerName>",
        "gameId": "1",
        "boardPosition": <boardPosition>
    }
       """
    When I make request
    Then the response status code should be "200"

    Examples:
      | playerName | boardPosition |
      | max        | 0             |
      | paul       | 3             |
      | max        | 1             |
      | paul       | 5             |
      | max        | 4             |
      | paul       | 6             |


  Scenario: Make move on a game with wrong playerName
    Given a request target url "games/1/makeMove"
    And a request method "POST"
    And I have the payload :
    """
    {
        "player": "bla",
        "gameId": "1",
        "boardPosition": 8
    }
       """
    When I make request
    Then the response status code should be "400"
    Then I should receive a response error message "The player bla does not exist"


  Scenario: Make move on a game but it is not the turn of the player
    Given a request target url "games/1/makeMove"
    And a request method "POST"
    And I have the payload :
    """
    {
        "player": "paul",
        "gameId": "1",
        "boardPosition": 8
    }
       """
    When I make request
    Then the response status code should be "400"
    Then I should receive a response error message "It's not your turn"


  Scenario: Make move on a game with a boardPosition which does not exist
    Given a request target url "games/1/makeMove"
    And a request method "POST"
    And I have the payload :
    """
    {
        "player": "max",
        "gameId": "1",
        "boardPosition": 9
    }
       """
    When I make request
    Then the response status code should be "400"
    Then I should receive a response error message "The position must be between 0 and 8"


  Scenario: Make move on game when the boardPosition has already been set
    Given a request target url "games/1/makeMove"
    And a request method "POST"
    And I have the payload :
    """
    {
        "player": "max",
        "gameId": "1",
        "boardPosition": 6
    }
       """
    When I make request
    Then the response status code should be "400"
    Then I should receive a response error message "The board position is already set"


  Scenario: Finish the game with max
    Given a request target url "games/1/makeMove"
    And a request method "POST"
    And I have the payload :
    """
    {
        "player": "max",
        "gameId": "1",
        "boardPosition": 7
    }
       """
    When I make request
    Then the response status code should be "200"


  Scenario: The game has finished
    Given a request target url "games/1/makeMove"
    And a request method "POST"
    And I have the payload :
    """
    {
        "player": "paul",
        "gameId": "1",
        "boardPosition": 2
    }
       """
    When I make request
    Then the response status code should be "400"
    Then I should receive a response error message "This game has finished. The winner is max"
