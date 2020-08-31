# Project Starter Wordpress

Digunakan untuk memulai projek website dengan framework Wordpress.

## Instalasi

Pertama buat dulu personal token untuk mengakses github, klik [disini](https://gitlab.com/profile/personal_access_tokens)

Kemudian rubah config composer untuk gitlab, ketikan:

```bash
composer config --global --auth gitlab-token.gitlab.com <token>
```

Selanjutnya gunakan project manager [composer](https://getcomposer.org/) untuk menginstall tools ini

```bash
composer create-project isfawwaz/wedangpress <folder-name> --repository='{"type": "vcs", "url": "https://github.com/isfawwaz/wedangpress.git"}'
```

atau

```bash
composer create-project isfawwaz/wedangpress <folder-name> --repository='{"type": "github", "url": "https://github.com/isfawwaz/wedangpress.git"}'
```

## Pengaturan

Sebelum mengedit pengaturan, sebaiknya jalankan perintah berikut:

```bash
composer install --optimize-autoloader
```

Pertama kali yang harus dilakukan adalah membuat file config, ada beberapa file dengan tujuan yang berbeda diataranya:
- `live-config.php` untuk kebutuhan live website
- `staging-config.php` untuk kebutuhan pada server stagging
- `local-config.php` untuk kebutuhan local development

Kamu bisa melihat contoh config yang harus dibuat pada file `wp-config-example.php`, kemudian isikan value pada variable - variable yang ada

```bash
cp -i wp-config-example.php <filename>
```

## Install Wordpress

Pastikan di pc atau laptop kamu sudah terinstall [wp-cli](https://developer.wordpress.org/cli/)

```bash
wp core install --url=WEBURL --title="TITLE" --admin_user=USERNAME --admin_password=PASSWORD --admin_email=EMAIL
```

## Update wordpress

Pastikan di pc atau laptop kamu sudah terinstall [wp-cli](https://developer.wordpress.org/cli/)

```bash
wp core update
```

## Buat Ulang Salt

Pastikan di pc atau laptop kamu sudah terinstall [wp-cli](https://developer.wordpress.org/cli/)

```bash
wp config shuffle-salts
```

## Mengaktifkan Tema

Untuk mengaktifkan tema, jalankan perintah berikut:

```bash
wp theme activate batik
```

## Update Plugin & Tema

Edit `composer.json` dan rubah versi plugin ke versi terbaru

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
