 set -x
sudo adduser --disabled-password --gecos "" gvdkooij
echo "gvdkooij:Rijnweg201" | sudo chpasswd
sudo usermod -aG sudo gvdkooij
sudo mkdir -p /home/gvdkooij/scripts
sudo chown gvdkooij:gvdkooij /home/gvdkooij/scripts
sudo -u gvdkooij curl -o /home/gvdkooij/scripts/strand1.sh https://raw.githubusercontent.com/gvdkooij/seleniumforlinuxserver/refs/heads/m>
sudo -u gvdkooij chmod +x /home/gvdkooij/scripts/strand1.sh
sudo -u gvdkooij /home/gvdkooij/scripts/strand1.sh
