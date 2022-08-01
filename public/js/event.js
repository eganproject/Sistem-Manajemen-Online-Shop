
// Slug Produk
const namaproduk = document.querySelector('#namaproduk');
const slug = document.querySelector('#slug');

    namaproduk.addEventListener('change', function(){
      fetch('/dashboard/produk/checkSlug?namaproduk=' + namaproduk.value)
      .then(response => response.json())
      .then(data => slug.value = data.slug)
    });

    // Slug Produk Variasi
// const namavariasi = document.querySelector('#namavariasi');
// const slugvariasi = document.querySelector('#slugvariasi');

//     namavariasi.addEventListener('change', function(){
//       fetch('/dashboard/produk/checkSlugVariasi?namavariasi=' + namavariasi.value)
//       .then(response => response.json())
//       .then(data => slugvariasi.value = data.slugvariasi)
//     });



    // Pakai Variasi
// document.getElementById("is_variasi").addEventListener("click", tampilFormTambah);

//     function tampilFormTambah() {
//     document.getElementById("tambahvariasi").innerHTML = '<div class="mb-3"><label for="namavariasi" class="form-label">Nama Variasi</label><input type="text" class="form-control" id="namavariasi" name="namavariasi"></div><div class="mb-3"><label for="slugvariasi" class="form-label">Slug Variasi</label><input type="text" class="form-control" id="slugvariasi" name="slugvariasi" readonly> </div><div class="row mb-3"><div class="col-lg-4"><label for="namavariasioption" class="form-label">Nama Variasi Option</label><input type="text" class="form-control" id="namavariasioption[]" name="namavariasioption[]"></div><div class="col-lg-2"><label for="stok[]" class="form-label">Stok</label><input type="number" class="form-control" id="stok[]" name="stok[]"></div><div class="col-lg-4"><label for="hargapokok" class="form-label">Harga Pokok</label>  <input type="number" class="form-control" id="hargapokok[]" name="hargapokok[]"> </div> <div class="col-lg-2"><label class="form-label"><a class="btn btn-primary btn-sm " id="btnclicktambah"><span data-feather="plus-circle" class="align-text-bottom"></span></a></label></div>';
//     };


// Tidak Pakai Variasi
// document.getElementById("tidakvariasi").addEventListener("click", tampilFormTidak);

//     function tampilFormTidak() {
//   document.getElementById("tambahvariasi").innerHTML = '<div class="mb-3"><label for="stok" class="form-label">APA</label>          <input type="text" class="form-control" id="stok" name="stok"></div>';
//     };
  
// TAMBAHKAN KOLOM INPUT VARIASI
// document.getElementById("btnclicktambah").addEventListener("click", tambahMember);

// function tambahMember(){
   
//     let isi = ' <div class="row mb-3" id="member"><div class="col-lg-4"><label for="namavariasioption" class="form-label">Nama Variasi Option</label>  <input type="text" class="form-control" id="namavariasioption[]" name="namavariasioption[]"> </div><div class="col-lg-2"><label for="stok" class="form-label">Stok</label><input type="number" class="form-control" id="stok[]" name="stok[]"></div><div class="col-lg-4"><label for="hargapokok" class="form-label">Harga Pokok</label><input type="number" class="form-control" id="hargapokok[]" name="hargapokok[]"></div><div class="col-lg-2" onclick="remove(this)"><label class="form-label"><a class="btn btn-danger btn-sm" id="btnclickhapus" >Hapus</a></label></div>';
//     document.getElementById("tambahvariasioption").insertAdjacentHTML('afterend',isi);
    
// }

function remove(el){
  const element = el
  el.parentElement.remove();
}




// RUPIAHHHH
	
// var rupiah = document.getElementById('hargapokok[]');
// rupiah.addEventListener('keyup', function(e){
//     // tambahkan 'Rp.' pada saat form di ketik
//     // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
//     rupiah.value = formatRupiah(this.value, 'Rp. ');
// });

// /* Fungsi formatRupiah */
// function formatRupiah(angka, prefix){
//     var number_string = angka.replace(/[^,\d]/g, '').toString(),
//     split   		= number_string.split(','),
//     sisa     		= split[0].length % 3,
//     rupiah     		= split[0].substr(0, sisa),
//     ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

//     // tambahkan titik jika yang di input sudah menjadi angka ribuan
//     if(ribuan){
//         separator = sisa ? '.' : '';
//         rupiah += separator + ribuan.join('.');
//     }

//     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
//     return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
// }

