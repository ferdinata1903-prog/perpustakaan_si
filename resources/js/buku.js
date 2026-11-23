const apiBuku = '/data/buku';
const apiKategori = '/data/kategori';
let dataBukuSaatIni = [];

// Halaman /kelola/buku punya form; halaman /buku (read-only) tidak punya
const bisaKelola = document.getElementById('form-buku') !== null;
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function pesanError(res, json) {
    if (res.status === 403) return 'Anda tidak memiliki hak akses untuk aksi ini.';
    if (res.status === 401) return 'Sesi berakhir, silakan login kembali.';
    return json.message || 'Terjadi kesalahan.';
}

async function parseJsonRespon(res) {
    const contentType = res.headers.get('content-type') || '';
    if (!contentType.includes('application/json')) {
        throw new Error(`Respon server bukan JSON (${res.status}). Kemungkinan sesi berakhir atau dialihkan.`);
    }
    return await res.json();
}

async function loadKategori() {
    if (!bisaKelola) return;

    try {
        const res = await fetch(apiKategori, {
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
        if (!res.ok) throw new Error(`Gagal memuat kategori (${res.status})`);
        const json = await parseJsonRespon(res);

        const select = document.getElementById('kategori_id');
        json.data.forEach(k => {
            const opt = document.createElement('option');
            opt.value = k.id;
            opt.textContent = k.nama;
            select.appendChild(opt);
        });
    } catch (err) {
        console.error(err);
    }
}

async function loadBuku() {
    const tbody = document.getElementById('tabel-body');
    tbody.innerHTML = '<tr><td colspan="5">Memuat data...</td></tr>';

    try {
        const res = await fetch(apiBuku, {
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
        if (!res.ok) throw new Error(`Gagal memuat data buku (${res.status})`);

        const json = await parseJsonRespon(res);
        dataBukuSaatIni = json.data;
        renderTable(dataBukuSaatIni);
    } catch (err) {
        tbody.innerHTML = '<tr><td colspan="5"></td></tr>';
        tbody.querySelector('td').textContent = `Terjadi kesalahan: ${err.message}`;
    }
}

function renderTable(data) {
    const tbody = document.getElementById('tabel-body');

    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5">Belum ada data buku.</td></tr>';
        return;
    }

    // PATCH A1: semua nilai dari API ditulis sebagai teks, bukan HTML.
    // Jangan interpolasi judul/penulis/kategori ke dalam innerHTML.
    tbody.replaceChildren();

    data.forEach(buku => {
        const tr = document.createElement('tr');

        const tdKategori = document.createElement('td');
        tdKategori.textContent = buku.kategori ?? '-';
        tr.appendChild(tdKategori);

        const tdJudul = document.createElement('td');
        tdJudul.textContent = buku.judul;
        tr.appendChild(tdJudul);

        const tdPenulis = document.createElement('td');
        tdPenulis.textContent = buku.penulis;
        tr.appendChild(tdPenulis);

        const tdTahun = document.createElement('td');
        tdTahun.textContent = buku.tahun;
        tr.appendChild(tdTahun);

        const tdAksi = document.createElement('td');
        const detail = document.createElement('a');
        detail.href = `/buku/${encodeURIComponent(String(buku.id))}`;
        detail.textContent = 'Detail';
        tdAksi.appendChild(detail);

        if (bisaKelola) {
            const ubah = document.createElement('button');
            ubah.type = 'button';
            ubah.className = 'btn-ubah';
            ubah.dataset.id = String(buku.id);
            ubah.textContent = 'Ubah';
            ubah.addEventListener('click', () => mulaiUbah(buku.id));
            tdAksi.appendChild(ubah);

            const hapus = document.createElement('button');
            hapus.type = 'button';
            hapus.className = 'btn-hapus';
            hapus.dataset.id = String(buku.id);
            hapus.textContent = 'Hapus';
            hapus.addEventListener('click', () => hapusBuku(buku.id));
            tdAksi.appendChild(hapus);
        }

        tr.appendChild(tdAksi);
        tbody.appendChild(tr);
    });

    // Listener dipasang saat elemen tombol dibuat, bukan melalui selector global.
}

function mulaiUbah(id) {
    const buku = dataBukuSaatIni.find(b => b.id == id);
    if (!buku) return;

    document.getElementById('buku_id').value = buku.id;
    document.getElementById('kategori_id').value = buku.kategori_id;
    document.getElementById('judul').value = buku.judul;
    document.getElementById('penulis').value = buku.penulis;
    document.getElementById('tahun_terbit').value = buku.tahun;

    document.getElementById('form-judul').textContent = 'Ubah Buku';
    document.getElementById('submit-btn').textContent = 'Simpan Perubahan';
    document.getElementById('batal-btn').style.display = 'inline-block';
}

function batalUbah() {
    document.getElementById('form-buku').reset();
    document.getElementById('buku_id').value = '';
    document.getElementById('form-judul').textContent = 'Tambah Buku';
    document.getElementById('submit-btn').textContent = 'Tambah';
    document.getElementById('batal-btn').style.display = 'none';
    document.getElementById('form-pesan').textContent = '';
}

async function hapusBuku(id) {
    const yakin = confirm('Yakin ingin menghapus buku ini?');
    if (!yakin) return;

    try {
        const res = await fetch(`${apiBuku}/${id}`, {
            method: 'DELETE',
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
        });
        const json = await parseJsonRespon(res);

        if (!res.ok) {
            alert(pesanError(res, json));
            return;
        }

        loadBuku();
    } catch (err) {
        alert('Tidak dapat menghubungi server.');
    }
}

if (bisaKelola) {
    document.getElementById('batal-btn').addEventListener('click', batalUbah);

    document.getElementById('form-buku').addEventListener('submit', async function (e) {
        e.preventDefault();
        const pesan = document.getElementById('form-pesan');
        pesan.textContent = '';

        const id = document.getElementById('buku_id').value;
        const payload = {
            kategori_id: document.getElementById('kategori_id').value,
            judul: document.getElementById('judul').value,
            penulis: document.getElementById('penulis').value,
            tahun_terbit: document.getElementById('tahun_terbit').value,
        };

        const url = id ? `${apiBuku}/${id}` : apiBuku;
        const method = id ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method: method,
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            });

            const json = await parseJsonRespon(res);

            if (!res.ok) {
                if (res.status === 422) {
                    pesan.textContent = Object.values(json.errors).flat().join(' ');
                } else {
                    pesan.textContent = pesanError(res, json);
                }
                return;
            }

            batalUbah();
            loadBuku();
        } catch (err) {
            pesan.textContent = 'Tidak dapat menghubungi server.';
        }
    });
}

loadKategori();
loadBuku();