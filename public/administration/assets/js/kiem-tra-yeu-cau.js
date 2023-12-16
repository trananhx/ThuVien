window.addEventListener("storage", () => {
    const bell = document.querySelector(".feather-bell");
    // console.log("Bell "+bell);
    if (!bell) return;
    const soLuongYeuCau = localStorage.getItem('thongBaoChuaXem') ?? 0;
    // console.log("So luong yeu cau: "+soLuongYeuCau);
    if (soLuongYeuCau > 0){
        bell.classList.add('show');
        bell.setAttribute("title", "Bạn có "+soLuongYeuCau+ " phản hồi chưa xem!")
    } else {
        bell.classList.remove('show');
        bell.setAttribute("title", "")
    }
});

