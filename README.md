
````markdown
# 🤖 Chatbot Auto-replay with Laravel

**Lapor Infra** merupakan chatbot auto-replay yang digunakan untuk menangani laporan kendala jaringan di OPD Kota Pekanbaru.  
Proyek ini dikembangkan sebagai bagian dari **Magang di Dinas Komunikasi, Informatika, Statistik, dan Persandian Kota Pekanbaru (Februari – Juni 2025).**

---

## 📌 Tentang
Chatbot ini membantu:
- 📡 Menangani laporan gangguan jaringan dari pengguna di OPD.
- 💬 Memberikan auto-reply sesuai jenis kendala.
- 🛠️ Menyediakan panel admin untuk mengelola laporan dan pengguna.

---

## ⚙️ Instruksi Instalasi

### 📋 Persyaratan Sistem
Pastikan sistem telah terpasang:
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

---

### 🚀 Langkah-langkah Instalasi

1. **Clone atau unzip project**, lalu buka di code editor (misalnya Visual Studio Code).

2. **Install dependensi PHP** dengan Composer:
   ```bash
   composer install
````

3. **Atur konfigurasi `.env`** sesuai kebutuhan:

   ```env
   APP_NAME=ChatBot
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=password
   ```

4. **Generate key aplikasi**:

   ```bash
   php artisan key:generate
   ```

5. **Migrasi & seeder database**:

   ```bash
   php artisan migrate --seed
   ```

6. **Install frontend assets**:

   ```bash
   npm install
   npm run build
   npm run dev
   ```

7. **Jalankan server lokal**:

   ```bash
   php artisan serve
   ```

   Akses aplikasi di browser:
   👉 [http://127.0.0.1:8000](http://127.0.0.1:8000)

8. **Tampilan Admin**
   Akses di browser:
   👉 [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

   Login menggunakan akun default:

   ```
   Email:    admin@example.com
   Password: password
   ```

---

## 🖼️ Tampilan Sistem

### 👤 User

![User View](images/user-view.png)

### 🛠️ Admin

![Admin View](images/admin-view.png)

> 📌 Simpan screenshot ke dalam folder `images/` lalu ganti sesuai nama file.

---

## 👨‍💻 Author

* **Bayu Pratama Agus Kurniawan**
  📍 Teluk Belitung, Kepulauan Meranti, Riau
  📧 [Email](mailto:bayupratamaaguskurniawan@gmail.com)
  🔗 [LinkedIn](https://www.linkedin.com/in/bayu-pratama-agus-kurniawan/) | [GitHub](https://github.com/bayupra7ama)

---

## 📜 Lisensi

Proyek ini bersifat open-source dan tersedia di bawah lisensi [MIT](LICENSE).

```

---

Kamu tinggal paste ini ke file `README.md` di repo GitHub.  
Mau saya bikinkan juga **contoh screenshot dummy** (gambar placeholder) supaya langsung tampil di `README.md` sebelum kamu punya screenshot asli?
```
