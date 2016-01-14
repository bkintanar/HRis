[![Author](https://img.shields.io/badge/author-@bkintanar-blue.svg?style=flat-square)](https://twitter.com/bkintanar) [![Build Status](https://img.shields.io/travis/bkintanar/HRis/api/develop.svg?style=flat-square)](https://travis-ci.org/bkintanar/HRis) [![SensioLabsInsight](https://img.shields.io/sensiolabs/i/76b2c9fd-06e0-4fbc-a325-f76eab8cfb34.svg?style=flat-square)](https://insight.sensiolabs.com/projects/76b2c9fd-06e0-4fbc-a325-f76eab8cfb34) [![StyleCI](https://styleci.io/repos/29657205/shield)](https://styleci.io/repos/29657205)

# .htaccess Information

```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]

    RewriteCond %{HTTP:Authorization} ^(.*)
    RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
</IfModule>
```
