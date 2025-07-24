@servers(['localhost' => '127.0.0.1'])

@task('outdated', ['on' => 'localhost'])
npm run deps:check
composer deps:check
@endtask

@task('update', ['on' => 'localhost'])
npm run deps:bump
composer deps:bump
@endtask
