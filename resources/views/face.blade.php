<!-- resources/views/face.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Face Recognition</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-white font-sans flex flex-col items-center overflow-hidden">

  <!-- Header -->
  <div class="w-full bg-blue-800 text-white px-6 py-5 text-left">
    <h1 class="text-xl font-bold">Hallo, User!</h1>
    <p class="mt-2 text-sm">
      Ayo absen dulu di sini.<br>
      Pastikan wajah kamu terlihat jelas dan berada tepat di depan kamera, ya!
    </p>
  </div>

  <!-- Kamera -->
  <div class="relative w-full max-w-xs sm:max-w-sm mt-6 mb-4 aspect-[3/4] rounded-lg overflow-hidden">
    <video id="video" autoplay muted playsinline class="absolute w-full h-full object-cover rounded-lg"></video>
    <canvas id="overlay" class="absolute w-full h-full top-0 left-0"></canvas>
    <div class="absolute top-[10%] left-[10%] w-[80%] h-[80%] border-4 border-white rounded pointer-events-none"></div>
</div>

  <!-- Tombol -->
  <div class="flex justify-center gap-4 w-full max-w-xs px-4 mb-6">
    <button class="flex-1 py-2 rounded-lg border-2 border-blue-800 text-blue-800 font-semibold hover:bg-blue-50">Retake</button>
    <button class="next flex-1 py-2 rounded-lg bg-blue-800 text-white font-semibold hover:bg-blue-900">
  Next
</button>

  </div>

  <!-- Script Face API -->
  <script src="https://unpkg.com/face-api.js@0.22.2/dist/face-api.min.js"></script>
  <script src="{{ asset('js/camera.js') }}"></script>
</body>
</html>
