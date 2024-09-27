<script src="assets/js/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<!-- Owl Carousel JS -->
<script src="assets/js/owl.carousel.min.js"></script>

<!-- Slick JS -->
<script src="assets/js/slick.js"></script>

<!-- Animation JS -->
<script src="assets/js/aos.js"></script>

@if(Auth::user() != null && Auth::user()->role == 1)
    {{--Lay yeu cau chua xem--}}
    <script src="administration/assets/js/kiem-tra-yeu-cau.js"></script>
    <script>
        const checkDanhSachYeuCauBackground = () => {
            fetch('/admin/check-danh-sach-yeu-cau', {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                },
            }).then(res => res.json())
                .then(response => {
                    if (response) {
                        localStorage.setItem('thongBaoChuaXem', response.data);
                        window.dispatchEvent(new Event('storage'));
                    }
                })
                .catch(err => console.log(err));
        }
        checkDanhSachYeuCauBackground();
        setInterval(() => {
            checkDanhSachYeuCauBackground();
        }, 20000)
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var links = document.getElementsByTagName('a');
        for (var i = 0; i < links.length; i++) {
            // links[i].addEventListener('click', handleLinkClick);
        }

        function handleLinkClick(event) {
            event.preventDefault();
            var href = event.target.href;
            if (href.endsWith('.pdf') || href.includes('pdf')) {
                window.open(href, '_blank');
            } else if (href.endsWith('.docx') || href.includes('docx')|| href.includes('doc')) {
                let link = 'https://view.officeapps.live.com/op/view.aspx?src='+href
                console.log('Handling DOCX link');
                window.open(link, '_blank');
            } else {
                window.location.href = href;
                console.log('Handling other link');
            }
        }
    });
</script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
<script>
    setTimeout(() => {
        console.log('xóa load')
        let loading = document.querySelector("#loadingScreen");
        if (loading) {
            loading.style.display = 'none'
        }
    }, 400)
</script>
