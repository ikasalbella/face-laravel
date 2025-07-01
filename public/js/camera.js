// public/js/camera.js

const video = document.getElementById('video');
const overlay = document.getElementById('overlay');
const ctx = overlay.getContext('2d');
const nextBtn = document.querySelector('.next');

// Default: tombol next nonaktif
nextBtn.disabled = true;
nextBtn.classList.add('opacity-50', 'cursor-not-allowed');

Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('/models')
]).then(startVideo);

function startVideo() {
  navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
      video.srcObject = stream;
      video.addEventListener('playing', onPlay);
    })
    .catch(err => {
      console.error('❌ Gagal akses kamera:', err);
      alert("Kamera tidak bisa diakses: " + err.message);
    });
}

async function onPlay() {
  overlay.width = video.videoWidth;
  overlay.height = video.videoHeight;

  const displaySize = { width: video.videoWidth, height: video.videoHeight };
  faceapi.matchDimensions(overlay, displaySize);

  setInterval(async () => {
    const detections = await faceapi
      .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
      .withFaceLandmarks();

    const resized = faceapi.resizeResults(detections, displaySize);
    ctx.clearRect(0, 0, overlay.width, overlay.height);
    faceapi.draw.drawDetections(overlay, resized);
    faceapi.draw.drawFaceLandmarks(overlay, resized);

    if (detections.length > 0) {
      // Wajah terdeteksi
      nextBtn.disabled = false;
      nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
      // Tidak ada wajah
      nextBtn.disabled = true;
      nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
  }, 300);
}

// Bagian atas: load face-api, start kamera, onPlay()

// Bagian bawah: tombol Next
document.querySelector('.next').addEventListener('click', async () => {
  const detections = await faceapi
    .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
    .withFaceLandmarks();

  const status = detections.length > 0 ? 'berhasil' : 'gagal';

  fetch('/face/absen', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
  body: JSON.stringify({ hasil: status })
})
.then(res => res.text())  // ubah jadi text()
.then(text => {
  console.log('Response:', text); // cek apa isinya
  try {
    const data = JSON.parse(text); // coba parse ke JSON
    if (data.redirect) {
      window.location.href = data.redirect;
    } else {
      alert('Gagal redirect');
    }
  } catch (e) {
    alert('Bukan JSON:\n' + text); // tampilkan isi sebenarnya
  }
})
.catch(err => alert('Gagal kirim data: ' + err));

});
