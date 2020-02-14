## Table of Contents
0. [About](#About)
1. [Status](#Status)
2. [Requirements](#Requirements)
3. [Layout](#Layout)
4. [Toelichting](#Toelichting)
5. [Prerequesites](#Prerequesites)
6. [Usage](#Usage)
7. [Debug](#Debug)
8. [Sources](#Sources)


### About
Ansible orchestrator is een school opdracht. De bedoeling is om via Ansible automatisch een VM aan te maken, aanpassen of verwijderen. Het opzetten van VMWare zelf en het maken van templates is buiten de scope van dit project. 


### Status
De volgende functies zijn geïmplementeerd:

Platform VMWare
- Aanmaken van een of meerdere VM's
- Aanpassen van een VM
- Verwijderen van een of meerdere VM's


### Requirements
De playbooks zijn getest met de volgende configuratie:

- Centos 7.7.1908 (OS en template)
- Ansible 2.9.4 (python 3)
- pyvmomi 6.7 (python 3)
- uuidgen
- VMWare Vcenter 6.7u1

<div style="page-break-after: always;"></div>

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
<div style="page-break-after: always;"></div>

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
  Hierin komt een inventory file voor alle virtuele machines die gemaakt worden. De inventory file zal ook dienen als 'bron van waarheid'. Bijvoorbeeld: Als haproxy informatie nodig heeft over zijn backend web servers, dan zal de inventory file gebruikt worden voor die informatie. De virtuele machines die aangemaakt worden, komen in een apart categorie in de inventory file, afhankelijk van: bedrijf, rol en omgeving. Er wordt ook andere informatie in de inventory file neergezet per VM als variabel (zoals voornaam, bedrijfsnaam), maar de variabelen in de VM worden nu nog niet gebruikt. Er kan ook per VM een specifieke private key ingesteld worden, indien dit wenselijk is. 

- **(MAP) playbooks**: 
  In deze map staan ook sub mappen. De bedoeling is dat in deze mappen playbooks worden gemaakt dat verschillende taken van een of meerdere rollen, tot een specifieke functie. De sub mappen zijn per platform (vmware, azure en vagrant) ingedeeld en in de sub mappen worden er ook mappen gemaakt voor de specifieke gedeelte van het platform waarop een of meerdere acties uitgevoerd moet worden (vm, storage en network). In de map playbooks/vmware/vm/ zijn 3 playbooks genaamd create, modify en delete. De playbooks hebben betrekking op vm's in vmware.

- **(MAP) roles**: 
  In deze map komen alle rollen. Een rol is een verzameling van herbruikbare taken. 

- **(MAP) vars**:
  In deze map komen alle globale variabelen te staan. Denk hierbij aan de variabelen per omgeving en flavors (cpu, memory en disk). de env/all wordt als eerst ingeladen, hierna de env/omgeving. Als in env/all de variabel 'cpu' is gedefineerd en ook in de env/omgeving, dan wordt de env/all 'cpu' variabel overschreven door de env/omgeving variabel.

  Er zijn 4 omgevingen gemaakt, volgens OTAP: Ontwikkel (O), Test (T), Acceptatie (A) en Productie (P). De reden hiervoor is om de eindgebruiker de mogelijkheid te geven om op verschillende omgevingen virtuele machines uit te rollen en de variabelen specifiek neer te zetten voor de specifieke omgevingen. Dit is gedaan met security in gedachte (productie moet niet dezelfde infrastructuur gebruiken als test). De specifieke variabelen kunnen het volgende zijn (als voorbeeld):

  - ansible_ssh_private_key (per omgeving een andere private SSH key)
  - ansible_ssh_user (aparte gebruikers per omgeving om te verbinden met de servers)

  **In de vars kunnen ook gevoelige gebruikers/wachtwoorden AES256 geencrypt worden (voor VMWare bijvoorbeeld).**
  De standaard wachtwoord voor de vault is: Welkom01
  
<div style="page-break-after: always;"></div>

### Prerequisites
Installeer de packages die nodig zijn, voer de stappen hieronder uit als root:

1. Installeer CentOS 7, gevolgd door een yum update/yum upgrade
```
yum upgrade -y
yum clean all
```
2. Installeer Python 3.6 en pip3
```
yum install python3 python3-pip -y
```
3. Installeer Ansible en pyvmomi via pip3
```
pip3 install ansible pyvmomi
```
4. Maak een service account aan, voor het inloggen op de servers. Maak ook gelijk een SSH-key aan (RSA 4096 bit of ed25519).
```
useradd ansible_provisioner
ssh-keygen -t rsa -b 4096
```
5. Zorg ervoor dat er een centos7 template bestaat in de VMWare omgeving met de public key van de SSH-key die in stap 4 is gegenereerd.
   Zie comando hieronder voor de output van de SSH public key. 
```
cat /home/ansible_provisioner/.ssh/id_rsa.pub
```
5. Clone dit project en pas de env variabelen aan in vars/env/.  
6. Maak een map genaamd 'inventories' en maak hierin een file aan genaamd 'provisioner.ini'. 
   Zorg ervoor dat de volgende regel in de file komt:
```
localhost ansible_connection=local ansible_python_interpreter=/usr/bin/python3
```
7. Maak een vault pw file aan in /root/vault_pw.txt
```
echo "Welkom01" > /root/vault_pw.txt 
```
8. Ga naar [Usage](#Usage)

<div style="page-break-after: always;"></div>

### Usage
Voer de volgende commando uit in de root van dit project (als root user):

```
ansible-playbook site.yml
```

Vul hierna alle prompts in. De vragen kunnen verschillen per actie (aanmaken, aanpassen of verwijderen).
U hoeft voor de rest niks te doen, uiteindelijk krijgt u de output terug van de actie die u heeft gekozen.

- Aanmaken geeft als output de nieuw aangemaakte VM's.
- Aanpassen laat zien welke VM's zijn aangepast.
- Verwijderen laat zien welke VM's zijn verwijderd.


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