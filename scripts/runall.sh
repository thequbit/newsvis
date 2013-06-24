#!/bin/bash

export WORKON_HOME=/home/administrator/.virtualenvs

source /etc/bash_completion.d/virtualenvwrapper

# enter virt env
workon newsvis

# run our script
cd /home/administrator/dev/newsvis/scripts/ && python wham_scraper.py
cd /home/administrator/dev/newsvis/scripts/ && python whec_scraper.py
cd /home/administrator/dev/newsvis/scripts/ && python rhp_scraper.py

# leave virt env
deactivate

