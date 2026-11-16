# Untitled Coding Platform/App/Game
## Setup
1. Install Python for your platform
2. After that, Install uv:
    - For Linux:
        ```
        curl -LsSf https://astral.sh/uv/install.sh | sh
        ```
    - For Windows:
        - Open Command Prompt and Copy this:
        ```
        powershell -ExecutionPolicy ByPass -c "irm https://astral.sh/uv/install.ps1 | iex"
        ```
3. Clone this repository
    ```
    git clone https://github.com/bit-jpg/potential-girl.git
    ```
    * Note: Running this command will create a folder named "potential-girl". 
4. Using Command Prompt, Navigate the the newly created Folder:
    ```
    cd potential-girl
    ```
5. Run this command:
    * Make sure you can see a file named: uv.lock
    ```
    uv sync
    ```
    * This will download all required Python Modules
6. Finally create your own local-only database:
    ```
    uv run python manage.py migrate
    ```
## Questions and Answers
1. Placeholder
## Members and Roles
|  Name  |       Role       |
|  ----  |       ----       |
|Person 1|Frontend & Backend|
|Person 2|Frontend & Backend|
|Person 3|Frontend & Backend|
|Person 4|Frontend & Backend|
|Person 5|Frontend & Backend|
|Person 6|Frontend & Backend|