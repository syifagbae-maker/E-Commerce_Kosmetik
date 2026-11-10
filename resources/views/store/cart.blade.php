@extends('layouts.app')



@section('title', 'Your Bag — LuxSkin')



@section('content')

<style>

    .lux-cart-page{background:#fff7f5;min-height:80vh;padding:38px 0 70px}

    .lux-cart-wrap{width:min(1160px,92%);margin:auto}

    .lux-cart-heading{margin-bottom:24px}

    .lux-cart-heading .eyebrow{font-size:11px;letter-spacing:2px;color:#d45a7c;font-weight:700}

    .lux-cart-heading h1{font-family:Georgia,serif;font-size:36px;margin:8px 0 18px;color:#302725}

    .lux-cart-actions{display:flex;gap:10px;flex-wrap:wrap}

    .lux-cart-actions a,.lux-cart-actions button{border:1px solid #efd2d0;background:#fff;color:#7b4c50;border-radius:8px;padding:10px 16px;text-decoration:none;font-size:13px;cursor:pointer}

    .lux-cart-grid{display:grid;grid-template-columns:minmax(0,1.8fr) minmax(320px,.95fr);gap:24px;align-items:start}

    .lux-panel{background:#fff;border:1px solid #f0dfdc;border-radius:15px;overflow:hidden;box-shadow:0 5px 18px rgba(70,35,35,.035)}

    .lux-panel-head{padding:20px 22px;border-bottom:1px solid #f1e5e2;display:flex;justify-content:space-between;align-items:center}

    .lux-panel-head h2{font:700 20px Georgia,serif;margin:0;color:#382e2c}

    .lux-panel-head small{color:#a47d7b}

    .lux-cart-toolbar{padding:13px 22px;border-bottom:1px solid #f1e5e2;display:flex;justify-content:space-between;align-items:center;font-size:13px}

    .lux-cart-toolbar a{color:#cf5878;text-decoration:none}

    .lux-select-all{display:flex;gap:7px;align-items:center;color:#916d70}

    .lux-product{display:grid;grid-template-columns:22px 90px minmax(0,1fr) auto;gap:14px;align-items:center;padding:20px 22px;border-bottom:1px solid #f5eae8}

    .lux-product:last-child{border-bottom:0}

    .lux-product input[type=checkbox]{accent-color:#ce5878;width:17px;height:17px}

    .lux-product img{width:90px;height:90px;object-fit:cover;border-radius:10px;background:#f7efec}

    .lux-brand{font-size:10px;letter-spacing:1.5px;color:#d36b85;text-transform:uppercase}

    .lux-product-name{display:block;color:#302725;text-decoration:none;font-size:14px;font-weight:700;margin:5px 0}

    .lux-price{color:#cf5878;font-size:13px}

    .lux-qty{display:flex;gap:8px;align-items:center;margin-top:10px;flex-wrap:wrap}

    .lux-qty input{width:58px;border:1px solid #ead5d2;border-radius:6px;padding:7px;text-align:center}

    .lux-qty button{border:0;border-radius:6px;background:#ce5878;color:#fff;padding:7px 13px;cursor:pointer}

    .lux-delete{border:1px solid #f0d4d1;background:#fff8f7;color:#c65a6d;border-radius:6px;padding:7px 11px;cursor:pointer;font-size:12px}

    .lux-delete-form{margin-top:10px}

    .lux-delete:hover{background:#fff0ef;border-color:#d98b91}

    .lux-line-total{font-weight:700;font-size:14px;white-space:nowrap;color:#302725}

    .lux-summary{padding:21px}

    .lux-summary h2{font:700 21px Georgia,serif;margin:0 0 18px;color:#382e2c}

    .lux-summary-row{display:flex;justify-content:space-between;gap:12px;font-size:13px;color:#6d5c59;margin:12px 0}

    .lux-summary-row strong{color:#302725}

    .lux-summary-products{border-top:1px solid #f0e3e0;border-bottom:1px solid #f0e3e0;padding:12px 0;margin:14px 0}

    .lux-summary-products h3{font-size:13px;margin:0 0 9px;color:#51413e}

    .lux-summary-product{display:flex;justify-content:space-between;gap:12px;font-size:12px;color:#806c68;margin:7px 0}

    .lux-voucher-box{background:#fff9f8;border:1px solid #f0d8d5;border-radius:10px;padding:13px;margin:15px 0}

    .lux-voucher-top{display:flex;justify-content:space-between;align-items:center;gap:10px}

    .lux-voucher-top strong{font-size:13px;color:#51413e}

    .lux-voucher-top button{background:#fff;border:1px solid #d85e7e;color:#c94f70;border-radius:7px;padding:8px 12px;cursor:pointer;font-size:12px}

    .lux-voucher-selected{font-size:12px;color:#9b7773;margin-top:8px}

    .lux-total{border-top:1px solid #eee0dd;padding-top:15px;margin-top:14px;font-size:16px;font-weight:700}

    .lux-checkout{display:block;width:100%;text-align:center;background:#403633;color:white;text-decoration:none;border-radius:7px;padding:14px;margin-top:18px;font-weight:700}

    .lux-checkout.disabled{opacity:.45;pointer-events:none}

    .lux-empty{text-align:center;padding:50px 20px}

    .lux-empty a{display:inline-block;background:#403633;color:white;padding:12px 18px;border-radius:7px;text-decoration:none}

    .lux-modal{display:none;position:fixed;inset:0;background:rgba(35,25,25,.48);z-index:9999;align-items:center;justify-content:center;padding:18px;backdrop-filter:blur(3px)}

    .lux-modal.open{display:flex}

    .lux-modal-card{background:white;width:min(420px,100%);border:1px solid #f0dfdc;border-radius:15px;padding:25px;max-height:85vh;overflow:auto;box-shadow:0 18px 55px rgba(50,30,30,.2)}

    .lux-confirm-copy{color:#806c68;font-size:14px;line-height:1.6;margin:8px 0 20px}

    .lux-confirm-actions{display:flex;justify-content:flex-end;gap:9px}

    .lux-confirm-actions button{border-radius:7px;padding:10px 17px;cursor:pointer;font-size:13px}

    .lux-confirm-cancel{border:1px solid #ead5d2;background:#fff;color:#805f60}

    .lux-confirm-yes{border:1px solid #ce5878;background:#ce5878;color:#fff}

    .lux-modal-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}

    .lux-modal-head h3{font:700 21px Georgia,serif;margin:0}

    .lux-modal-close{border:0;background:transparent;font-size:25px;cursor:pointer;color:#806c68}

    .lux-voucher-option{border:1px dashed #e6a5b4;border-radius:10px;padding:14px;margin:10px 0;display:flex;justify-content:space-between;gap:12px;align-items:center}

    .lux-voucher-option strong{display:block;color:#ca5575;font-size:14px}

    .lux-voucher-option small{display:block;color:#8f7975;margin-top:5px;line-height:1.5}

    .lux-voucher-option button{border:1px solid #d85e7e;background:white;color:#c94f70;border-radius:7px;padding:8px 12px;cursor:pointer}

    .lux-voucher-option button.chosen{background:#ce5878;color:white}

    .lux-modal-footer{display:flex;gap:9px;margin-top:18px}

    .lux-modal-footer button{flex:1;padding:11px;border-radius:7px;cursor:pointer}

    .lux-use-voucher{background:#ce5878;color:white;border:1px solid #ce5878}

    .lux-cancel-voucher{background:white;color:#805f60;border:1px solid #ead5d2}

    @media(max-width:800px){.lux-cart-grid{grid-template-columns:1fr}.lux-product{grid-template-columns:20px 72px minmax(0,1fr)}.lux-product img{width:72px;height:78px}.lux-line-total{grid-column:3;justify-self:start}.lux-cart-heading h1{font-size:30px}}

</style>



<div class="lux-cart-page">

    <div class="lux-cart-wrap">

        <div class="lux-cart-heading">

            <span class="eyebrow">YOUR LITTLE TREASURES</span>

            <h1>Your Shopping Bag</h1>

            <div class="lux-cart-actions">

                <a href="{{ route('catalog') }}">← Kembali Belanja</a>

                <a href="{{ route('home') }}">⌂ Dashboard</a>

                <button type="button" id="editCartBtn">✎ Edit Keranjang</button>

            </div>

        </div>



        @if(session('success'))

            <div style="padding:12px 16px;background:#edf8f0;color:#32734b;border-radius:8px;margin-bottom:16px">{{ session('success') }}</div>

        @endif

        @if(session('error'))

            <div style="padding:12px 16px;background:#fff0f0;color:#b94b58;border-radius:8px;margin-bottom:16px">{{ session('error') }}</div>

        @endif



        @if($items->isEmpty())

            <div class="lux-panel lux-empty">

                <h2>Your bag is waiting.</h2>

                <p>Belum ada produk di keranjangmu.</p>

                <a href="{{ route('catalog') }}">Mulai Belanja ↗</a>

            </div>

        @else

            <div class="lux-cart-grid">

                <section class="lux-panel">

                    <div class="lux-panel-head">

                        <h2>♡ Produk di Keranjang (<span id="cartCount">{{ $items->sum('jumlah') }}</span>)</h2>

                        <small>{{ $items->count() }} produk</small>

                    </div>

                    <div class="lux-cart-toolbar">

                        <span style="color:#916d70">Pilih produk yang ingin dibeli</span>

                        <label class="lux-select-all"><input type="checkbox" id="selectAll"> Pilih Semua</label>

                    </div>



                    @foreach($items as $item)

                        @php

                            $cartImage = $item->path_gambar ?? null;

                            if ($cartImage) {

                                $cartImage = ltrim($cartImage, '/');

                                if (!str_starts_with($cartImage, 'http://') && !str_starts_with($cartImage, 'https://')) {

                                    $cartImage = str_starts_with($cartImage, 'storage/') || str_starts_with($cartImage, 'images/')

                                        ? asset($cartImage)

                                        : asset('storage/' . $cartImage);

                                }

                            } else {

                                $cartImage = 'https://images.unsplash.com/photo-1601049541289-9b1b7bbbfe19?w=300';

                            }

                        @endphp

                        <div class="lux-product"

                             data-id="{{ $item->id_detail_keranjang }}"

                             data-name="{{ $item->nama_produk }}"

                             data-price="{{ $item->harga }}"

                             data-qty="{{ $item->jumlah }}">

                            <input class="product-check" type="checkbox" value="{{ $item->id_detail_keranjang }}" aria-label="Pilih {{ $item->nama_produk }}">

                            <img src="{{ $cartImage }}" alt="{{ $item->nama_produk }}"

                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1601049541289-9b1b7bbbfe19?w=300';">

                            <div>

                                <span class="lux-brand">Lux Skin</span>

                                <a class="lux-product-name" href="{{ !empty($item->slug) ? route('product', $item->slug) : route('catalog') }}">{{ $item->nama_produk }}</a>

                                <span class="lux-price">Rp{{ number_format($item->harga,0,',','.') }}</span>

                                <div class="lux-qty">

                                    <form method="POST" action="{{ route('cart.update', $item->id_detail_keranjang) }}" class="qty-form">

                                        @csrf

                                        @method('PATCH')

                                        <input type="number" name="jumlah" min="1" max="{{ max(1, (int)($item->jumlah_stok ?? 20)) }}" value="{{ $item->jumlah }}" aria-label="Jumlah produk">

                                        <button type="submit">Simpan</button>

                                    </form>

                                </div>

                                <form method="POST" action="{{ route('cart.remove', $item->id_detail_keranjang) }}" class="delete-form lux-delete-form">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit" class="lux-delete">🗑 Hapus Produk</button>

                                </form>

                            </div>

                            <div class="lux-line-total">Rp{{ number_format($item->harga * $item->jumlah,0,',','.') }}</div>

                        </div>

                    @endforeach

                </section>



                <aside class="lux-panel lux-summary">

                    <h2>♧ Ringkasan Belanja</h2>

                    <div class="lux-summary-row">

                        <span>Total Produk Terpilih</span>

                        <strong id="selectedCount">0 item</strong>

                    </div>



                    <div class="lux-summary-products">

                        <h3>Produk yang dipilih</h3>

                        <div id="summaryProducts" style="font-size:12px;color:#9b8580">Pilih produk dari keranjang untuk melihat ringkasannya.</div>

                    </div>



                    <div class="lux-voucher-box">

                        <div class="lux-voucher-top">

                            <strong>♧ Voucher Belanja</strong>

                            <button type="button" id="openVoucherBtn">Pilih Voucher</button>

                        </div>

                        <div class="lux-voucher-selected" id="voucherSelected">Belum ada voucher dipilih</div>

                    </div>



                    <div class="lux-summary-row">

                        <span>Subtotal</span>

                        <strong id="subtotalText">Rp0</strong>

                    </div>

                    <div class="lux-summary-row">

                        <span>Diskon Voucher</span>

                        <strong id="discountText" style="color:#cf5878">- Rp0</strong>

                    </div>

                    <div class="lux-summary-row lux-total">

                        <span>Total Belanja</span>

                        <strong id="totalText">Rp0</strong>

                    </div>



                    <a href="{{ route('checkout') }}" id="checkoutBtn" class="lux-checkout disabled">Lanjut ke Checkout ↗</a>

                    <p style="font-size:11px;color:#9b8580;text-align:center;margin:10px 0 0">Pilih produk terlebih dahulu sebelum checkout.</p>

                </aside>

            </div>

        @endif

    </div>

</div>



<div class="lux-modal" id="voucherModal" aria-hidden="true">

    <div class="lux-modal-card">

        <div class="lux-modal-head">

            <h3>Pilih Voucher</h3>

            <button type="button" class="lux-modal-close" id="closeVoucherBtn">&times;</button>

        </div>

        <div class="lux-voucher-option" data-code="LUX5" data-percent="5" data-min="100000">

            <div><strong>LUX5</strong><small>Diskon 5% untuk minimum belanja Rp100.000</small></div>

            <button type="button" class="choose-voucher">Pilih</button>

        </div>

        <div class="lux-voucher-option" data-code="LUX10" data-percent="10" data-min="200000">

            <div><strong>LUX10</strong><small>Diskon 10% untuk minimum belanja Rp200.000</small></div>

            <button type="button" class="choose-voucher">Pilih</button>

        </div>

        <div class="lux-voucher-option" data-code="LUX15" data-percent="15" data-min="300000">

            <div><strong>LUX15</strong><small>Diskon 15% untuk minimum belanja Rp300.000</small></div>

            <button type="button" class="choose-voucher">Pilih</button>

        </div>

        <div class="lux-modal-footer">

            <button type="button" class="lux-cancel-voucher" id="cancelVoucherBtn">Batal</button>

            <button type="button" class="lux-use-voucher" id="applyVoucherBtn">Gunakan Voucher</button>

        </div>

    </div>

</div>





<div class="lux-modal" id="deleteConfirmModal" aria-hidden="true">

    <div class="lux-modal-card" role="dialog" aria-modal="true" aria-labelledby="deleteConfirmTitle">

        <div class="lux-modal-head">

            <h3 id="deleteConfirmTitle">Hapus produk?</h3>

            <button type="button" class="lux-modal-close" id="cancelDeleteX" aria-label="Tutup">&times;</button>

        </div>

        <p class="lux-confirm-copy" id="deleteConfirmMessage">Yakin ingin menghapus produk ini dari keranjang?</p>

        <div class="lux-confirm-actions">

            <button type="button" class="lux-confirm-cancel" id="cancelDeleteBtn">Batal</button>

            <button type="button" class="lux-confirm-yes" id="confirmDeleteBtn">Ya, hapus</button>

        </div>

    </div>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const rows = [...document.querySelectorAll('.lux-product')];

    if (!rows.length) return;



    const money = value => 'Rp' + new Intl.NumberFormat('id-ID').format(value);

    const selectAll = document.getElementById('selectAll');

    const summaryProducts = document.getElementById('summaryProducts');

    const selectedCount = document.getElementById('selectedCount');

    const subtotalText = document.getElementById('subtotalText');

    const discountText = document.getElementById('discountText');

    const totalText = document.getElementById('totalText');

    const checkoutBtn = document.getElementById('checkoutBtn');

    const voucherModal = document.getElementById('voucherModal');

    const voucherSelected = document.getElementById('voucherSelected');

    let selectedVoucher = null;

    let pendingVoucher = null;



    function selectedRows() {

        return rows.filter(row => row.querySelector('.product-check').checked);

    }



    function renderSummary() {

        const chosen = selectedRows();

        const subtotal = chosen.reduce((sum, row) => {

            return sum + Number(row.dataset.price) * Number(row.dataset.qty);

        }, 0);



        selectedCount.textContent = chosen.reduce((sum, row) => sum + Number(row.dataset.qty), 0) + ' item';



        if (!chosen.length) {

            summaryProducts.textContent = 'Pilih produk dari keranjang untuk melihat ringkasannya.';

        } else {

            summaryProducts.innerHTML = chosen.map(row => {

                const name = row.dataset.name.replace(/[&<>"']/g, char => ({

                    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'

                }[char]));

                const qty = Number(row.dataset.qty);

                const line = Number(row.dataset.price) * qty;

                return `<div class="lux-summary-product"><span>${name} × ${qty}</span><strong>${money(line)}</strong></div>`;

            }).join('');

        }



        let discount = 0;

        if (selectedVoucher) {

            if (subtotal >= selectedVoucher.min) {

                discount = Math.round(subtotal * selectedVoucher.percent / 100);

                voucherSelected.textContent = selectedVoucher.code + ' digunakan — diskon ' + selectedVoucher.percent + '%';

            } else {

                voucherSelected.textContent = selectedVoucher.code + ' belum memenuhi minimum belanja ' + money(selectedVoucher.min);

            }

        } else {

            voucherSelected.textContent = 'Belum ada voucher dipilih';

        }



        subtotalText.textContent = money(subtotal);

        discountText.textContent = '- ' + money(discount);

        totalText.textContent = money(Math.max(0, subtotal - discount));

        checkoutBtn.classList.toggle('disabled', chosen.length === 0);



        selectAll.checked = chosen.length === rows.length;

        selectAll.indeterminate = chosen.length > 0 && chosen.length < rows.length;

    }



    rows.forEach(row => {

        row.querySelector('.product-check').addEventListener('change', renderSummary);

        const qtyInput = row.querySelector('input[name="jumlah"]');

        qtyInput.addEventListener('change', () => {

            row.dataset.qty = qtyInput.value;

            renderSummary();

        });

    });



    selectAll.addEventListener('change', function () {

        rows.forEach(row => row.querySelector('.product-check').checked = selectAll.checked);

        renderSummary();

    });



    const deleteModal = document.getElementById('deleteConfirmModal');

    const deleteMessage = document.getElementById('deleteConfirmMessage');

    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    let pendingDeleteForm = null;



    function closeDeleteModal() {

        deleteModal.classList.remove('open');

        deleteModal.setAttribute('aria-hidden', 'true');

        pendingDeleteForm = null;

    }



    document.querySelectorAll('.delete-form').forEach(form => {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            pendingDeleteForm = form;

            const productName = form.closest('.lux-product')?.dataset.name || 'produk ini';

            deleteMessage.textContent = `Yakin ingin menghapus ${productName} dari keranjang?`;

            deleteModal.classList.add('open');

            deleteModal.setAttribute('aria-hidden', 'false');

        });

    });



    document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);

    document.getElementById('cancelDeleteX').addEventListener('click', closeDeleteModal);

    deleteModal.addEventListener('click', event => {

        if (event.target === deleteModal) closeDeleteModal();

    });

    confirmDeleteBtn.addEventListener('click', () => {

        if (pendingDeleteForm) pendingDeleteForm.submit();

    });



    document.getElementById('editCartBtn').addEventListener('click', function () {

        const editMode = this.dataset.editing !== 'true';

        this.dataset.editing = String(editMode);

        this.textContent = editMode ? '✓ Selesai Edit' : '✎ Edit Keranjang';

        document.querySelectorAll('.lux-qty').forEach(el => el.style.display = editMode ? 'flex' : 'none');

    });

    document.querySelectorAll('.lux-qty').forEach(el => el.style.display = 'none');



    function openModal() {

        pendingVoucher = selectedVoucher;

        document.querySelectorAll('.lux-voucher-option').forEach(option => {

            const isChosen = pendingVoucher && option.dataset.code === pendingVoucher.code;

            option.querySelector('button').classList.toggle('chosen', !!isChosen);

            option.querySelector('button').textContent = isChosen ? 'Dipilih' : 'Pilih';

        });

        voucherModal.classList.add('open');

        voucherModal.setAttribute('aria-hidden', 'false');

    }

    function closeModal() {

        voucherModal.classList.remove('open');

        voucherModal.setAttribute('aria-hidden', 'true');

    }



    document.getElementById('openVoucherBtn').addEventListener('click', openModal);

    document.getElementById('closeVoucherBtn').addEventListener('click', closeModal);

    document.getElementById('cancelVoucherBtn').addEventListener('click', closeModal);



    document.querySelectorAll('.lux-voucher-option').forEach(option => {

        option.querySelector('button').addEventListener('click', function () {

            pendingVoucher = {

                code: option.dataset.code,

                percent: Number(option.dataset.percent),

                min: Number(option.dataset.min)

            };

            document.querySelectorAll('.lux-voucher-option button').forEach(btn => {

                btn.classList.remove('chosen');

                btn.textContent = 'Pilih';

            });

            this.classList.add('chosen');

            this.textContent = 'Dipilih';

        });

    });



    document.getElementById('applyVoucherBtn').addEventListener('click', function () {

        selectedVoucher = pendingVoucher;

        closeModal();

        renderSummary();

    });



    checkoutBtn.addEventListener('click', function (event) {

        const chosen = selectedRows();

        if (!chosen.length) {

            event.preventDefault();

            alert('Pilih minimal satu produk untuk checkout.');

            return;

        }

        const ids = chosen.map(row => row.dataset.id);

        const params = new URLSearchParams();

        ids.forEach(id => params.append('selected_ids[]', id));

        if (selectedVoucher) params.set('voucher_code', selectedVoucher.code);

        this.href = '{{ route('checkout') }}?' + params.toString();

    });



    renderSummary();

});

</script>

@endsection
