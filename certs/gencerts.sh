#!/usr/bin/bash

# APACHE使用的憑證
mkcert -key-file apache-ssl-key.pem -cert-file apache-ssl.crt localhost

# 警告:這不是安全的作法
# 預設key產生後只有擁有者可存取,但是掛載到docker內的ap存取時不是擁有者,所以就將key都加上可讀取權限
chmod +r *-key.pem

# 產出2個檔案
# 1. apache-ssl-key.pem
# 2. apache-ssl.crt

# 除錯:確認mkcert簽出憑證合法
#openssl verify -CAfile "$(mkcert -CAROOT)/rootCA.pem" apache-ssl.crt

# SSL連線除錯用
#openssl x509 -in apache-ssl.crt -noout -subject -purpose -ext subjectAltName,keyUsage,extendedKeyUsage,nsComment