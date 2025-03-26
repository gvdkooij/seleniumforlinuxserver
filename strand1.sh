set -x
sudo apt update
sudo apt upgrade -y
sudo touch /var/run/reboot-required.skip
sudo apt install -y python3-pip
echo 'export PATH="$HOME/.local/bin:$PATH"' >> ~/.bashrc
source ~/.bashrc
export PATH="$PATH:$HOME/.local/bin"
pip install selenium
sudo apt-get install -y unzip xvfb libxi6 libgconf-2-4 jq libjq1 libonig5 libxkbcommon0 libxss1 libglib2.0-0 libnss3   libfontconfig1 libatk-bridge2.0-0 libatspi2.0-0 libgtk-3-0 libpango-1.0-0 libgdk-pixbuf2.0-0 libxcomposite1   libxcursor1 libxdamage1 libxtst6 libappindicator3-1 libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libxfixes3   libdbus-1-3 libexpat1 libgcc1 libnspr4 libgbm1 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxext6   libxrandr2 libxrender1 gconf-service ca-certificates fonts-liberation libappindicator1 lsb-release xdg-utils
wget -P ~/tmp https://storage.googleapis.com/chrome-for-testing-public/134.0.6998.88/linux64/chrome-linux64.zip
wget -P ~/tmp https://storage.googleapis.com/chrome-for-testing-public/134.0.6998.88/linux64/chromedriver-linux64.zip
wget -P ~/tmp https://storage.googleapis.com/chrome-for-testing-public/134.0.6998.88/linux64/chrome-headless-shell-linux64.zip
sudo unzip ~/tmp/chrome-linux64.zip -d /opt
sudo unzip ~/tmp/chromedriver-linux64.zip -d /opt
sudo unzip ~/tmp/chrome-headless-shell-linux64.zip -d /opt
sudo ln -s /opt/chrome-linux64/chrome /usr/local/bin/chrome
sudo ln -s /opt/chromedriver-linux64/chromedriver /usr/local/bin/chromedriver
sudo ln -s /opt/chrome-headless-shell-linux64/chrome-headless-shell /usr/local/bin/chrome-headless-shell
cd ~
sudo echo -e "from selenium import webdriver\noptions=webdriver.ChromeOptions() \noptions.add_argument(\"--headless\")  \ndriver =webdriver.Chrome(options=options)\ndriver.get(\"https://www.google.com\") \nprint(\"Pagina titel:\", driver.title) \ndriver.quit()" > test.py
python3 test.py
sudo apt install -y apache2
sudo apt install -y php libapache2-mod-php php-mysql
sudo systemctl start apache2
sudo systemctl enable apache2
pip install watchdog pillow numpy selenium webdriver-manager
cd /var/www/html
sudo mkdir uploads
sudo chmod 777 uploads
cd /var/www/html/uploads
sudo mkdir converted
sudo chmod 777 converted
cd /var/www/html
sudo curl -O https://raw.githubusercontent.com/gvdkooij/seleniumforlinuxserver/refs/heads/main/upload.php
sudo mkdir /opt/waakhond
cd /opt/waakhond
sudo curl -O https://raw.githubusercontent.com/gvdkooij/seleniumforlinuxserver/refs/heads/main/waakhond.py
sudo chmod +x waakhond.py

cd /etc/systemd/system/
sudo curl -O https://raw.githubusercontent.com/gvdkooij/seleniumforlinuxserver/refs/heads/main/waakhond.service
sudo nano /etc/systemd/system/waakhond.service
sudo systemctl daemon-reload
sudo systemctl start waakhond.service
sudo systemctl enable waakhond.service
sudo systemctl status waakhond.service










