<style>
    .running-text-wrapper {
        flex-grow: 1;
        max-width: 600px;
        overflow: hidden;
        white-space: nowrap;
        background: rgba(13, 110, 253, 0.08);
        border-radius: 20px;
        padding: 3px 12px;
        border: 1px solid rgba(13, 110, 253, 0.15);
        transition: background-color 0.5s ease;
    }

    .running-text-wrapper.highlight {
        background: rgba(25, 135, 84, 0.25) !important;
        /* Efek highlight hijau saat ada pembayaran */
        border-color: #198754 !important;
    }

    .running-text-content {
        display: inline-block;
        padding-left: 100%;
        animation: marquee-anim 18s linear infinite;
        font-size: 0.85rem;
        font-weight: 600;
        color: #0d6efd;
    }

    .running-text-wrapper:hover .running-text-content {
        animation-play-state: paused;
        cursor: pointer;
    }

    @keyframes marquee-anim {
        0% {
            transform: translate(0, 0);
        }

        100% {
            transform: translate(-100%, 0);
        }
    }

    @media (max-width: 768px) {
        .running-text-wrapper {
            display: none;
        }
    }
</style>

<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-center justify-content-between">

        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav flex-shrink-0">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::Center Running Text-->
        <div class="running-text-wrapper mx-2" id="runningTextContainer">
            <div class="running-text-content" id="runningTextContent">
                <i class="bi bi-megaphone-fill me-1 text-danger"></i>
                Selamat Datang di Sistem Layanan Kesehatan Klinik NP MEDIKA — Tetap Menjaga Protokol Kesehatan &
                Pelayanan Prima!
            </div>
        </div>
        <!--end::Center Running Text-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto flex-shrink-0">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="./public/img/userlogo.jpg" class="user-image rounded-circle shadow" alt="User Image" />
                    <span class="d-none d-md-inline">{{ auth()->user()->nama }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="./public/admin/dist/assets/img/user2-160x160.jpg" class="rounded-circle shadow"
                            alt="User Image" />
                        <p>
                            {{ auth()->user()->nama }}
                            <small>Member since Nov. 2023</small>
                        </p>
                    </li>
                    <li class="user-body"></li>
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!--end::End Navbar Links-->

    </div>
    <!--end::Container-->
</nav>

<script>
    $(document).ready(function() {
        let lastPaymentCount = null;

        // Fungsi untuk membunyikan suara notifikasi (Menggunakan Web Audio API Synthetic Chime)
        function playNotificationSound() {
            try {
                let AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;

                let ctx = new AudioContext();

                // Nada pertama (High pitch)
                let osc1 = ctx.createOscillator();
                let gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(587.33, ctx.currentTime); // D5
                gain1.gain.setValueAtTime(0.3, ctx.currentTime);
                gain1.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.3);

                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start();
                osc1.stop(ctx.currentTime + 0.3);

                // Nada kedua (Slightly Higher pitch)
                let osc2 = ctx.createOscillator();
                let gain2 = ctx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(880, ctx.currentTime + 0.15); // A5
                gain2.gain.setValueAtTime(0.4, ctx.currentTime + 0.15);
                gain2.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.6);

                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.start(ctx.currentTime + 0.15);
                osc2.stop(ctx.currentTime + 0.6);
            } catch (e) {
                console.log('Autoplay audio diblokir atau browser tidak mendukung Web Audio API:', e);
            }
        }

        function checkNewPayments() {
            $.ajax({
                url: "{{ route('layanan.checkPaymentCount') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    let currentCount = response.total;

                    // Set nilai awal saat pertama kali halaman dimuat
                    if (lastPaymentCount === null) {
                        lastPaymentCount = currentCount;
                        return;
                    }

                    // Jika jumlah transaksi bertambah dari nilai sebelumnya
                    if (currentCount > lastPaymentCount) {
                        lastPaymentCount = currentCount; // Perbarui nilai acuan

                        // 1. Bunyikan suara notifikasi
                        playNotificationSound();

                        // 2. Ubah isi pesan running text
                        let newText =
                            `<i class="bi bi-check-circle-fill me-1 text-success"></i> 
                        <strong>NOTIFIKASI PEMBAYARAN:</strong> Satu kunjungan pasien selesai dan telah melakukan pembayaran! (Total Selesai: ${currentCount})`;

                        $('#runningTextContent').html(newText);

                        // 3. Efek Highlight Visual (Warna Hijau Sementara)
                        $('#runningTextContainer').addClass('highlight');
                        setTimeout(function() {
                            $('#runningTextContainer').removeClass('highlight');
                        }, 5000);

                        // 4. Panggil Toast Notification jika fungsi showToast tersedia
                        if (typeof showToast === 'function') {
                            showToast('success', 'Satu kunjungan pasien telah berhasil dibayar!');
                        }
                    }
                },
                error: function(xhr) {
                    console.log('Gagal mengecek data pembayaran:', xhr);
                }
            });
        }

        // Jalankan pengecekan secara otomatis setiap 5 detik (5000 ms)
        setInterval(checkNewPayments, 5000);
    });
</script>
