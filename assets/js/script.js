$(function () {

	//kelompok menu
	$('.tampilModalTambah').on('click', function () {
		$('#newMenuModalLabel').html('Add Menu');
		$('.modal-footer button[type=submit]').html('Save');
		$('#menu').val('');
		$('#id').val('');
	});

	$('.tampilModalUbah').on('click', function () {
		$('#newMenuModalLabel').html('Edit Menu');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/menu/ubah');

		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/logbook/menu/getubah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				$('#menu').val(data.menu);
				$('#id').val(data.id);
			}
		});

	});

	//kelompok sub menu
	$('.tampilSubMenuTambah').on('click', function () {
		$('#newSubMenuModalLabel').html('Add New Sub Menu');
		$('.modal-footer button[type=submit]').html('Save');
		$('#menu_id').val('');
		$('#title').val('');
		$('#url').val('');
		$('#icon').val('');
		$('#is_active').val('');
	});

	$('.tampilSubMenuUbah').on('click', function () {
		$('#newSubMenuModalLabel').html('Edit Sub Menu');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/menu/submenuubah');


		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/logbook/menu/getSubMenuUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				$('#menu_id').val(data.menu_id);
				$('#title').val(data.title);
				$('#url').val(data.url);
				$('#icon').val(data.icon);
				$('#is_active').val(data.is_active);
				$('#id').val(data.id);

			}
		});

	});

	//kelompok role 
	$('.tampilRoleTambah').on('click', function () {
		$('#newRoleModalLabel').html('Add New Sub Menu');
		$('.modal-footer button[type=submit]').html('Save');
		$('#role').val('');
		$('#id').val('');

	});

	$('.tampilRolelUbah').on('click', function () {
		$('#newRoleModalLabel').html('Edit Sub Menu');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/admin/roleUbah');


		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/logbook/admin/getRoleUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				$('#role').val(data.role);
				$('#id').val(data.id);

			}
		});

	});

	//kelompok service point
	$('.tampilSPTambah').on('click', function () {
		$('#newSPModalLabel').html('Add New Service Point');
		$('.modal-footer button[type=submit]').html('Save');
		$('#kelas').val('');
		$('#sp').val('');
		$('#id').val('');

	});

	$('.tampilSPUbah').on('click', function () {
		$('#newSPModalLabel').html('Edit Service Point');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/master/SPUbah');

		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/logbook/master/getSPUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#kelas').val(data.kelas);
				$('#sp').val(data.servicepoint);
				$('#id').val(data.id);

			}
		});

	});


	//kelompok  product
	$('.tampilProductTambah').on('click', function () {
		$('#newProductModalLabel').html('Add New Product');
		$('.modal-footer button[type=submit]').html('Save');
		$('#product').val('');
		$('#kategori').val('');
		$('#id').val('');

	});

	$('.tampilProductUbah').on('click', function () {
		$('#newProductModalLabel').html('Edit Product');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/master/productUbah');

		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/logbook/master/getProductUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#product').val(data.product);
				$('#kategori').val(data.kategori);
				$('#id').val(data.id);

			}
		});

	});

	//kelompok  owner
	$('.tampilOwnerTambah').on('click', function () {
		$('#newOwnerModalLabel').html('Add New Owner');
		$('.modal-footer button[type=submit]').html('Save');
		$('#owner').val('');
		$('#id').val('');

	});

	$('.tampilOwnerUbah').on('click', function () {
		$('#newOwnerModalLabel').html('Edit Product');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/master/ownerUbah');

		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/logbook/master/getOwnerUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#owner').val(data.owner);
				$('#id').val(data.id);

			}
		});

	});

	//kelompok  Customer
	$('.tampilCustomerTambah').on('click', function () {
		$('#newCustomerModalLabel').html('Add New Customer');
		$('.modal-footer button[type=submit]').html('Save');
		$('#customer').val('');
		$('#id').val('');

	});

	$('.tampilCustomerUbah').on('click', function () {
		$('#newCustomerModalLabel').html('Edit Product');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/master/customerUbah');

		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/logbook/master/getCustomerUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#customer').val(data.customer);
				$('#id').val(data.id);

			}
		});

	});

	//kelompok edc
	$('.tampilEDCTambah').on('click', function () {
		$('#newEDCModalLabel').html('Free Location :');
		$('.modal-footer button[type=submit]').html('Save');
		$('#snedc').val('');
		$('#snsimcard').val('');
		$('#snsamcard').val('');
		$('#product').val('');
		$('#merchant').val('');
		$('#customer').val('');
		$('#owner').val('');
		$('#status').val('');
		$('#keterangan').val('');

	});

	$('.tampilEDCUbah').on('click', function () {
		//$('#newEdcModalLabel').html('Edit EDC 1');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/logistic/EDCUbah');
		//variable untuk menangkap no box yang di kirim dari form
		const id = $(this).data('id');
		//console.log(id);

		$.ajax({
			url: 'http://localhost/logbook/logistic/getEDCUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#snedc').val(data.snedc);
				$('#snsimcard').val(data.snsimcard);
				$('#snsamcard').val(data.snsamcard);
				$('#product').val(data.product);
				$('#merchant').val(data.merchant);
				$('#customer').val(data.customer);
				$('#owner').val(data.owner);
				$('#status').val(data.status);
				$('#keterangan').val(data.keterangan);
				$('#nobox').val(data.nobox);

			}
		});

	});

	//kelompok dsn
	$('.tampilDSNTambah').on('click', function () {
		$('#newDSNModalLabel').html('Add New Device');
		$('.modal-footer button[type=submit]').html('Save');
		$('#sndevice').val('');
		$('#nama_device').val('');
		$('#product').val('');
		$('#customer').val('');
		$('#servicepoint').val('');
		$('#kondisi').val('');
		$('#status').val('');
		$('#keterangan').val('');

	});

	$('.tampilDSNUbah').on('click', function () {
		$('#newDSNModalLabel').html('Edit Device');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/logistic/DSNUbah');

		const id = $(this).data('id');
		console.log(id);

		$.ajax({
			url: 'http://localhost/logbook/logistic/getDSNUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#sndevice').val(data.sndevice);
				$('#nama_device').val(data.nama_device);
				$('#product').val(data.product);
				$('#customer').val(data.customer);
				$('#servicepoint').val(data.servicepoint);
				$('#kondisi').val(data.kondisi);
				$('#status').val(data.status);
				$('#keterangan').val(data.keterangan);
				$('#id_device').val(data.id_device);

			}
		});

	});

	//isi keterangan keluar
	$('.tampilDSNKeluar').on('click', function () {
		//$('#newDSNModalLabel1').html('Takeout Device');
		$('.modal-footer button[type=submit]').html('Takeout');
		//$('.modal-body form').attr('action', 'http://localhost/logbook/logistic/dsnhapus/');

		const id = $(this).data('id');
		//console.log(id);

		$.ajax({
			url: 'http://localhost/logbook/logistic/getDSNUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#remark').val(data.keterangan);
				$('#newDSNModalLabel1').html(data.sndevice);
				$('#id_device1').val(data.id_device);

			}
		});

	});
	//create sn dummy dsn
	$('.tampilSNDummy').on('click', function () {
		//console.log('ok');
		$('#sndevice').val(Math.random() * 100); //sintak random sn

	});

	//set hanya bisa input number
	$('.onlyNumber').on('keydown', function (e) {
		if (e.shiftKey === true) {
			if (e.which == 9) {
				return true;
			}
			return false;
		}
		if (e.which > 57) {
			if (e.which >= 96 && e.which <= 105) {
				return true;
			}
			return false;
		}
		if (e.which == 32) {
			return false;
		}
		return true;

	});

	//create code competition setelah pilih bulan
	$('.create-code').on('change', function () {
		//console.log('ok');
		//ambil nilai service point, bulan dan tahun
		var sp = $('#sp option:selected').text();
		var bln = $('#bulan option:selected').text();
		var thn = $('#tahun option:selected').text();
		var blnthn = sp + bln + thn;

		//create code competition
		$('#code').val(blnthn);

	});

	//edit productivity
	$('.tampilProductivityUbah').on('click', function () {
		//console.log('ok');
		$('#newProductivityModalLabel1').html('Edit Productivity');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/competition/productivityUbah');

		const id = $(this).data('id');
		//console.log(id);

		$.ajax({
			url: 'http://localhost/logbook/competition/getProductivityUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#productivity').val(data.productivity);
				$('#mip').val(data.mip);

			}
		});

	});

	//edit pm
	$('.tampilPMUbah').on('click', function () {
		//console.log('ok');
		$('#newPMModalLabel1').html('PM Completion Date');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/competition/pmUbah');

		const id = $(this).data('id');
		//console.log(id);

		$.ajax({
			url: 'http://localhost/logbook/competition/getPMUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#pm').val(data.pm);
				$('#mip').val(data.mip);

			}
		});

	});

	//kelompok absen
	$('.tampilAbsenTambah').on('click', function () {
		$('#newAbsenModalLabel1').html('Add Mis SLA Absent');
		$('.modal-footer button[type=submit]').html('Save');
		$('#nama').val('');
		$('#remark').val('');
		$('#id_absen').val('');

	});

	$('.tampilAbsenUbah').on('click', function () {
		$('#newAbsenModalLabel1').html('Edit Mis SLA Absent');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/competition/absenUbah');

		const id = $(this).data('id');
		//console.log(id);

		$.ajax({
			url: 'http://localhost/logbook/competition/getAbsenUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#nama').val(data.mip);
				$('#remark').val(data.keterangan);
				$('#id_absen').val(data.id_absen);

			}
		});

	});

	//kelompok sla
	$('.tampilSLATambah').on('click', function () {
		$('#newSLAModalLabel1').html('Add Mis SLA');
		$('.modal-footer button[type=submit]').html('Save');
		$('#nama').val('');
		$('#remark').val('');
		$('#id_sla').val('');

	});

	$('.tampilSLAUbah').on('click', function () {
		$('#newSLAModalLabel1').html('Edit Mis SLA');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/competition/slaUbah');

		const id = $(this).data('id');
		//console.log(id);

		$.ajax({
			url: 'http://localhost/logbook/competition/getSLAUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#nama').val(data.mip);
				$('#remark').val(data.keterangan);
				$('#id_sla').val(data.id_sla);

			}
		});

	});

	//kelompok  Member
	$('.tampilMemberTambah').on('click', function () {
		$('#newMemberModalLabel').html('Add New Member');
		$('.modal-footer button[type=submit]').html('Save');
		$('#mip').val('');
		$('#nama').val('');
		$('#servicepoint').val('');
		$('#id_sae').val('');

	});

	$('.tampilMemberUbah').on('click', function () {
		$('#newMemberModalLabel').html('Edit Member');
		$('.modal-footer button[type=submit]').html('Update');
		$('.modal-body form').attr('action', 'http://localhost/logbook/master/memberUbah');

		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/logbook/master/getMemberUbah',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#mip').val(data.mip);
				$('#nama').val(data.nama);
				$('#servicepoint').val(data.servicepoint);
				$('#id_sae').val(data.id_sae);

			}
		});

	});

});
