# PLAN

A plan to explore Mars!

- check text input is valid
    - Is not empty
    - Correct number of lines.
    - Coordinates are valid
    - Rover info is valid (x N lines)
- check if file is valid (just reuse code from previous point)
- Check that no squad overlap each other

- Simulate first:
  - For each squad:
    - For each order:
        - Anticipate:
            - Am I gonna hit another squad? Exception!
            - Am I going out of the plateau? Exception!
        - Save following move.
        - Move.
        - Save state.


- Run until no more movements to to or there is an issue.

- Return
  - Current situation.
  - Success ?


Nice to have:
- Show Explored % of the grids
