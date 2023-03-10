Pythagor App Project for INFO-C451
==============
Functionality
-------------
Pythagor is a simple Web App with three principal accounts. The admin account can manage, change, and delete an account; The professor account for managing classes and students, and the student account can take the assignment and manage the course. We Have some functionality like Search.

Usability
----------
This Application could help trace the student lifecycle and professor work. It could help the professor get the eagle eyes on student works.

Reliability
-----------
Pythagor Have a solid and secure Maria DB database http://173.255.197.34/phpmyadmin/
Sitting in www.cloud.linode.com. This database is replicated in the western region, meaning we will have a backup recovery in a disaster case. Pythagor Web App http://173.255.197.34/index.php   is stored on a secure subnet behind the firewall and app load balancer, which means all the security setup is in place. The repository for the Version control system is on GitHub https://github.com/ngahadjo/pythagor; the pipeline is not in place yet but will be for the next deployment.

Performance
-----------
The Pythagor app could help the user manage and search want they want in database

Supportability
--------------
The app is in PHP and can run with chrome, Mozilla, or browse. It is light and could be accessible on the phone too. The DNS is not ready and in place yet, but the Server could support up to 10000 users
