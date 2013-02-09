set :application, "SG Tuggen Website"
set :domain,      "sgtuggen.gogan.ch"
set :user,        "goganch"
set :deploy_to,   "/home/goganch/www/demo.#{domain}"
set :app_path,    "app"
set :php_bin,     "php -d detect_unicode=Off -d allow_url_fopen=On"

set :repository,  "https://github.com/mjanser/sg-tuggen-website.git"
set :scm,         :git

set :model_manager, "doctrine"

role :web,        domain
role :app,        domain
role :db,         domain, :primary => true

set  :keep_releases,       3
set  :use_sudo,            false
set  :use_composer,        true
set  :copy_vendors,        true
set  :dump_assetic_assets, true

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,   [app_path + "/logs", app_path + "/data"]

# Be more verbose by uncommenting the following line
#logger.level = Logger::MAX_LEVEL

task :initdb do
  capifony_pretty_print "--> Drop the database"
  run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} doctrine:database:drop --force --env=#{symfony_env_prod}'"
  capifony_puts_ok
  capifony_pretty_print "--> Create the database"
  run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} doctrine:database:create --env=#{symfony_env_prod}'"
  capifony_puts_ok
  capifony_pretty_print "--> Initialize PHPCR"
  run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} doctrine:phpcr:init:dbal --env=#{symfony_env_prod}'"
  capifony_puts_ok
  capifony_pretty_print "--> Register system node types"
  run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} doctrine:phpcr:register-system-node-types --env=#{symfony_env_prod}'"
  capifony_puts_ok
  capifony_pretty_print "--> Load fixtures"
  run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} doctrine:phpcr:fixtures:load --env=#{symfony_env_prod}'"
  capifony_puts_ok
end

after "deploy", "initdb"
after "deploy", "deploy:cleanup"
