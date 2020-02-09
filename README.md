# About
Ansible orchestrator is een school opdracht, voor VM2. De bedoeling is om via Ansible automatisch een VM aan te maken.

## Requirements
```
De playbooks zijn getest met de volgende configuratie:

Ansible 2.9.3 (python 3)
pyvmomi 6.7 (python 3)
uuidgen
VMWare Vcenter 6.7u1
```

## Usage
``` 
``` 

## Test/Debug
```
Gebruik de volgende commando om snel te debuggen:
ansible-playbook site.yml -e "menu_voornaam=michael menu_achternaam=hajjar menu_bedrijfsnaam=DUO menu_env=productie menu_platform=vmware menu_flavor=micro.1 menu_vm=aanmaken menu_klant=nieuw ansible_python_interpreter=/usr/local/bin/python3" -vvvv
```
