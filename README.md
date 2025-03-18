# seleniumforlinuxserver
This descripes how to install selenium on a linux server

sudo adduser gvdkooij

sudo usermod -aG sudo gvdkooij

su gvdkooij

sudo apt update

sudo apt upgrade

sudo apt install -y python3-pip

echo 'export PATH="$HOME/.local/bin:$PATH"' >> ~/.bashrc
source ~/.bashrc

pip install selenium

sudo apt-get install -y unzip xvfb libxi6 libgconf-2-4 jq libjq1 libonig5 libxkbcommon0 libxss1 libglib2.0-0 libnss3   libfontconfig1 libatk-bridge2.0-0 libatspi2.0-0 libgtk-3-0 libpango-1.0-0 libgdk-pixbuf2.0-0 libxcomposite1   libxcursor1 libxdamage1 libxtst6 libappindicator3-1 libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libxfixes3   libdbus-1-3 libexpat1 libgcc1 libnspr4 libgbm1 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxext6   libxrandr2 libxrender1 gconf-service ca-certificates fonts-liberation libappindicator1 lsb-release xdg-utils

wget -P ~/Downloads https://storage.googleapis.com/chrome-for-testing-public/134.0.6998.88/linux64/chrome-linux64.zip

wget -P ~/Downloads https://storage.googleapis.com/chrome-for-testing-public/134.0.6998.88/linux64/chromedriver-linux64.zip

wget -P ~/Downloads https://storage.googleapis.com/chrome-for-testing-public/134.0.6998.88/linux64/chrome-headless-shell-linux64.zip

sudo unzip ~/Downloads/chrome-linux64.zip -d /opt

sudo unzip ~/Downloads/chromedriver-linux64.zip -d /opt

sudo unzip ~/Downloads/chrome-headless-shell-linux64.zip -d /opt

rm  -r ~/Downloads

sudo ln -s /opt/chrome-linux64/chrome /usr/local/bin/chrome

sudo ln -s /opt/chromedriver-linux64/chromedriver /usr/local/bin/chromedriver

sudo ln -s /opt/chrome-headless-shell-linux64/chrome-headless-shell /usr/local/bin/chrome-headless-shell


echo -e "from selenium import webdriver\noptions=webdriver.ChromeOptions() \noptions.add_argument(\\\"--headless\\\")  \ndriver =webdriver.Chrome(options=options)\ndriver.get(\\\"https://www.google.com\") \nprint(\\\"Pagina titel:\\\", driver.title) \ndriver.quit()" > test.py

python3 test.py








