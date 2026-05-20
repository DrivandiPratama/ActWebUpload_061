<?php
// Hapus file jika parameter hapus ada
if (isset($_GET['hapus'])) {
    $file = "uploads/" . basename($_GET['hapus']);

    if (file_exists($file)) {
        unlink($file);
    }

    header("Location: lihat.php");
    exit;
}

$files = scandir("uploads/");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Unggah dan Daftar Berkas</title>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    margin: 0;
    padding: 40px;
}

.container {
    max-width: 1000px;
    margin: auto;
    background: #ffffff;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.title {
    text-align: center;
    color: #1e3a8a;
    margin-bottom: 30px;
    font-size: 32px;
}

/* ===== Upload Box ===== */
.upload-box {
    display: block;
    border: 2px dashed #93c5fd;
    background: #f8fafc;
    border-radius: 15px;
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
    margin-bottom: 20px;
}

.upload-box:hover {
    background: #eff6ff;
    border-color: #2563eb;
}

.upload-box input {
    display: none;
}

.upload-icon {
    font-size: 48px;
    margin-bottom: 10px;
}

.upload-text {
    color: #374151;
    font-size: 16px;
    line-height: 1.6;
}

.upload-text strong {
    color: #2563eb;
}

.file-name {
    margin-top: 15px;
    color: #2563eb;
    font-weight: 600;
    word-break: break-word;
}

/* ===== Preview ===== */
.preview {
    text-align: center;
    margin-bottom: 20px;
}

.preview img {
    max-width: 220px;
    max-height: 220px;
    border-radius: 12px;
    border: 1px solid #d1d5db;
    display: none;
}

/* ===== Buttons ===== */
.btn-upload {
    width: 100%;
    padding: 14px;
    background: #0ea5e9;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    margin-bottom: 40px;
}

.btn-upload:hover {
    background: #0284c7;
}

.btn-download,
.btn-delete {
    display: inline-block;
    padding: 7px 12px;
    border-radius: 6px;
    color: white;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    margin: 2px;
}

.btn-download {
    background: #16a34a;
}

.btn-download:hover {
    background: #15803d;
}

.btn-delete {
    background: #dc2626;
}

.btn-delete:hover {
    background: #b91c1c;
}

/* ===== Table ===== */
.section-title {
    text-align: center;
    color: #1e3a8a;
    margin-bottom: 20px;
    font-size: 28px;
}

table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

th {
    background: #2563eb;
    color: white;
    padding: 14px;
    font-size: 15px;
}

td {
    padding: 14px;
    text-align: center;
    border-bottom: 1px solid #e5e7eb;
}

tr:hover {
    background: #f8fafc;
}

.preview-thumb {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #d1d5db;
}

.no-preview {
    color: #9ca3af;
    font-style: italic;
}

.empty {
    text-align: center;
    padding: 30px;
    color: #6b7280;
    font-style: italic;
}

/* ===== Responsive ===== */
@media (max-width: 768px) {
    body {
        padding: 20px;
    }

    .container {
        padding: 20px;
    }

    .title {
        font-size: 24px;
    }

    .section-title {
        font-size: 22px;
    }

    .btn-download,
    .btn-delete {
        display: block;
        margin: 4px auto;
    }

    .preview-thumb {
        width: 60px;
        height: 60px;
    }
}
</style>
</head>
<body>

<div class="container">

    <!-- FORM UPLOAD (hanya satu kali) -->
    <h1 class="title">Unggah File</h1>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label class="upload-box">
            <input type="file" name="fileToUpload" id="fileToUpload" required>

            <div class="upload-icon">📁</div>

            <div class="upload-text">
                <strong>Klik untuk memilih file</strong><br>
                atau drag & drop file di sini
            </div>

            <div class="file-name" id="fileName"></div>
        </label>

        <div class="preview">
            <img id="previewImage" alt="Preview Gambar">
        </div>

        <button type="submit" class="btn-upload">
            Unggah File
        </button>
    </form>

    <!-- DAFTAR FILE -->
    <h2 class="section-title">Daftar Berkas yang Diunggah</h2>

    <table>
        <tr>
            <th>Preview</th>
            <th>Nama File</th>
            <th>Aksi</th>
        </tr>

        <?php
        $adaFile = false;

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $adaFile = true;
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                echo "<tr>";

                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    echo "<td>
                            <img class='preview-thumb'
                                 src='uploads/$file'
                                 alt='Preview'>
                          </td>";
                } else {
                    echo "<td>
                            <span class='no-preview'>
                                Tidak ada preview
                            </span>
                          </td>";
                }

                echo "<td>$file</td>";

                echo "<td>
                        <a class='btn-download'
                           href='uploads/$file'
                           download>
                           Unduh
                        </a>

                        <a class='btn-delete'
                           href='lihat.php?hapus=$file'
                           onclick=\"return confirm('Yakin ingin menghapus file ini?')\">
                           Hapus
                        </a>
                      </td>";

                echo "</tr>";
            }
        }

        if (!$adaFile) {
            echo "<tr>
                    <td colspan='3' class='empty'>
                        Belum ada file yang diunggah.
                    </td>
                  </tr>";
        }
        ?>
    </table>

</div>

<script>
const input = document.getElementById('fileToUpload');
const fileName = document.getElementById('fileName');
const previewImage = document.getElementById('previewImage');

input.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
        fileName.textContent = file.name;

        if (file.type.startsWith('image/')) {
            previewImage.src = URL.createObjectURL(file);
            previewImage.style.display = 'inline-block';
        } else {
            previewImage.style.display = 'none';
        }
    }
});
</script>

</body>
</html>