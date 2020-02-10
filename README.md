# About
Ansible orchestrator is een school opdracht, voor VM2. De bedoeling is om via Ansible automatisch een VM aan te maken.

## Requirements
```
De playbooks zijn getest met de volgende configuratie:

- Centos 7.7.1908
- Ansible 2.9.3 (python 3)
- pyvmomi 6.7 (python 3)
- uuidgen
- VMWare Vcenter 6.7u1
```

## Directory Layout
Hieronder ziet u de layout van de git repo.

```
[root@ansible orchestrator]# tree
.
├── ansible.cfg
├── inventories
│   └── provisioner.ini
├── playbooks
│   └── vmware
│       └── vm
│           ├── create.yml
│           ├── delete.yml
│           └── modify.yml
├── README.md
├── roles
│   ├── db
│   │   ├── defaults
│   │   │   └── main.yml
│   │   ├── files
│   │   │   ├── etc_my.cnf.d_custom.cnf.j2
│   │   │   ├── etc_my.cnf.d_network.cnf.j2
│   │   │   ├── etc_my.cnf.d_server.cnf.j2
│   │   │   └── sample-db.sql
│   │   ├── handlers
│   │   │   └── main.yml
│   │   └── tasks
│   │       ├── databases.yml
│   │       └── main.yml
│   ├── lb
│   │   ├── defaults
│   │   │   └── main.yml
│   │   ├── files
│   │   │   └── haproxy.cfg.j2
│   │   ├── handlers
│   │   │   └── main.yml
│   │   └── tasks
│   │       └── main.yml
│   ├── php
│   │   ├── files
│   │   │   ├── create.php
│   │   │   ├── css
│   │   │   │   ├── bootstrap.css
│   │   │   │   ├── bootstrap.min.css
│   │   │   │   ├── bootstrap-responsive.css
│   │   │   │   └── bootstrap-responsive.min.css
│   │   │   ├── database.php
│   │   │   ├── img
│   │   │   │   ├── glyphicons-halflings.png
│   │   │   │   └── glyphicons-halflings-white.png
│   │   │   ├── index.php
│   │   │   ├── js
│   │   │   │   ├── bootstrap.js
│   │   │   │   └── bootstrap.min.js
│   │   │   └── read.php
│   │   ├── handlers
│   │   │   └── main.yml
│   │   └── tasks
│   │       └── main.yml
│   ├── vmware
│   │   └── tasks
│   │       ├── create_sub_folder.yml
│   │       ├── create_vm.yml
│   │       ├── remove_vm.yml
│   │       └── set_vm_attributes.yml
│   └── web
│       ├── defaults
│       │   └── main.yml
│       ├── files
│       │   ├── etc_httpd_conf.d_status.conf.j2
│       │   └── httpd.conf.j2
│       ├── handlers
│       │   └── main.yml
│       └── tasks
│           └── main.yml
├── site.yml
├── test.yml
└── vars
    ├── env
    │   ├── acceptatie
    │   ├── all
    │   ├── ontwikkel
    │   ├── productie
    │   └── test
    └── flavors
        ├── micro.1
        ├── micro.2
        ├── n.v.t.
        └── small.1

32 directories, 52 files
```


## Prerequesites
``` 
Clone dit project en pas de env variabelen in in map vars/env/.
Maak een map genaamd 'inventories' en maak hierin een file aan genaamd 'provisioner.ini'.

Zorg ervoor dat de volgende regel in de file komt:
localhost ansible_connection=local ansible_python_interpreter=/usr/bin/python3
``` 

## Test/Debug
```
Gebruik de volgende commando om snel te debuggen:
ansible-playbook site.yml -e "menu_voornaam=michael menu_achternaam=hajjar menu_bedrijfsnaam=DUO menu_env=productie menu_platform=vmware menu_flavor=micro.1 menu_vm=aanmaken menu_klant=nieuw ansible_python_interpreter=/usr/local/bin/python3" -vvvv
```

## Sources
```
Sample PHP CRUD app: https://www.startutorial.com/articles/view/php-crud-tutorial-part-2
docs.ansible.com
Jeff Geerling & Bert van Vreckem
```
