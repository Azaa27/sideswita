# Tabel Bab IV — Transformasi Data Transaksi ke Matriks Biner

Letakkan bagian ini setelah pembahasan prapemrosesan data transaksi dan sebelum tahapan perhitungan Apriori. Ganti nomor `4.x` sesuai urutan tabel pada naskah Bab IV.

**Pengantar siap-tempel**

> Sebelum proses pencarian frequent itemset dilakukan, data transaksi berstatus selesai ditransformasikan ke dalam bentuk matriks biner. Nilai `1` menunjukkan bahwa suatu produk muncul minimal satu kali pada transaksi tersebut, sedangkan nilai `0` menunjukkan produk tidak muncul. Kuantitas pembelian tidak digunakan pada tahap ini karena algoritma Apriori menganalisis keberadaan item dalam satu keranjang transaksi. Tabel berikut menunjukkan sampel data hasil transformasi.

**Tabel 4.x Transformasi Data Transaksi ke Matriks Biner**

| Kode transaksi | PW-01 | PW-02 | PW-03 | PW-04 | PW-05 | MD-01 | MD-02 | MD-03 | MD-04 | MD-05 | MD-06 | MD-07 | MD-08 |
| --- | ---: | ---: | ---: | ---: | ---: | ---: | ---: | ---: | ---: | ---: | ---: | ---: | ---: |
| SIM-0001 | 1 | 0 | 0 | 0 | 0 | 1 | 0 | 1 | 0 | 0 | 1 | 0 | 0 |
| SIM-0013 | 1 | 0 | 0 | 0 | 0 | 0 | 1 | 1 | 0 | 0 | 0 | 0 | 0 |
| SIM-0161 | 0 | 1 | 0 | 0 | 0 | 0 | 0 | 1 | 0 | 0 | 0 | 0 | 1 |
| SIM-0164 | 0 | 1 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 1 | 1 |
| SIM-0281 | 0 | 0 | 1 | 0 | 0 | 0 | 0 | 0 | 1 | 1 | 0 | 0 | 0 |
| SIM-0288 | 0 | 0 | 1 | 0 | 0 | 1 | 0 | 0 | 0 | 1 | 0 | 0 | 0 |
| SIM-0372 | 0 | 0 | 0 | 1 | 0 | 0 | 1 | 1 | 0 | 0 | 0 | 0 | 0 |
| SIM-0375 | 0 | 0 | 0 | 1 | 0 | 0 | 0 | 1 | 0 | 0 | 0 | 0 | 0 |
| SIM-0441 | 0 | 0 | 0 | 0 | 1 | 0 | 1 | 0 | 0 | 0 | 1 | 1 | 0 |
| SIM-0444 | 0 | 0 | 0 | 0 | 1 | 0 | 0 | 0 | 0 | 0 | 1 | 0 | 0 |

**Keterangan kode produk**

| Kode | Produk | Kode | Produk |
| --- | --- | --- | --- |
| PW-01 | Edukasi Pertanian | MD-01 | Kopi Jalatrang |
| PW-02 | Alam Trekking | MD-02 | Gula Aren |
| PW-03 | Budaya Sunda | MD-03 | Keripik Singkong |
| PW-04 | Foto Sawah | MD-04 | Anyaman Bambu |
| PW-05 | Seharian Penuh | MD-05 | Batik Jalatrang |
|  |  | MD-06 | Madu Hutan |
|  |  | MD-07 | Tas Pandan |
|  |  | MD-08 | Topi Anyaman Pandan |

**Penjelasan setelah tabel**

> Berdasarkan matriks biner tersebut, setiap baris diperlakukan sebagai satu keranjang transaksi dan setiap kolom sebagai item. Data kemudian digunakan untuk menghitung nilai support, confidence, dan lift. Hanya transaksi dengan status `completed` yang dipakai dalam kalkulasi agar rekomendasi berasal dari pemesanan yang benar-benar selesai.

> Sumber: Data transaksi aplikasi Jalatrang Wisata, diolah (2026).
