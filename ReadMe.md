## Getting Started
```PowerShell
 php bin/console app:get-ptr-records *domain_name*
```


Change the *domain_name* to the desired domain name.

## With Docker Build
```Powershell
git clone https://github.com/Red2011/practice_workprj.git project
cd ./project
docker build -t practice-workprj-local:latest .
docker run --dns 8.8.8.8 --name practice_workprj_container practice-workprj-local
docker exec -it practice_workprj_container bash
```

## Pull Image form Docker Hub
```Powershell
docker pull red2011/practice_workprj:latest
docker run --dns 8.8.8.8 --name practice_workprj_container practice_workprj 
docker exec -it practice_workprj_container bash
```

<div style="background: linear-gradient(to right, mediumvioletred, mediumblue); padding: 20px;  text-align: center; font-family: 'Pacifico', cursive; border-radius: 60px;">
    <span style="color: White;"><strong>Let's Fun!!!</strong></span>
</div>
