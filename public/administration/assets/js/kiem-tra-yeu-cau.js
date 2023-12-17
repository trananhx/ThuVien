window.addEventListener("storage", () => {
    const bell = document.querySelector(".feather-bell");
    // console.log("Bell "+bell);
    if (!bell) return;
    const soLuongYeuCau = localStorage.getItem('thongBaoChuaXem') ?? 0;
    const isRing = localStorage.getItem("amThanhThongBao") ?? "0";
    // console.log("So luong yeu cau: "+soLuongYeuCau);
    if (soLuongYeuCau > 0){
        bell.classList.add('show');
        bell.setAttribute("title", "Bạn có " + soLuongYeuCau + " phản hồi chưa xem!");
        if (isRing == 0) {
            let audio = new Audio("../../files/anhBia/sound.mp3");
            audio?.play();
            localStorage.setItem("amThanhThongBao", "1");
        }
    } else {
        bell.classList.remove('show');
        bell.setAttribute("title", "Không có thông báo mới")
        if (isRing == 1) {
            localStorage.setItem("amThanhThongBao", "0");
        }
    }
});

