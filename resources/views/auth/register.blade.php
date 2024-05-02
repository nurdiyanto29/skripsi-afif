<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registration or Sign Up form in HTML CSS | CodingLab </title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #4070f4;
    }

    .wrapper {
        position: relative;
        max-width: 430px;
        width: 100%;
        background: #fff;
        padding: 34px;
        border-radius: 6px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .wrapper h2 {
        position: relative;
        font-size: 22px;
        font-weight: 600;
        color: #333;
    }

    .wrapper h2::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 28px;
        border-radius: 12px;
        background: #4070f4;
    }

    .wrapper form {
        margin-top: 30px;
    }

    .wrapper form .input-box {
        height: 52px;
        margin: 18px 0;
    }

    form .input-box input {
        height: 100%;
        width: 100%;
        outline: none;
        padding: 0 15px;
        font-size: 17px;
        font-weight: 400;
        color: #333;
        border: 1.5px solid #C7BEBE;
        border-bottom-width: 2.5px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .input-box input:focus,
    .input-box input:valid {
        border-color: #4070f4;
    }

    form .policy {
        display: flex;
        align-items: center;
    }

    form h3 {
        color: #707070;
        font-size: 14px;
        font-weight: 500;
        margin-left: 10px;
    }

    .input-box.button input {
        color: #fff;
        letter-spacing: 1px;
        border: none;
        background: #4070f4;
        cursor: pointer;
    }

    .input-box.button input:hover {
        background: #0e4bf1;
    }

    form .text h3 {
        color: #333;
        width: 100%;
        text-align: center;
    }

    form .text h3 a {
        color: #4070f4;
        text-decoration: none;
    }

    form .text h3 a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="wrapper">
        <h2>Registrasi</h2>
        <form method="POST" action="{{ route('post_register') }}" method="POST">
            @csrf
            <div class="input-box">
                <input type="text" placeholder="Nama" name="name" required>
            </div>
            <div class="input-box">
                <input type="email" placeholder="Email" name="email" id="email" required>
            </div>
            @error('email')
                <div style="color: red">{{ $message }}</div>
            @enderror
            <div class="input-box">
                <input type="text" placeholder="NO Tlp" name="no_tlp" id="no_tlp" required>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Alamat" name="alamat" required>
            </div>

            Jenis Kelamin
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="L"
                    checked>
                <label class="form-check-label" for="exampleRadios1">
                    Laki-laki
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="P">
                <label class="form-check-label" for="exampleRadios2">
                    Perempuan
                </label>
            </div>




            <div class="input-box">
                <input type="password" placeholder="Password" name="password" required>
            </div>

            <div class="input-box button">
                <input type="Submit" value="Register Now">
            </div>
            <div class="text">
                <h3>Sudah punya akun? <a href="login">Login</a></h3>
            </div>
        </form>
    </div>
</body>
<script>
    // Ambil elemen input
    var inputNoTlp = document.getElementById('no_tlp');

    // Tambahkan event listener untuk memantau input
    inputNoTlp.addEventListener('input', function(event) {
        // Dapatkan nilai input
        var inputValue = event.target.value;

        // Hapus karakter selain angka menggunakan regular expression
        var sanitizedValue = inputValue.replace(/\D/g, '');

        // Periksa apakah nilai input telah berubah setelah dibersihkan
        if (inputValue !== sanitizedValue) {
            // Jika nilai input berubah, setel nilai input ke nilai yang telah dibersihkan
            event.target.value = sanitizedValue;
        }
    });


    var inputEmail = document.getElementById('email');

    // Tambahkan event listener untuk memantau input
    inputEmail.addEventListener('blur', function(event) {
        // Dapatkan nilai input
        var inputValue = event.target.value;

        // Buat regular expression untuk memeriksa format email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Periksa apakah nilai input cocok dengan format email
        if (!emailRegex.test(inputValue)) {
            // Jika tidak cocok, tampilkan pesan peringatan
            alert('Format email tidak valid. Silakan masukkan email yang valid.');
            // Hapus nilai input yang tidak valid
            event.target.value = '';
            // Fokuskan kembali ke input email
            event.target.focus();
        }
    });
</script>

</html>
