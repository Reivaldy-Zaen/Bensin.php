<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian Bahan Bakar</title>
    <style>
        body {
            text-align: center;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-size: cover;
            color: black;
            background-image: url(https://media.suara.com/pictures/653x366/2022/09/07/28312-shell-spbu-shell-bensin-shell-ilustrasi-spbu-shell.jpg);
        }

        #container {
            width: 55%;
            margin: 50px auto;
            background-color: rgba(25, 0, 0, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: yellow;
            font-size: 28px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #fff;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        select,
        input[type="number"] {
            width: calc(55% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: calc(35% - 20px);
            padding: 15px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: red;
        }

        hr {
            border: none;
            border-top: 1px dashed #ccc;
            margin: 20px 0;
        }

        .bukti-transaksi {
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 50px;
            background-color: #fff;
            color: #000;
            
        }

        @media screen and (max-width: 600px) {
            #container {
                width: 90%;
                margin: 20px auto;
            }

            h2 {
                font-size: 24px;
            }
        }
        @media print {
            body {
                visibility: hidden;
            }

            #container,
            #container * {
                visibility: visible;
            }

            form,
            label,
            select,
            input,
            button {
                display: none !important;
            }
        }


    </style>
</head>

<body>
    <div id="container">
        <img src="image/shel.png.png" alt="Logo Shell" style="width: 70px; margin-right: 90%;">
        <h2>Shell Bensin</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="jenis">Jenis Bahan Bakar:</label>
            <select id="jenis" name="jenis">
                <option value="Shell Super">Shell Super</option>
                <option value="Shell V-Power">Shell V-Power</option>
                <option value="Shell V-Power Diesel">Shell V-Power Diesel</option>
                <option value="Shell V-Power Nitro">Shell V-Power Nitro</option>
            </select>
            <br><br>
            <label for="jumlah">Jumlah Liter:</label>
            <input type="number" id="jumlah" name="jumlah" min="0" step="1" required>
            <br><br>
            <label for="Metode_Pembayaran">Metode Pembayaran :</label> <!-- Ganti "for" atribut -->
            <select id="Metode_Pembayaran" name="Metode_Pembayaran">
                <option value="Tunai">Tunai</option>
                <option value="Dana">DANA</option>
                <option value="OVO">OVO</option>
                <option value="Gopay">Gopay</option>
            </select>
            <br><br>
            <button type="submit">Beli</button>

        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Periksa apakah data sudah dikirim melalui metode POST
        
            class Shell
            {
                protected $jenis;
                protected $harga;
                protected $jumlah;
                protected $ppn;

                public function __construct($jenis, $harga, $jumlah)
                {
                    $this->jenis = $jenis;
                    $this->harga = $harga;
                    $this->jumlah = $jumlah;
                    $this->ppn = 10; // PPN tetap 10%
                }

                public function getJenis()
                {
                    return $this->jenis;
                }

                public function getHarga()
                {
                    return $this->harga;
                }

                public function getJumlah()
                {
                    return $this->jumlah;
                }

                public function getPpn()
                {
                    return $this->ppn;
                }
            }

            class Beli extends Shell
            {
                private $metodePembayaran;

                public function __construct($jenis, $harga, $jumlah, $metodePembayaran)
                {
                    parent::__construct($jenis, $harga, $jumlah);
                    $this->metodePembayaran = $metodePembayaran;
                }

                public function hitungTotal()
                {
                    $total = $this->harga * $this->jumlah;
                    $total += $total * $this->ppn / 100;
                    return $total;
                }

                public function buktiTransaksi()
                {
                    $total = $this->hitungTotal();
                    echo "<div class='bukti-transaksi'>";
                    echo "<hr>"; // Garis putus-putus sebelum output
                    echo "<h3>Bukti Transaksi:</h3>";
                    echo "<p><strong>Anda membeli bahan bakar minyak dengan tipe :</strong> " . $this->jenis . "</p>";
                    echo "<p><strong>dengan jumlah :</strong> " . $this->jumlah . " Liter</p>"; // Menambahkan kata "Liter"
                    echo "<p><strong>Metode Pembayaran :</strong> " . $this->metodePembayaran . "</p>"; // Menampilkan metode pembayaran
                    echo "<p><strong>Total yang harus anda bayar:</strong> Rp " . number_format($total, 2, ',', '.') . "</p>";
                    echo "<hr>"; // Garis putus-putus setelah output
                    echo "<button onclick='printTransaksi()'>Cetak Bukti Transaksi</button>";
                    echo "</div>";
                }
            }

            $hargaBahanBakar = [
                "Shell Super" => 15420.00,
                "Shell V-Power" => 16130.00,
                "Shell V-Power Diesel" => 18310.00,
                "Shell V-Power Nitro" => 16510.00,
            ];

            $jenis = $_POST["jenis"];
            $jumlah = $_POST["jumlah"];
            $metodePembayaran = $_POST["Metode_Pembayaran"]; // Ambil nilai dari select box metode pembayaran
        
            if (array_key_exists($jenis, $hargaBahanBakar)) {
                $harga = $hargaBahanBakar[$jenis];
                $beli = new Beli($jenis, $harga, $jumlah, $metodePembayaran); // Tambahkan parameter metode pembayaran
                $beli->buktiTransaksi();
            } else {
                echo "<p style='text-align: center;'>Jenis bahan bakar tidak valid.</p>";
            }
        }
        ?>
        <script>
            function printTransaksi() {
                window.print();
            }
        </script>

    </div>
</body>

</html>