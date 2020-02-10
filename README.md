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
[root@ansible orchestrator]# tree -L 3
.
├── ansible.cfg
├── inventories
│   └── provisioner.ini
├── playbooks
│   └── vmware
│       └── vm
├── README.md
├── roles
│   ├── db
│   │   ├── defaults
│   │   ├── files
│   │   ├── handlers
│   │   └── tasks
│   ├── lb
│   │   ├── defaults
│   │   ├── files
│   │   ├── handlers
│   │   └── tasks
│   ├── php
│   │   ├── files
│   │   ├── handlers
│   │   └── tasks
│   ├── vmware
│   │   └── tasks
│   └── web
│       ├── defaults
│       ├── files
│       ├── handlers
│       └── tasks
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
