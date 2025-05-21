document.addEventListener('DOMContentLoaded', function () {
    const tinhSelect = document.getElementById('tinh');
    const huyenSelect = document.getElementById('huyen');
    const xaSelect = document.getElementById('xa');

    let dsTinh = {}, dsHuyen = {}, dsXa = {};

    // Load cả 3 file JSON
    Promise.all([
        fetch('/js/vn-location/tinh_tp.json').then(res => res.json()),
        fetch('/js/vn-location/quan_huyen.json').then(res => res.json()),
        fetch('/js/vn-location/xa_phuong.json').then(res => res.json())
    ]).then(([tinhData, huyenData, xaData]) => {
        dsTinh = tinhData;
        dsHuyen = huyenData;
        dsXa = xaData;

        // Render tỉnh
        Object.values(dsTinh).forEach(t => {
            tinhSelect.innerHTML += `<option value="${t.code}">${t.name}</option>`;
        });

        // 👉 PHỤC HỒI old() nếu có (tỉnh/huyện/xã)
        const oldTinh = tinhSelect.dataset.old;
        const oldHuyen = huyenSelect.dataset.old;
        const oldXa = xaSelect.dataset.old;

        if (oldTinh) {
            tinhSelect.value = oldTinh;

            Object.values(dsHuyen).filter(h => h.parent_code === oldTinh).forEach(h => {
                huyenSelect.innerHTML += `<option value="${h.code}">${h.name}</option>`;
            });

            if (oldHuyen) {
                huyenSelect.value = oldHuyen;

                Object.values(dsXa).filter(x => x.parent_code === oldHuyen).forEach(x => {
                    xaSelect.innerHTML += `<option value="${x.code}">${x.name}</option>`;
                });

                if (oldXa) {
                    xaSelect.value = oldXa;
                }
            }
        }
    });

    // Khi chọn tỉnh → load huyện
    tinhSelect.addEventListener('change', function () {
        const maTinh = this.value;
        huyenSelect.innerHTML = `<option value="">-- Chọn quận/huyện --</option>`;
        xaSelect.innerHTML = `<option value="">-- Chọn phường/xã --</option>`;

        Object.values(dsHuyen).filter(h => h.parent_code === maTinh).forEach(h => {
            huyenSelect.innerHTML += `<option value="${h.code}">${h.name}</option>`;
        });
    });

    // Khi chọn huyện → load xã
    huyenSelect.addEventListener('change', function () {
        const maHuyen = this.value;
        xaSelect.innerHTML = `<option value="">-- Chọn phường/xã --</option>`;

        Object.values(dsXa).filter(x => x.parent_code === maHuyen).forEach(x => {
            xaSelect.innerHTML += `<option value="${x.code}">${x.name}</option>`;
        });
    });
});
