var gulp = require('gulp');
var browserSync = require('browser-sync').create();
// var siteName = '45.172.207.124';
var siteName = 'localhost';

var paths = {
    php: [
        'config/cms.php',
        'resources/views/**/*',
        'app/Models/**/*',
    ],
    scripts: [
        'resources/assets/sistema/css/**/*.css',
        'resources/assets/sistema/alunos/dist/css/**/*.css',
        'resources/assets/sistema/dash-professor/css/**/*.css',
        'resources/assets/sistema/js/**/*',
        'resources/assets/sistema/alunos/dist/js/**/*',
        'resources/assets/sistema/dash-professor/js/**/*',
        'resources/assets/backend/**/*',
    ]
};

gulp.task('default', function() {
    browserSync.init({
        proxy: 'http://' + siteName + '/guitarpedia-novo',
        host: siteName,
        open: 'internal',
        port: 8888
    });

    gulp.watch(paths.php).on('change', browserSync.reload);
    gulp.watch(paths.scripts).on('change', browserSync.reload);

});