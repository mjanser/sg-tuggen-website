<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/symfony.php';

// Project name
set('application', 'sgtuggen');

// Project repository
set('repository', 'git@github.com:mjanser/sg-tuggen-website.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);
set('bin/php', '/usr/local/php82/bin/php');
set('bin/composer', '/usr/local/php82/bin/php /usr/local/bin/composer');

// Shared files/dirs between deploys
add('shared_files', ['public/.htaccess', '.env.local']);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', ['var']);

// Hosts

host('gogan.ch')
    ->set('http_user', 'goganch')
    ->setRemoteUser('goganch')
    ->setDeployPath('~/www/sgtuggen.gogan.ch')
;
host('demo.gogan.ch')
    ->set('hostname', 'gogan.ch')
    ->set('http_user', 'goganch')
    ->setRemoteUser('goganch')
    ->setDeployPath('~/www/demo-sgtuggen.gogan.ch')
    ->set('bin/php', '/usr/local/php83/bin/php')
    ->set('bin/composer', '/usr/local/php83/bin/php /usr/local/bin/composer')
;

// Tasks

task('deploy:asset-map:compile', function () {
    run('{{bin/console}} asset-map:compile {{console_options}}');
});

after('deploy:cache:clear', 'deploy:dump-env');
after('deploy:cache:clear', 'deploy:asset-map:compile');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

// before('deploy:symlink', 'database:migrate');
