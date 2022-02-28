<?php

namespace Deployer;

require 'recipe/symfony.php';

// Project name
set('application', 'sgtuggen');

// Project repository
set('repository', 'git@github.com:mjanser/sg-tuggen-website.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', ['public/.htaccess', '.env.local']);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', ['var']);

// Hosts

host('gogan.ch')
    ->set('http_user', 'goganch')
    ->setRemoteUser('goganch')
    ->setDeployPath('~/www/sgtuggen.gogan.ch');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

//before('deploy:symlink', 'database:migrate');
