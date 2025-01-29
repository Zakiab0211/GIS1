
# import pandas as pd
# import matplotlib.pyplot as plt
# import matplotlib.dates as mdates
# import os

# # Path ke folder yang berisi file CSV
# folder_path = r'D:/BACKUP/KULIAH/SMTR 7/dokumentasi coba/pengujian 10-200user dlm 1 menit'

# # Menyiapkan list untuk menyimpan nama file CSV
# csv_files = [f for f in os.listdir(folder_path) if f.endswith('.csv')]

# # Membuat figure untuk grafik
# plt.figure(figsize=(12, 10))

# # Inisialisasi variabel untuk kategori
# cpu_usage_files = [f for f in csv_files if "CPU_utilization" in f]
# mem_usage_files = [f for f in csv_files if "mem_used_percent" in f]
# network_packet_files = [f for f in csv_files if "Network_packets_out" in f]

# # Membuat subplots untuk 3 jenis metrik: CPU, Memori, dan Network Packet Out
# fig, axes = plt.subplots(3, 1, figsize=(12, 18))

# # Fungsi untuk membaca dan mengonversi CSV, serta membuat grafik
# def plot_data(file_list, ax, label_prefix):
#     for csv_file in file_list:
#         file_path = os.path.join(folder_path, csv_file)
#         data = pd.read_csv(file_path)

#         # Menampilkan beberapa baris pertama untuk memeriksa struktur data
#         print(f"Data dari {csv_file}:")
#         print(data.head())
        
#         # Mengonversi kolom pertama menjadi datetime jika ada
#         if '2024' in str(data.iloc[0, 0]):  # Asumsi kolom pertama adalah tanggal waktu
#             data.iloc[:, 0] = pd.to_datetime(data.iloc[:, 0], errors='coerce')
        
#         # Pastikan kolom kedua berisi data numerik
#         data.iloc[:, 1] = pd.to_numeric(data.iloc[:, 1], errors='coerce')

#         # Plot data sesuai label prefix (misalnya CPU, Memori, atau Network Packet)
#         ax.plot(data.iloc[:, 0], data.iloc[:, 1], label=csv_file)

# # Plot untuk CPU Usage
# plot_data(cpu_usage_files, axes[0], "CPU Utilization")
# axes[0].set_title('Penggunaan CPU (%)')
# axes[0].set_xlabel('Waktu')
# axes[0].set_ylabel('Persentase (%)')

# # Menyesuaikan sumbu waktu agar sesuai dengan periode 1 jam
# axes[0].xaxis.set_major_formatter(mdates.DateFormatter('%H:%M'))
# axes[0].xaxis.set_major_locator(mdates.HourLocator(interval=1))

# # Plot untuk Memori Usage
# plot_data(mem_usage_files, axes[1], "Memori Utilization")
# axes[1].set_title('Penggunaan Memori (%)')
# axes[1].set_xlabel('Waktu')
# axes[1].set_ylabel('Persentase (%)')

# # Menyesuaikan sumbu waktu agar sesuai dengan periode 1 jam
# axes[1].xaxis.set_major_formatter(mdates.DateFormatter('%H:%M'))
# axes[1].xaxis.set_major_locator(mdates.HourLocator(interval=1))

# # Plot untuk Network Packet Out
# plot_data(network_packet_files, axes[2], "Network Packet Out")
# axes[2].set_title('Paket Jaringan Keluar (Paket per Detik)')
# axes[2].set_xlabel('Waktu')
# axes[2].set_ylabel('Paket per Detik (kpps)')

# # Menyesuaikan sumbu waktu agar sesuai dengan periode 1 jam
# axes[2].xaxis.set_major_formatter(mdates.DateFormatter('%H:%M'))
# axes[2].xaxis.set_major_locator(mdates.HourLocator(interval=1))

# # Menambahkan legenda di bawah grafik
# fig.legend(loc='lower center', bbox_to_anchor=(0.5, -0.05), ncol=5, fontsize=10)

# # Menyimpan grafik sebagai file PDF
# plt.tight_layout()
# plt.savefig('grafik_pengujian_berjenjang.pdf')

# # Menampilkan grafik
# plt.show()

import pandas as pd
import matplotlib.pyplot as plt
import matplotlib.dates as mdates
import os

# Path ke folder yang berisi file CSV
folder_path = r'D:/BACKUP/KULIAH/SMTR 7/dokumentasi coba/pengujian 10-200user dlm 1 menit'

# Menyiapkan list untuk menyimpan nama file CSV
csv_files = [f for f in os.listdir(folder_path) if f.endswith('.csv')]

# Membuat figure untuk grafik
plt.figure(figsize=(12, 10))

# Inisialisasi variabel untuk kategori
cpu_usage_files = [f for f in csv_files if "CPU_utilization" in f]
mem_usage_files = [f for f in csv_files if "mem_used_percent" in f]
network_packet_files = [f for f in csv_files if "Network_packets_out" in f]

# Membuat subplots untuk 3 jenis metrik: CPU, Memori, dan Network Packet Out
fig, axes = plt.subplots(3, 1, figsize=(12, 18))

# Fungsi untuk membaca dan mengonversi CSV, serta membuat grafik
def plot_data(file_list, ax, label_prefix, color):
    for csv_file in file_list:
        file_path = os.path.join(folder_path, csv_file)
        data = pd.read_csv(file_path)

        # Menampilkan beberapa baris pertama untuk memeriksa struktur data
        print(f"Data dari {csv_file}:")
        print(data.head())
        
        # Mengonversi kolom pertama menjadi datetime jika ada
        if '2024' in str(data.iloc[0, 0]):  # Asumsi kolom pertama adalah tanggal waktu
            data.iloc[:, 0] = pd.to_datetime(data.iloc[:, 0], errors='coerce')
        
        # Pastikan kolom kedua berisi data numerik
        data.iloc[:, 1] = pd.to_numeric(data.iloc[:, 1], errors='coerce')

        # Plot data sesuai label prefix (misalnya CPU, Memori, atau Network Packet) dengan warna tertentu
        ax.plot(data.iloc[:, 0], data.iloc[:, 1], label=f'{label_prefix} {csv_file}', color=color)

# Plot untuk CPU Usage
plot_data(cpu_usage_files, axes[0], "CPU Utilization", color='red')
axes[0].set_title('Penggunaan CPU (%)')
axes[0].set_xlabel('Waktu')
axes[0].set_ylabel('Persentase (%)')

# Menyesuaikan sumbu waktu agar sesuai dengan periode 1 jam, dengan interval 5 menit
axes[0].xaxis.set_major_formatter(mdates.DateFormatter('%H:%M'))
axes[0].xaxis.set_major_locator(mdates.MinuteLocator(interval=5))

# Plot untuk Memori Usage
plot_data(mem_usage_files, axes[1], "Memori Utilization", color='blue')
axes[1].set_title('Penggunaan Memori (%)')
axes[1].set_xlabel('Waktu')
axes[1].set_ylabel('Persentase (%)')

# Menyesuaikan sumbu waktu agar sesuai dengan periode 1 jam, dengan interval 5 menit
axes[1].xaxis.set_major_formatter(mdates.DateFormatter('%H:%M'))
axes[1].xaxis.set_major_locator(mdates.MinuteLocator(interval=5))

# Plot untuk Network Packet Out
plot_data(network_packet_files, axes[2], "Network Packet Out", color='green')
axes[2].set_title('Paket Jaringan Keluar (Paket per Detik)')
axes[2].set_xlabel('Waktu')
axes[2].set_ylabel('Paket per Detik (kpps)')

# Menyesuaikan sumbu waktu agar sesuai dengan periode 1 jam, dengan interval 5 menit
axes[2].xaxis.set_major_formatter(mdates.DateFormatter('%H:%M'))
axes[2].xaxis.set_major_locator(mdates.MinuteLocator(interval=5))

# Menambahkan legenda di bawah grafik
fig.legend(loc='lower center', bbox_to_anchor=(0.5, -0.05), ncol=3, fontsize=10)

# Menyimpan grafik sebagai file PDF
plt.tight_layout()
plt.savefig('grafik_pengujian_berjenjang_5menit.pdf')

# Menampilkan grafik
plt.show()
