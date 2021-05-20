51800875: Phạm Vũ Long Khải
51800203: Tăng Bảo Kiên


-Đề tài: Xây dựng hệ thống giảng dạy trực tuyến.

-Phân chia công việc(trong quá trình làm bài chúng em có hỗ trợ nhau qua lại giữa các yêu cầu):
	+ Phạm Vũ Long Khải: yêu cầu 2,3,5.
	+ Tăng Bảo Kiên: Yêu cầu 1,4.


-Một số lưu ý khi sử dụng:
	+ Tại chức năng xoá lớp học. Nên tắt tất cả extensions của trình duyệt trước khi chạy chương trình khi không tắt
	 có thể sẽ sẽ bị lỗi 'Unchecked runtime.lastError: Could not establish connection. Receiving end does not exist'
	 và javascript sẽ không thực thi.

	+ Tại chức năng reset mật khẩu hoặc kích hoạt tài khoản muốn sử dụng người dùng cần tải thư viện PHPMailer.
	 Để sử dụng thư viện này, ta phải tải source code lưu vào project này(Để tiện sử dụng, người dùng
	 có thể cài công cụ Composer để tải các thư viện cần thiết về project).

	+ Tham khảo https://github.com/PHPMailer/PHPMailer để sử dụng thư viện PHPMailer.

	+ Project cung cấp 01 tài khoản quản trị viên có toàn quyền:
		- username: admin
		- password: 123456

	+ Project cung cấp 02 tài khoản giảng viên
	  có quyền thêm, sửa, xoá,... dữ liệu do chính tài khoản đó tạo ra:
		- username: Lecture0
		- password: 123456

		- username: Lecture1
		- password: 123456
	
	+ Project cung cấp 10 tài khoản sinh viên có quyền xem, tham gia lớp học,...:
		- X từ 0 đến 9

		- username: StudentX
		- password: 123456
