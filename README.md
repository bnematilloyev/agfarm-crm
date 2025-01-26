## Drugs stylelarni o`zgartirish tartibi

Agar sizda nodejs yo\`q bo\`lsa nodejs ni o\`rnating. [Nodejsni o`rnatish uchun ushbu havolani bosing.](https://nodejs.org/en/)
 
````
Agar sizda gulp-cli yo`q bo`lsa gulp-cli ni o`rnating

npm i gulp-cli
````

````
Terminal orqali proekt papkasiga kiring va ushbu komandani yozing

npm install
````

Drugsda uchta site bor. Hammasini sass, css, js filelari alohida !!!

- api.agfarm.uz
- cabinet.agfarm.uz 
- agfarm.uz

Agarda siz leasingdagi styleni o\`zgartirmoqchi bo\`lsangiz terminalga ushbu komandani yozing

````
gulp leasing
````

Hech qanday xatolik bo\`lmasa `/leasing/web/sass/` ga kirib `_custom.scss` dan yangi stylelarni qo\`shishingiz mumkun, mavjud style ni o\`zgartirmoqchi bo\`lsangiz shu `example.scss` fileni toping.

Agarda siz lawyerdagi styleni o\`zgartirmoqchi bo\`lsangiz terminalga ushbu komandani yozing

````
gulp lawyer
````

Hech qanday xatolik bo\`lmasa `/lawyer/web/sass/` ga kirib `_custom.scss` dan yangi stylelarni qo\`shishingiz mumkun, mavjud style ni o\`zgartirmoqchi bo\`lsangiz shu `example.scss` fileni toping.

Agarda siz invstordagi styleni o\`zgartirmoqchi bo\`lsangiz terminalga ushbu komandani yozing

````
gulp investor
````

Hech qanday xatolik bo\`lmasa `/investor/web/sass/` ga kirib `_custom.scss` dan yangi stylelarni qo\`shishingiz mumkun, mavjud style ni o\`zgartirmoqchi bo\`lsangiz shu `example.scss` fileni toping. Css ga kompilyatsiya bo\`lishini kuting.

O\`zgarishlarni kiritib bo\`lgach `commit` qilayotganingizda `example.css`, `main.scss` ikkalasini ham belgilang qolib ketmasin. 

Proyektdagi o\`zgarishlarni avtomatik ravishda brauzerda chiqazib beradigan instrument ishlatilgan.

Proyekt ildizida `gulpfile.js` degan file bor.

Pasdagi `proxy` dagi link bilan sizning `local` dagi yaratgan domeningiz bir xil bo\`lishi shart !!! Ushbu sozlama Workify niki.

````
gulp.task('browser-sync-leasing', function () {
    browserSync.init({
        proxy: 'crm.workify.local/',
        notify: false,
        online: true,
        open: true,
        cors: true,
        ui: false
    });
});
````
