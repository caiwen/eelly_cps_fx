eelly_cps_fx
============

衣联网分销系统

##nginx server example
```
server
{
        listen       80;
        server_name fx.eelly.local;
        index index.php;
        root  /home/wwwroot/fx.eelly.com;

        #include rewrite/ci;
        location ~* \.(ico|css|js|gif|jpe?g|png)(\?[0-9]+)?$ {
            expires max;
            log_not_found off;
        }

        location / {
            # Check if a file or directory index file exists, else route it to index.php.
            try_files $uri $uri/ /index.php;
        }

        location ~* \.php$ {
                fastcgi_pass  backend;
                fastcgi_index index.php;
                include fcgi.conf;
        }
}
```
##Apache
1.  支持rewrite_mod
2.  支持curl

