<style>
    .header {
        position: fixed;
        top: 0;
        width: 100%;
        max-width: 480px;
        color: white;
        padding: 12px 16px;
        z-index: 999;
        transition: background-color 0.3s ease;
        background-color: transparent;
    }

    .header.scrolled {
        background-color: #16B8A8;
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header.scrolled .header-content {
        color: white;
    }

    .header.scrolled .icon {
        color: white !important;
        filter: brightness(0) invert(1);
    }

    .header.scrolled .icon a,
    .header.scrolled .icon a i {
        color: white !important;
    }

    .icon {
        font-size: 20px;
        text-decoration: none;
        color: #16B8A8;
        cursor: pointer;
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }

    .icon a,
    .icon a i {
        color: #16B8A8;
        text-decoration: none;
    }

    .header-content .title {
        font-weight: bold;
        font-size: 16px;
        text-align: center;
        flex-grow: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 0 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Styling untuk toast notification */
    .toast-container {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
    }
</style>



<div id="header" class="header">
    <div class="header-content">
        <div class="icon"><a href="javascript:history.back()"><img style="width: 24px" src="{{ asset('icons/left.png') }}" alt="" srcset=""></a></div>
        <div class="title">Bagaimana hukum shalat ketik...</div>
        <div class="icon" id="shareButton"><img style="width: 24px" src="{{ asset('icons/share.png') }}" alt="" srcset=""></div>
    </div>
</div>

<!-- Toast Notification -->
<div class="toast-container">
    <div id="copyToast" class="toast align-items-center text-white bg-success border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fa fa-check-circle me-2"></i> Link berhasil disalin!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>


<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Fungsi scroll header
    window.addEventListener('scroll', function() {
        const header = document.getElementById('header');
        if (window.scrollY > 10) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Fungsi share dan salin link
    document.getElementById('shareButton').addEventListener('click', function() {
        // Dapatkan URL halaman saat ini
        const currentURL = window.location.href;

        // Salin URL ke clipboard
        navigator.clipboard.writeText(currentURL).then(function() {
            // Tampilkan toast notification
            const toastElement = document.getElementById('copyToast');
            const toast = new bootstrap.Toast(toastElement, {
                delay: 2000 // Hilang setelah 2 detik
            });
            toast.show();

            // Alternatif: Gunakan Web Share API jika tersedia
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: currentURL
                }).catch(err => {
                    console.log('Error sharing:', err);
                });
            }
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    });
</script>
