## Table of Contents
0. [About](#About)
1. [Requirements](#Requirements)
2. [Layout](#Layout)
3. [Toelichting](#Toelichting)
4. [Prerequesites](#Prerequesites)
5. [Usage](#Usage)
6. [Debug](#Debug)
7. [Sources](#Sources)

### About
Ansible orchestrator is een school opdracht, voor VM2. De bedoeling is om via Ansible automatisch een VM aan te maken.


### Requirements
De playbooks zijn getest met de volgende configuratie:

- Centos 7.7.1908
- Ansible 2.9.4 (python 3)
- pyvmomi 6.7 (python 3)
- uuidgen
- VMWare Vcenter 6.7u1


### Layout
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


### Toelichting


### Prerequesites
Installeer de packages die nodig zijn, voer de stappen hieronder uit:
1. Installeer CentOS 7, gevolgd door een yum update/yum upgrade
2. 

Clone dit project en pas de env variabelen in in map vars/env/.
Maak een map genaamd 'inventories' en maak hierin een file aan genaamd 'provisioner.ini'.

Zorg ervoor dat de volgende regel in de file komt:
localhost ansible_connection=local ansible_python_interpreter=/usr/bin/python3


### Usage
Voer de volgende commando uit:

```
ansible-playbook site.yml
```

### Debug
Gebruik de volgende commando om te debuggen:

```
ansible-playbook site.yml -vvvv
```

### Sources
De volgende bronnen zijn geraadpleegd:

- Sample PHP APP: https://www.startutorial.com/articles/view/php-crud-tutorial-part-2
- docs.ansible.com
- galaxy.ansible.com
- Jeff Geerling
- Bert van Vreckem