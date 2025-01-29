# import pandas as pd
# import matplotlib.pyplot as plt
# from fpdf import FPDF
# import os

# # Fungsi untuk membersihkan dan memproses data
# def process_cloudwatch_data(file_path):
#     try:
#         # Membaca file CSV dengan pemisah titik koma
#         data = pd.read_csv(file_path, sep=';')

#         # Print nama-nama kolom untuk debugging
#         print("Columns in the CSV file:", data.columns)

#         # Perbaiki kolom Timestamp (sesuaikan dengan format yang benar)
#         # Jika format Timestamp berbeda, sesuaikan dengan format yang benar.
#         data['Timestamp'] = pd.to_datetime(data['Timestamp'], format='%d/%m/%Y %H.%M', errors='coerce')

#         # Hapus baris dengan nilai NaT pada Timestamp
#         data = data.dropna(subset=['Timestamp'])

#         # Periksa apakah ada kolom yang hilang
#         required_columns = ['Timestamp', 'CPUUtilization', 'NetworkPacketsOut', 'NetworkOut', 'StatusCheckFailed']
#         for col in required_columns:
#             if col not in data.columns:
#                 raise ValueError(f"Missing required column: {col}")
        
#         # Perbaiki format angka dengan mengganti titik pemisah ribuan
#         def convert_to_numeric(value):
#             try:
#                 # Mengganti titik dengan kosong dan mengonversi ke angka
#                 return pd.to_numeric(value.replace('.', ''), errors='coerce')
#             except Exception as e:
#                 return value
        
#         # Terapkan pembersihan angka pada kolom-kolom numerik
#         data['NetworkPacketsOut'] = data['NetworkPacketsOut'].apply(convert_to_numeric)
#         data['NetworkOut'] = data['NetworkOut'].apply(convert_to_numeric)
#         data['CPUUtilization'] = data['CPUUtilization'].apply(lambda x: float(x.replace(' %', '').replace(',', '') if isinstance(x, str) else x))

#         # Menampilkan beberapa statistik untuk memastikan bahwa data sudah benar
#         print("Summary Statistics:")
#         print(data.describe())
        
#         return data
#     except Exception as e:
#         print(f"Error processing file: {e}")
#         return None

# # Fungsi untuk membuat grafik
# def plot_metrics(data, output_dir):
#     metrics = ['CPUUtilization', 'NetworkPacketsOut', 'NetworkOut', 'StatusCheckFailed']
#     plots = []

#     for metric in metrics:
#         plt.figure(figsize=(10, 6))
#         plt.plot(data['Timestamp'], data[metric], label=metric, color='blue')
#         plt.title(f"{metric} Over Time")
#         plt.xlabel("Timestamp")
#         plt.ylabel(metric)
#         plt.xticks(rotation=45)
#         plt.grid()
#         plt.legend()
#         plt.tight_layout()
        
#         # Simpan grafik sebagai gambar
#         plot_file = os.path.join(output_dir, f"{metric}.png")
#         plt.savefig(plot_file)
#         plots.append(plot_file)
#         plt.close()
    
#     return plots

# # Fungsi untuk membuat file PDF
# def generate_pdf(plots, output_pdf):
#     pdf = FPDF()
#     pdf.set_auto_page_break(auto=True, margin=15)

#     for plot in plots:
#         pdf.add_page()
#         pdf.set_font("Arial", size=12)
#         pdf.cell(200, 10, txt=os.path.basename(plot), ln=True, align='C')
#         pdf.image(plot, x=10, y=30, w=190)
    
#     pdf.output(output_pdf)
#     print(f"PDF Report saved to {output_pdf}")

# # Main function
# if __name__ == "__main__":
#     # Path ke file CSV dan output
#     input_file = "D:/BACKUP/KULIAH/SMTR 7/dokumentasi coba/pengujian.csv"  # Ubah sesuai lokasi file Anda
#     output_dir = "output_plots"
#     output_pdf = "CloudWatch_Metrics_Report.pdf"

#     # Membuat folder output jika belum ada
#     os.makedirs(output_dir, exist_ok=True)

#     # Memproses data CSV
#     data = process_cloudwatch_data(input_file)
#     if data is not None:
#         # Membuat grafik
#         plots = plot_metrics(data, output_dir)

#         # Menghasilkan file PDF
#         generate_pdf(plots, output_pdf)




import pandas as pd
import matplotlib.pyplot as plt
from fpdf import FPDF
import os

# Fungsi untuk membersihkan dan memproses data
def process_cloudwatch_data(file_path):
    try:
        # Membaca file CSV dengan pemisah titik koma
        data = pd.read_csv(file_path, sep=';')

        # Print nama-nama kolom untuk debugging
        print("Columns in the CSV file:", data.columns)

        # Perbaiki kolom Timestamp (sesuaikan dengan format yang benar)
        data['Timestamp'] = pd.to_datetime(data['Timestamp'], format='%d/%m/%Y %H.%M', errors='coerce')

        # Hapus baris dengan nilai NaT pada Timestamp
        data = data.dropna(subset=['Timestamp'])

        # Periksa apakah ada kolom yang hilang
        required_columns = ['Timestamp', 'CPUUtilization', 'NetworkPacketsOut', 'NetworkOut', 'StatusCheckFailed']
        for col in required_columns:
            if col not in data.columns:
                raise ValueError(f"Missing required column: {col}")
        
        # Perbaiki format angka dengan mengganti titik pemisah ribuan
        def convert_to_numeric(value):
            try:
                return pd.to_numeric(value.replace('.', ''), errors='coerce')
            except Exception as e:
                return value
        
        # Terapkan pembersihan angka pada kolom-kolom numerik
        data['NetworkPacketsOut'] = data['NetworkPacketsOut'].apply(convert_to_numeric)
        data['NetworkOut'] = data['NetworkOut'].apply(convert_to_numeric)
        data['CPUUtilization'] = data['CPUUtilization'].apply(lambda x: float(x.replace(' %', '').replace(',', '') if isinstance(x, str) else x))

        # Menampilkan beberapa statistik untuk memastikan bahwa data sudah benar
        print("Summary Statistics:")
        print(data.describe())
        
        return data
    except Exception as e:
        print(f"Error processing file: {e}")
        return None

# Fungsi untuk membuat grafik batang combo
def plot_metrics(data, output_dir):
    metrics = ['CPUUtilization', 'NetworkPacketsOut', 'NetworkOut', 'StatusCheckFailed']
    plots = []

    # Hitung rata-rata untuk setiap metrik
    averages = {
        'CPUUtilization': data['CPUUtilization'].mean(),
        'NetworkPacketsOut': data['NetworkPacketsOut'].mean(),
        'NetworkOut': data['NetworkOut'].mean(),
        'StatusCheckFailed': data['StatusCheckFailed'].mean()
    }

    # Membuat grafik combo (batang + garis) untuk setiap metrik
    for metric in metrics:
        plt.figure(figsize=(10, 6))
        
        # Membuat grafik batang untuk metrik pertama (misalnya NetworkOut)
        if metric == 'NetworkOut':
            plt.bar(data['Timestamp'], data[metric], label=metric, color='lightblue', width=0.5)
            plt.ylabel(metric)
            plt.title(f"{metric} Over Time")
        
        # Membuat grafik garis untuk metrik lainnya (misalnya CPUUtilization)
        else:
            plt.plot(data['Timestamp'], data[metric], label=metric, color='red', marker='o', linestyle='-', linewidth=2)
            plt.ylabel("Metrics Value")

        plt.xlabel("Timestamp")
        plt.xticks(rotation=45)
        plt.grid(True)
        plt.legend()
        plt.tight_layout()
        
        # Simpan grafik sebagai gambar
        plot_file = os.path.join(output_dir, f"{metric}_combo_chart.png")
        plt.savefig(plot_file)
        plots.append(plot_file)
        plt.close()
    
    return plots, averages

# Fungsi untuk membuat file PDF
def generate_pdf(plots, averages, output_pdf):
    pdf = FPDF()
    pdf.set_auto_page_break(auto=True, margin=15)

    # Menambahkan grafik ke dalam PDF
    for plot in plots:
        pdf.add_page()
        pdf.set_font("Arial", size=12)
        pdf.cell(200, 10, txt=os.path.basename(plot), ln=True, align='C')
        pdf.image(plot, x=10, y=30, w=190)

    # Menambahkan tabel rata-rata di bawah grafik
    pdf.add_page()
    pdf.set_font("Arial", size=12)
    pdf.cell(200, 10, txt="Average Metrics Table", ln=True, align='C')
    
    # Menambahkan data rata-rata ke dalam tabel PDF
    pdf.ln(10)  # Tambahkan sedikit jarak sebelum tabel
    pdf.cell(50, 10, 'Metric', border=1, align='C')
    pdf.cell(50, 10, 'Average Value', border=1, align='C')
    pdf.ln(10)

    for metric, avg in averages.items():
        pdf.cell(50, 10, metric, border=1, align='C')
        pdf.cell(50, 10, f'{avg:.2f}', border=1, align='C')
        pdf.ln(10)

    pdf.output(output_pdf)
    print(f"PDF Report saved to {output_pdf}")

# Main function
if __name__ == "__main__":
    # Path ke file CSV dan output
    input_file = "D:/BACKUP/KULIAH/SMTR 7/dokumentasi coba/pengujian.csv"  # Ubah sesuai lokasi file Anda
    output_dir = "output_plots"
    output_pdf = "CloudWatch_Metrics_Report.pdf"

    # Membuat folder output jika belum ada
    os.makedirs(output_dir, exist_ok=True)

    # Memproses data CSV
    data = process_cloudwatch_data(input_file)
    if data is not None:
        # Membuat grafik combo dan mendapatkan rata-rata
        plots, averages = plot_metrics(data, output_dir)

        # Menghasilkan file PDF dengan grafik dan tabel rata-rata
        generate_pdf(plots, averages, output_pdf)



