# Login and Registration Stuff

# TODO:
| Name |Desc| Importance | Completed |
|------|----|-----------|-----------|
| Split HTML & PHP | Split PHP and HTML files to improve file organization. | LOW | OPTIONAL |
|XAMPP display issue| XAMPP will list its `htdocs/`directory instead of displaying a html file. |MEDIUM|YES|
| Create Deployment Script | Script wil be used to quickly setup a server| OPTIONAL | NOPE |

# ENV Setup
- This is a very barebones ENV setup
- Do not complain, ok?


## Warning:
1. You don't need to open PowerShell or Command Prompt with **administrator privileges**.
2. If you accidentaly deleted a file, do not panic this is where `git` comes in.
    - Simply use `git pull` and it will download delete files back on your computer.

## Steps
1. Go to XAMPP's htdocs folder:
    ```
    cd C:\xampp\htdocs
    ```
    > Folder Location may vary depending on how you installed XAMPP!
2. Clone this repository:
    ```cmd
    git clone https://github.com/bit-jpg/potential-girl.git StudentLogin
    ```
    > If you used `dir` you should see a folder named **StudentLogin**.
3. Go to StudentLogin Folder:
    ```
    cd StudentLogin
    ```
4. Assuming you have VSCode:
    ```cmd
    code .
    ```
    > This will open VSCode under the current working directory/folder.

5. If you want to test, start XAMPP.
    - Go to localhost/StudentLogin [or simple click this](http://localhost/StudentLogin).
    > Please make sure that XAMPP is instaled correctly!