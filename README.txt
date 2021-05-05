Because passwords are hashed before inserted to database with php for first sign-in use:

Supervisor----->email:t.kipriadis@gmail.com password:23102310
Employe----->email:lefteris@gmail.com password:23102310


/////////////////////////////////////////////////////////

After changing php ini and sendemail ini at xamp home folder restart Apache service (Stop and start again)


/////////////////////////////////////////////////////////

Complete installation guide for XAMP :

-Install XAMP

-Install Apache and mySQL services in your XAMP control panel

-Initiate Apache and mySQL services

-Open htdocs folder located inside the XAMP home directory

-Place Documentation and public_html files in htdocs folder

-At XAMP control panel click Admin button at mySQL module

-You can create a new database user and define its parameters or you can leave it default with username:root and without password

-Import database dump file at phpmyadmin panel file name ---->db_dump.sql

-Configure the email system described in previous section above

-You are ready to go . Open your browser and follow links : localhost/public_html and localhost/documentantion

