VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu/trusty64"

  config.vm.synced_folder ".", "/vagrant/", :owner => 'www-data', :group => 'www-data'
  
  config.vm.network "forwarded_port", guest: 80, host: 3510
  
  config.vm.provision "shell", path: "box.sh"

  config.vm.provider "virtualbox" do |v|
    v.memory = 512
    v.cpus = 1
  end

end
