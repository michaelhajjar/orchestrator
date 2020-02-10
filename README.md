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

Hieronder ziet u een toelichting over de structuur van dit project:

- **(FILE) site.yml**:
  De gebruiker dient site.yml te gebruiken om de orchestrator op te starten. site.yml is de start van de playbook. In de playbook worden de verschillende plays in de playbooks map aangeroepen, op basis van de informatie die de gebruiker aanlevert. Wanneer de playbook wordt gestart, krijgt de gebruiker eerst een aantal vragen:

  - Bent u een bestaande klant of een nieuwe klant?
  - Wat is uw voornaam?
  - Wat is uw achternaam?
  - etc.
  
  Op basis van de informatie wordt een VM aangemaakt, aangepast of verwijderd. Zie [Usage](#Usage) voor het gebruik van site.yml.

- **(FILE) ansible.cfg**:
  Hierin staan de default ansible instellingen. Het aanpassen van deze configuratie file kan effect hebben op de werking van de playbooks!

- **(MAP) inventories**: 
  Hierin komt een inventory file voor alle virtuele machines die gemaakt worden. De inventory file zal ook dienen als 'bron van waarheid'. Bijvoorbeeld: Als haproxy informatie nodig heeft over zijn backend web servers, dan zal de inventory file gebruikt worden voor die informatie. De virtuele machines die aangemaakt worden, komen in een apart categorie in de inventory file, afhankelijk van: bedrijf, rol en omgeving. Er wordt ook andere informatie in de inventory file neergezet per VM als variabel (zoals voornaam, bedrijfsnaam), maar de variabelen in de VM worden nu nog niet gebruikt.

- **(MAP) playbooks**: 
  In deze map staan ook sub mappen. De bedoeling is dat in deze mappen playbooks worden gemaakt dat verschillende taken van een of meerdere rollen, tot een specifieke functie. De sub mappen zijn per platform (vmware, azure en vagrant) ingedeeld en in de sub mappen worden er ook mappen gemaakt voor de specifieke gedeelte van het platform waarop een of meerdere acties uitgevoerd moet worden (vm, storage en network). In de map playbooks/vmware/vm/ zijn 3 playbooks genaamd create, modify en delete. De playbooks hebben betrekking op vm's in vmware.

- **(MAP) roles**: 
  In deze map komen alle rollen. Een rol is een verzameling van herbruikbare taken. 

- **(MAP) vars**:
  In deze map komen alle globale variabelen te staan. Denk hierbij aan de variabelen per omgeving en flavors (cpu, memory en disk).


### Prerequisites
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