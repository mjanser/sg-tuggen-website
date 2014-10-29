# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "hashicorp/precise64"

  config.vm.network :private_network, ip: "192.168.222.10"
  config.vm.hostname = "sgtuggen.lo"

  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder ".", "/vagrant_data"

  config.vm.provision :chef_solo do |chef|
    chef.cookbooks_path = "chef/"
    chef.add_recipe "cookbook"
  end
end
