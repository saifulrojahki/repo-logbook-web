const flashData = $('.flash-data').data('flashdata');

//alert succes tambah, edit, hapus data
if (flashData) {

	Swal.fire({
		title: flashData,
		text: '',
		type: 'success'
	});
}

//konfirm tombol hapus sweetalert
$('.tombol-hapus').on('click', function (e) {
	//mematikan fungsi default alert
	e.preventDefault();
	const href = $(this).attr('href');

	Swal.fire({
		title: 'Are you sure?',
		text: "",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
		if (result.value) {
			document.location.href = href;
		}
	})


});

//kelompok edc
//pesan tambah data edc
//konfirm tombol take out sweetalert ketika akan mengeluarkan edc
$('.tombol-takeout').on('click', function (e) {
	//mematikan fungsi default alert
	e.preventDefault();
	const href = $(this).attr('href');

	Swal.fire({
		title: 'Are you sure?',
		text: "",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes!'
	}).then((result) => {
		if (result.value) {
			document.location.href = href;
		}
	})
});

//alert succes tambah data EDC 
const flashData1 = $('.flash-data1').data('flashdata');
if (flashData1) {

	Swal.fire({
		title: flashData1,
		text: 'Save EDC this Location',
		type: 'success'
	});
}
