- Nama Peserta: Ardyan Satya Perkasa
- Nomor Urut: 179
- Judul Project: VitaLog Apps

Link dokumen terkait
- Project Brief : <https://dy-pro.notion.site/Project-Akhir-JDA-VitaLog-App-cc67b6c3d44e48c7b57cc02ca168c5dc>
- Desain UI (Figma) : <https://www.figma.com/design/SYljsJb6Tv6NkWhkRT3O6S/VitaLog-UI?node-id=0-1&t=HcYV1iafBtXnzEqd-1>
- ERD : <https://drive.google.com/file/d/1PWwZRl9Iq83HyV0woqOHD_tbWrNJBLMO/view?usp=sharing> & <https://dbdiagram.io/d/VitaLog_ERD-v-2-0-0-662f07f65b24a634d0060105>
- Data population: 

# :: Vitalog ::

Vitalog adalah aplikasi web yang dirancang untuk membantu pengguna dalam mengorganisir "diari medis" mereka dengan mudah. Aplikasi ini memudahkan pengguna untuk mencatat dan memantau pengukuran GCU dan tanda-tanda vital secara berkala, serta memberikan penilaian kondisi kesehatan berdasarkan data yang diinput. Dengan Vitalog, pengguna dapat lebih teratur dalam mendokumentasikan rekam medis, memvisualisasikan data kesehatan, penjadwalan pengukuran secara teratur dan mempersiapkan dokumentasi yang diperlukan untuk komunikasi yang lebih efektif saat berkonsultasi dengan dokter.

![Screenshot of the application](images/screenshots/screencapture-vitalog-test-preview.png)

## :: Fitur Utama :: *Minimum Requirement - total progress: 100%*

1. **Autentikasi Pengguna** *tersedia di ver. 1.0.0 - progress: 100%*
    - Fitur registrasi untuk pengguna baru
    - Pengguna baru dapat login menggunakan email dan password untuk menjaga keamanan data mereka.

2. **CRUD (Create, Read, Update, Delete)** *tersedia di ver. 1.0.0 - progress: 100%*
    1. **Input Data Pengukuran GCU & Vital Signs**
        - Formulir input yang intuitif untuk mencatat data vital signs, glukosa, kolesterol, dan asam urat.
        - Validasi input memastikan bahwa data yang dimasukkan adalah valid dan akurat.

    2. **Tampilan Record Data**
        - Detail pada setiap catatan pengukuran dengan informasi after/before meal, lokasi dan device pengukuran.
        - Tampilan historis dan kronologis dari semua catatan yang telah dimasukkan.
    
    3. **Update Data Pengukuran GCU & Vital Signs**
        - Mengubah record data pengukuran GCU dan vital signs.

    4. **Delete Data Pengukuran GCU & Vital Sign**
        - Menghapus data pengukuran GCU dan vital signs 

## :: Fitur Penunjang :: *Nilai tambah - progress: 33%*

1. **User Interface** *tersedia di ver. 1.0.0 - progress: 100%*
    - Dark mode otomatis berdasarkan pengaturan sistem di device pengguna

2. **GCU Level Indicator** *tersedia di ver. 1.0.0 - progress: 100%*
    - Penilaian status kondisi kesehatan pengguna berdasarkan rentang nilai pengukuran GCU ditampilkan dalam warna yang mewakili level GCU.
      - Merah untuk glucose: diabetes / cholesterol: hiperkolesterolemia / asam urat: hiperurisemia. 
      - Kuning untuk glucose pre diabetes / cholesterol: borderline high / asam urat: hipourisemia
      - Hijau untuk glucose: normal /cholesterol: normal / asam urat: normal

3. **Filter Data** *Next update*
    - Filter dan pencarian data memudahkan pengguna dalam menemukan catatan pengukuran tertentu.

4. **Grafik dan Visualisasi** *Next update*
    - Visualisasi data rekam medis dalam bentuk grafik line chart atau bar chart untuk memudahkan pemantauan tren kesehatan.

5. **Penjadwalan Pengukuran** *Next update*
    - Fitur penjadwalan pengukuran serta status pelaksanaannya.

6. **Export Data** *Next update*
    - Opsi untuk mengekspor data ke dalam format PDF atau Excel untuk keperluan dokumentasi dan print-out.

## :: Sasaran Pengguna ::

Vitalog dirancang untuk digunakan oleh semua kalangan yang peduli terhadap pemantauan kesehatan mereka, mulai dari individu yang ingin mengelola kesehatan secara mandiri hingga tenaga medis yang membutuhkan alat bantu dalam pengawasan kondisi pasien.

### Disclaimer
Meskipun fitur indikator penilaian kesehatan Vitalog memberikan gambaran, konsultasi dengan dokter tetap diperlukan untuk evaluasi yang yang komprehensif.


Terima kasih kepada [Jabar Digital Academy](https://digitalacademy.jabarprov.go.id/) dan [Alkademi](https://alkademi.id/) atas dukungannya dalam pengembangan aplikasi ini.