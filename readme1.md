# Hướng dẫn chạy và cài đặt phụ thuộc cho dự án
1. **Đầu tiên cài php 8.2.7 trở lên (ưu tiên 8.2.10) cho đồng bộ**
2. **Cài đặt biến môi trường cho php (Environment variable) sau đó kiểm tra bằng cmd bằng  `php -v`** 
3. **download fiile php_grpc [Tại đây](https://phpdev.toolsforresearch.com/php-8.2.7-Win32-vs16-x64-grpc-protobuf.zip)**
    -  Sau khi cài đặt xong thì thêm file php_grpc vào thư mục ext trong php
    - truy cập tải file php.ini này về [Tại đây](https://drive.google.com/file/d/1Dm_g0b6VUjrfHsMHZVCUPf_XTTCyu59U/view?usp=drive_link)
    - paste file php.ini vào thư mục php. Mở nó lên bằng notepad kiểm tra *extension=grpc* đã được bỏ comment chưa 
4. **Download file  cacert.pem [Tại đây](https://curl.se/docs/caextract.html)**
    - paste file cacert.pem vào thư mục php
    - mở file php.ini vào tìm kiếm `curl.cainfo` gán cho nó bằng đường dẫn của file *cacert.pem* và bỏ comment 
5. **download file json dùng để authen với firebase [Tại đây](https://drive.google.com/file/d/1thTvYlsnpxuFrk3e5lXz68oNv4Yb3Wzg/view?usp=drive_link) paste file vào project tại vị trí projectName/file.json**
    - 
6. **Mở project lên và mở cmd để hoạt động ***Chạy các lệnh sau*****
```
    composer install
    cp .env.example .env
    php artisan key:generate

```
7. **Mở file .env và paste đoạn code này vào bất kì đâu**
> FIREBASE_CREDENTIALS="foodapp-be64c-firebase-adminsdk-hmmb6-faaf4cfdfd.json"\
> FIREBASE_DATABASE_URL= "https://foodapp-be64c-default-rtdb.firebaseio.com/" \
> FIREBASE_STORAGE_DEFAULT_BUCKET= "foodapp-be64c.appspot.com"

8. **Chạy project bằng lệnh**
```
    php artisan serve

```
