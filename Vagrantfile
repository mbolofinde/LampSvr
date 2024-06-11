# -*- mode: ruby -*-
# vi: set ft=ruby :


Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/focal64"
  # config.vm.box_check_update = false
  # config.vm.network "forwarded_port", guest: 80, host: 8080
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
  config.vm.network "private_network", ip: "192.168.33.12"
  config.vm.network "public_network"
  config.vm.synced_folder "./data", "/vagrant_data"
  config.vm.synced_folder "./data", "/var/www/html/"

  # config.vm.synced_folder ".", "/vagrant", disabled: true
  config.vm.provider "virtualbox" do |vb|
  #   vb.gui = true
     vb.memory = "8024"
   end
  config.vm.provision "shell", inline: <<-SHELL
    sudo apt update -y
    sudo apt upgrade -y
    sudo apt install -y wget
    sudo apt install -y unzip
    sudo apt install -y apache2 
    sudo apt update -y
    sudo apt install mysql-server
   SHELL
end
