<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-xl shadow w-full max-w-md text-center">

    <h2 class="text-xl font-bold mb-6">Masukkan Kode OTP</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/verifikasi-otp">
        @csrf

        <div class="flex justify-center gap-2 mb-6">
            @for($i=0; $i<6; $i++)
                <input type="text" maxlength="1"
                    class="otp-input w-12 h-12 text-center border rounded text-lg"
                    required>
            @endfor
        </div>

        <input type="hidden" name="otp" id="otp">

        <button class="w-full bg-pink-600 text-white py-2 rounded hover:bg-pink-700">
            Verifikasi
        </button>
    </form>

</div>

<script>
    const inputs = document.querySelectorAll('.otp-input');
    const hidden = document.getElementById('otp');

    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            let otp = '';
            inputs.forEach(i => otp += i.value);
            hidden.value = otp;
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
</script>

</body>
</html>