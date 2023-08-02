# pro-active-shopping-experience
codilar hackathon


Team Name - 

Team Members:-

            - Lehan Max Dsouza      - lehanmax.d@codilar.com
            - Sachin Kumar Biswal   - sachin.b@codilar.com
            - Sanjay Kumar Das      - sanjay.d@codilar.com
            - Bhaktahari Pallai     - bhaktahari.p@codilar.com
            
                    
How to Setup the Project
========================

   Clone the git repo (:- pro-active-shopping-experience
      
      Step -1
      -------
        - you must need to be clone inside this directory /var/www/html/(folderName(upto-you))
         
        - sudo git clone https://github.com/itzsanjayCodilar/pro-active-shopping-experience.git  (select main branch)
         
        - composer install
         
     Step -2
     -------
          
       - If any issue on step -1 then install the pre-requirement for magento -2.4.5 (https://experienceleague.adobe.com/docs/commerce-operations/installation-guide/system-requirements.html?lang=en)
          
       - setup database

             sudo bin/magento setup:install --base-url=http://hackathon.local/ --db-host=localhost --db-name=hackathon --db-user=root --db-password=password --admin-firstname=Sanjay --admin-  lastname=Das --admin-email=sanjay.d@codilar.com --admin-user=hackathon --admin-password=hackathon123 --language=en_US --currency=USD --timezone=America/Chicago --use-rewrites=1 --search-engine=elasticsearch7 --elasticsearch-host=localhost --elasticsearch-port=9200     
         
    Step -3
    -------
        - Do nginx configuration
           
        - cd /etc/nginx/sites-available
        - sudo nano fileName
           
        - add below code
		  upstream fastcgi_backend {
		   server unix:/var/run/php/php8.1-fpm.sock;
		  } 
		  server {
		  listen 80;
		  server_name hackathon.local;
		  set $MAGE_ROOT /var/www/html/hackathon;
		  set $MAGE_RUN_TYPE website;
		  include /var/www/html/hackathon/nginx.conf.sample;
		  }
		  
           - sudo ln -s /etc/nginx/sites-available/hackathon /etc/nginx/sites-enabled/   -- symlink
           
           - also you need to add the url into host file(/etc/hosts (hackathon.local))			          					

      
      



Branch Creation Rules:-

    branch name should be start with number like below 
        
        - 1-database-install
        
        

