
sudo apt-get update

sudo apt-get install -y apache2
sudo apt-get install -y php5 libapache2-mod-php5 php5-fpm php5-cli php5-gd php5-mysql

sudo sed -i 's/display_errors = .*/display_errors = On/g' /etc/php5/cli/php.ini
sudo sed -i 's/display_startup_errors = .*/display_startup_errors = Off/g' /etc/php5/cli/php.ini
sudo sed -i 's/html_errors = .*/html_errors = Off/g' /etc/php5/cli/php.ini
sudo sed -i 's/track_errors = .*/track_errors = On/g' /etc/php5/cli/php.ini

sudo sed -i 's/display_errors = .*/display_errors = On/g' /etc/php5/apache2/php.ini
sudo sed -i 's/display_startup_errors = .*/display_startup_errors = Off/g' /etc/php5/clapache2/apache2.ini
sudo sed -i 's/html_errors = .*/html_errors = Off/g' /etc/php5/apache2/php.ini
sudo sed -i 's/track_errors = .*/track_errors = On/g' /etc/php5/apache2/php.ini

sudo sed -i 's/display_errors = .*/display_errors = On/g' /etc/php5/fpm/php.ini
sudo sed -i 's/display_startup_errors = .*/display_startup_errors = Off/g' /etc/php5/fpm/php.ini
sudo sed -i 's/html_errors = .*/html_errors = Off/g' /etc/php5/fpm/php.ini
sudo sed -i 's/track_errors = .*/track_errors = On/g' /etc/php5/fpm/php.ini

debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo apt-get install -y mysql-client mysql-server

sudo rm -rf /etc/apache2/sites-enabled/*
sudo rm -rf /etc/apache2/sites-available/*

sudo cp /vagrant/apache-host.conf /etc/apache2/sites-available/default.conf

sudo a2ensite default.conf

sudo service apache2 restart
