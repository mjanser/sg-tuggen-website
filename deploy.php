<?php

namespace Deployer;

require 'recipe/symfony.php';

set('application', 'sgtuggen');
set('repository', 'git@github.com:mjanser/sg-tuggen-website.git');
set('git_tty', true);
add('shared_files', ['public/.htaccess']);
add('shared_dirs', []);
add('writable_dirs', []);

host('gogan.ch')
    ->user('goganch')
    ->set('deploy_path', '~/www/sgtuggen.gogan.ch');

task('build', function () {
    run('cd {{release_path}} && build');
});

after('deploy:failed', 'deploy:unlock');
