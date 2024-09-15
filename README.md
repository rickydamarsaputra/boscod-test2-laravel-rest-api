## Cara Instalasi

1. clone project.
2. jalankan printah composer install untuk menginstall package.
3. jalankan perintah php artisan jwt:secret untuk generate jwt secret.
4. setup database, bisa dengan jalankan perintah php artisan migrate:fresh --seed karna sudah tersedia seeder untuk table bank dan rekening admin.
5. atau bisa import data yang sudah disediakan.
6. jangan lupa untuk setting env file terkait koneksi database dan yang lainnnya.
7. terakhir jalankan perintah php artisan serve untuk menghidupkan server.

## Dokumentasi API

#### 1. Register User

Request:

```json
curl --request POST \
--url 'http://PROJECT_URL/api/auth/register' \
--header 'Content-Type: application/json' \
--data '{
  "username": "rickydamarsaputra",
  "email": "rickydamarsaputra@gmail.com",
  "password": "12345678"
}'

```

Response:

```json
{
    "data": {
        "username": "rickydamarsaputra",
        "email": "rickydamarsaputra@gmail.com"
    }
}
```

#### 2. Login User

Request:

```json
curl --request POST \
--url 'http://PROJECT_URL/api/auth/login' \
--header 'Content-Type: application/json' \
--data '{
  "username": "rickydamarsaputra",
  "password": "12345678"
}'

```

Response:

```json
{
    "accessToken": "$accessToken",
    "refreshToken": "$refreshToken"
}
```

#### 3. Update JWT Token

Request:

```json
curl --request POST \
--url 'http://PROJECT_URL/api/auth/update-token' \
--header 'Content-Type: application/json' \
--data '{
"token":"$token"
}'
```

Response:

```json
{
    "accessToken": "$accessToken",
    "refreshToken": "$refreshToken"
}
```

#### 4. Create Transfer

Note:

-   data bank_tujuan, rekening_tujuan, atas_nama_tujuan, dan bank_Pengirim hanya dapat di isi sesuai dengan data yang terdapat di table banks dan rekening_admins selain itu akan ditolak.

Request:

```json
curl --request POST \
--url 'http://PROJECT_URL/api/transfer' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer $token' \
--data '{
  "nilai_transfer": "50000",
  "bank_tujuan": "BNI",
  "rekening_tujuan": "123456789012345",
  "atasnama_tujuan": "admin boscod 1 BNI",
  "bank_pengirim": "BCA"
}'
```

Response:

```json
{
    "id_transaksi": "TF24091500001",
    "nilai_transfer": "50000",
    "kode_unik": 647,
    "biaya_admin": 2500,
    "total_transfer": 52500,
    "bank_perantara": "BCA",
    "rekening_perantara": "123456789012345",
    "berlaku_hingga": "2024-09-16T00:00:00.000000Z"
}
```
