<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'traqbar');

// Project repository
set('repository', 'git@github.com:leighgregg/traqbar.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts



host('192.46.236.198')
	->stage('production')
    ->user('leo')
    ->port(22)
    #->configFile('~/.ssh/config')
    #->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(false)
    ->multiplexing(true)
    ->set('deploy_path', '/var/www/{{application}}');   

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');


