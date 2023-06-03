@servers(['develop' => 'afaqy@212.70.49.197 -p 11011', 'test' => 'afaqy@212.70.49.197 -p 11011', 'stage' => 'afaqy@212.70.49.197 -p 11011', 'uat' => 'afaqy@212.70.49.197 -p 11011'])

@story('deploy')
    @if ($branch == 'develop')
        deploy_develop
        develop_installation
    @endif
    @if ($branch == 'test')
        deploy_test
        develop_installation
    @endif
    @if ($branch == 'stage')
        deploy_stage
        pre_production_installation
    @endif
    @if ($branch == 'uat')
        deploy_uat
        pre_production_installation
    @endif
@endstory


@task('deploy_develop', ['on' => 'develop'])
    cd /var/www/dev/api
    git reset --hard origin/develop
    git pull origin develop
@endtask

@task('deploy_test', ['on' => 'test'])
    cd /var/www/test/api
    git reset --hard origin/test
    git pull origin test
@endtask

@task('deploy_stage', ['on' => 'stage'])
    cd /var/www/stage/api
    git reset --hard origin/stage
    git pull origin stage
@endtask

@task('deploy_uat', ['on' => 'uat'])
    cd /var/www/uat/api
    git reset --hard origin/uat
    git pull origin uat
@endtask

@task('develop_installation')
    @if ($branch == 'develop')
        cd /var/www/dev/api
    @endif
    @if ($branch == 'test')
        cd /var/www/test/api
    @endif
    composer install
    php artisan migrate
    {{-- php artisan migrate:fresh -/-seed --}}
    {{-- php artisan passport:client -/-password --}}
    php artisan module:seed -qn
    php artisan optimize:clear
    php artisan optimize
    php artisan l5-swagger:generate
@endtask

@task('pre_production_installation')
    @if ($branch == 'stage')
        cd /var/www/stage/api
    @endif
    @if ($branch == 'uat')
        cd /var/www/uat/api
    @endif
    composer install
    php artisan migrate
    php artisan optimize:clear
    php artisan optimize
    php artisan l5-swagger:generate
@endtask
