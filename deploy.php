<?php

namespace Deployer;

require 'recipe/common.php';

set('application', 'sgtuggen');
set('repository', 'git@github.com:mjanser/sg-tuggen-website.git');
set('git_tty', true);
set('http_user', 'goganch');
add('shared_files', ['public/.htaccess', '.env']);
add('shared_dirs', []);
set('writable_dirs', ['var']);

host('gogan.ch')
    ->user('goganch')
    ->set('deploy_path', '~/www/sgtuggen.gogan.ch');

desc('Clear cache');
task('deploy:cache:clear', function () {
    run('{{bin/php}} {{release_path}}/bin/console cache:clear');
});

desc('Deploy project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:cache:clear',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

after('deploy', 'success');
after('deploy:failed', 'deploy:unlock');
