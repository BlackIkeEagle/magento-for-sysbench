<?php
namespace Deployer;

require 'recipe/symfony.php';

//set('ssh_multiplexing', false);

// Project name
set('application', 'magento-deploy');

// Project repository
set('repository', 'https://github.com/BlackIkeEagle/magento-for-sysbench.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

set('writable_dirs', []);

// Hosts
host('combell')
    ->hostname('ssh043.webhosting.be')
    ->forwardAgent(false)
    ->user('ikedevbe')
    ->set('deploy_path', '/data/sites/web/ikedevbe/magento-perf/{{application}}');

task('composer', 'composer install --no-dev');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:clear_paths',
    'deploy:create_cache_dir',
    'deploy:shared',
    'composer',
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');

// Display success message on completion
after('deploy', 'success');
