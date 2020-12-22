		// Khi bấm Tính phí Vận chuyển
		$(document).ready(function () {
			$('.calculate_delivery').click(function () {
				var matp = $('.city').val();
				var maqh = $('.province').val();
				var xaid = $('.wards').val();
				var _token = $('input[name="_token"]').val();
				if (matp == '' && maqh == '' && xaid == '') {
					alert('Làm ơn chọn để tính phí vận chuyển');
				} else {
					$.ajax({
						url: '{{url('/calculate-free')}}',
						method: 'POST',
						data: { matp: matp, maqh: maqh, xaid: xaid, _token: _token },
						success: function () {
							location.reload();
						}
					});
				}
			});
		});