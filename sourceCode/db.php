<?php 
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require './vendor/autoload.php';

    // mở database
    function open_database(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tdt_classroom";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    // xét thêm cột role để xác định là giáo viên hay học sinh
    function login($user, $pass){
        $sql = "SELECT * FROM account WHERE username = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$user);
        if (!$stm->execute()) {
            # code...
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        $result = $stm->get_result();
        $data = $result->fetch_assoc();

        if (!empty($result) && $result->num_rows == 0) {
            return array('code' => 1, 'error' => 'User does not exists');
        }

        $hashed_password = $data['password'];
        if (!password_verify($pass, $hashed_password)) {
            # code...
            return array('code' => 2, 'error' => 'Invalid username or password');
        }
        else if ($data['activated'] == 0) {
            # code...
            return array('code' => 3, 'error' => 'This is account do not activated');
        }else return array('code' => 0, 'error' => '', 'data' => $data);
    }

    // check is mail
    function is_email_exists($email){
        $sql = 'SELECT username from account where email = ?';
        $conn = open_database();

        $stm = $conn -> prepare($sql);
        $stm->bind_param('s',$email);

        if(!$stm->execute()){
            die("Query error:".$stm->error);
        }

        $result = $stm->get_result();
        if ($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    // đăng ký
    function register($fullname, $email, $phone, $birthday, $user, $pass){

        if(is_email_exists($email)) {
            return array('code' => 1, 'error' => 'Email exists');
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $rand = random_int(0, 1000);
        $token = md5($user .'+'. $rand);

        $sql = 'INSERT INTO account(username, password, FullName, Birthday, email, phone, activate_token, role) VALUES (?,?,?,?,?,?,?,?)';
        
        $permisson = 3;
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssssss',$user, $hash, $fullname, $birthday, $email, $phone, $token, $permisson);
        
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }

        //send verification email 
        sendActivetionEmail($email, $token);
        return array('code' => 0, 'error' => 'Create account successfull');
    }

    // send mail kích hoạt account
    function sendActivetionEmail($email, $token) {


        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer();

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();           
            $mail->CharSet = 'UTF-8';                                  // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'phamvulongkhai2000@gmail.com';                     // SMTP username
            $mail->Password   = 'qiuujclfplkpmbuw';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for 
            $mail->setFrom('phamvulongkhai2000@gmail.com', 'Admin TDT Classroom');
            $mail->addAddress($email, 'Người nhận');     // Add a recipient
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Xác minh tài khoản của bạn';
            $mail->Body    = "Click <a href='http://localhost:8080/51800875-PhamVuLongKhai-51800203-TangBaoKien/sourceCode/active.php?email=$email&token=$token'>vào đây</a> để xác minh tài khoản của bạn";
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // kích hoạt account
    function activateAccount($email, $token) {
        $sql = 'SELECT username from account where email  = ? 
        and activate_token = ? and activated = 0';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss' ,$email, $token);

        if(!$stm->execute()){
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        $result = $stm->get_result();
        if($result->num_rows == 0){
            return array('code' => 2, 'error' => 'Email address or token not found');
        }
        //found
        $sql = "UPDATE account set activated = 1, activate_token = '' where email = ?"; 

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if(!$stm->execute()){
            return array('code' => 1, 'error' => 'Can not execute command');
        } 

        return array('code' => 0, 'message' => 'Account activated');
    }

    // send mail reset pass
    function sendResetEmail($email, $token) {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer();

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'phamvulongkhai2000@gmail.com';                     // SMTP username
            $mail->Password   = 'qiuujclfplkpmbuw';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for
            $mail->setFrom('phamvulongkhai2000@gmail.com', 'Admin web ban hang');
            $mail->addAddress($email, 'Người nhận');     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Khôi phục tài khoản của bạn';
            $mail->Body    = "Click <a href='http://localhost:8080/51800875-PhamVuLongKhai-51800203-TangBaoKien/sourceCode/reset.php?email=$email&token=$token'>vào đây</a> để khôi phục mật khẩu của bạn";
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // tạo pass mới
    function reset_password($email) {
        if(!is_email_exists($email)){
            return array('code' => 1, 'error' => 'Email does not exists');
        }
        $token = md5($email . '+' . random_int(1000,2000));
        $sql = 'UPDATE reset_token set token = ? where email = ?';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $token, $email);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }

        if($stm->affected_rows == 0){
            $exp = time() + 3600 * 24;

            $sql = 'INSERT into reset_token values(?,?,?)';
            $stm = $conn->prepare($sql);
            $stm->bind_param('ssi', $email, $token, $exp);

            if(!$stm->execute()){
                return array('code' => 1, 'error' => 'Can not execute command');
            }
        }
        $success = sendResetEmail($email, $token);
        return array('code' => 0, 'success' => $success);
    }

    // sửa pass trong bảng account
    function update_password($pass_confirm, $email){
        $hash = password_hash($pass_confirm, PASSWORD_DEFAULT);

        // update password 
        $sql = "UPDATE account set password = ? where email = ?";

        $conn = open_database();
        $stm = $conn ->prepare($sql);
        $stm->bind_param('ss',$hash, $email);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }  
        return array('code' => 0);  
    }

    // check id có hay chưa
    function is_classid_exists($classid){
        $sql = 'SELECT * from class where classid = ?';
        $conn = open_database();

        $stm = $conn -> prepare($sql);
        $stm->bind_param('s',$classid);

        if(!$stm->execute()){
            die("Query error:".$stm->error);
        }

        $result = $stm->get_result();
        if ($result->num_rows > 0){
            return true;
        }else{
            return false;
        }

    }

    // thêm class vào database, hàm này dùng bởi addmin
    function addclass($classname, $subjectname, $room, $image){
        // add class to database
        $sql = 'INSERT into class(classid, classname, room, subjects, image) values (?,?,?,?,?)';
        $rand = random_int(10000, 99999);

        // check nếu id trùng thì không được thêm
        if (is_classid_exists($rand)) {
            # code...
            return array('code' => 3, 'error' => 'ID is exists');
        }else{
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm ->bind_param('sssss', $rand, $classname, $room, $subjectname, $image);
            if(!$stm->execute()){
                return array('code' => 2, 'error' => 'Can not execute command');
            }
            return array('code' => 0, 'error' => 'Create class successfull');
        }
    }

    // hàm này để xác định là lớp học được thêm bởi giảng viên nào cột add_by_lecturers sẽ lưu username của giáo viên đó
    // hàm này dùng bởi giảng viên
    function addclassLec($classname, $subjectname, $room, $image, $add_by_lecturers){
        // add class to database
        $sql = 'INSERT into class(classid, classname, room, subjects, image, add_by_lecturers) values (?,?,?,?,?,?)';
        $rand = random_int(10000, 99999);
        // check nếu id trùng thì không được thêm
        if (is_classid_exists($rand)) {
            # code...
            return array('code' => 3, 'error' => 'ID is exists');
        }else{
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm ->bind_param('ssssss', $rand, $classname, $room, $subjectname, $image, $add_by_lecturers);
            if(!$stm->execute()){
                return array('code' => 2, 'error' => 'Can not execute command');
            }
            return array('code' => 0, 'error' => 'Create class successfull');
        }
    }

    // xoá class khỏi database
    // hàm này dùng bởi admin
    function deleteclass($classid){
        $sql = "DELETE FROM class WHERE classid = ?";
        if (is_classid_exists($classid)) {
            # code...
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm->bind_param('s',$classid);
            if(!$stm->execute()){
                return array('code' => 2, 'error' => 'Can not execute command');
            }
            return array('code' => 0, 'error' => 'Delete class successfull');
        }
        return array('code' => 3, 'error' => 'ID does not exist');
    }

    // xoá class khỏi database
    // hàm này dùng bởi giáo viên
    function deleteclassLec($classid, $add_by_lecturers){
        $sql = "SELECT add_by_lecturers FROM class where classid = ?";
        // nếu tồn tại id thì chọn cột add_by_lecturers
        if (is_classid_exists($classid)) {
            # code...
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm->bind_param('s', $classid);
            if(!$stm->execute()){
                return array('code' => 2, 'error' => 'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            // $_SESSION['user'] để đảm bảo giáo viên chỉ có thể xoá lớp của mình
            // ngược lại có nghĩa là không đủ quyền hạn
            if ($data['add_by_lecturers'] == $add_by_lecturers) {
                # code...
                $sql = "DELETE  FROM class where classid = ?";
                $conn = open_database();
                $stm = $conn->prepare($sql);
                $stm->bind_param('s', $classid);
                if(!$stm->execute()){
                    return array('code' => 2, 'error' => 'Can not execute command');
                }
                return array('code' => 0, 'error' => 'Delete class successfull');
            }
            return array('code' => 1, 'error' => 'You do not have permission to delete this class');
        }
        return array('code' => 3, 'error' => 'ID does not exist');
    }


    // thay đổi thông tin lớp học
    // hàm này dùng bởi admin
    function changeinfo($classname, $room, $subjects, $image, $classid){
        // update class 
        $sql = 'UPDATE class SET classname=?, room=?, subjects=?, image=? where classid = ?';
        if (is_classid_exists($classid)) {
            # code...
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm ->bind_param('sssss', $classname, $room, $subjects, $image, $classid);

            if(!$stm->execute()){
                return array('code' => 2, 'error' => 'Can not execute command');
            }
            return array('code' => 0, 'error' => 'Change successfull');
        }
        return array('code' => 3, 'error' => 'ID does not exist');
    }

    // thay đổi thông tin lớp học
    // hàm này dùng bởi giảng viên
    function changeinfoLec($classname, $room, $subjects, $image, $classid, $add_by_lecturers){
        // update class 
        $sql = "SELECT add_by_lecturers FROM class where classid = ?";
        // nếu tồn tại id thì chọn cột add_by_lecturers
        if (is_classid_exists($classid)) {
            # code...
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm->bind_param('s', $classid);
            if(!$stm->execute()){
                return array('code' => 2, 'error' => 'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            // nếu lớp được tạo bởi giáo viên chính giáo viên đó mới có quyền sửa
            if ($data['add_by_lecturers'] == $add_by_lecturers) {
                # code...
                $sql = 'UPDATE class SET classname=?, room=?, subjects=?, image=? where classid = ?';
                $conn = open_database();
                $stm = $conn->prepare($sql);
                $stm ->bind_param('sssss', $classname, $room, $subjects, $image, $classid);
                if(!$stm->execute()){
                    return array('code' => 2, 'error' => 'Can not execute command');
                }
                return array('code' => 0, 'error' => 'Change class successfull');
            }else{
                // ngược lại có nghĩa là không đủ quyền hạn
                return array('code' => 1, 'error' => 'You do not have permission to delete this class');    
            }
         
        }
        return array('code' => 3, 'error' => 'ID does not exist');
    }

    // admin sử dụng hàm này để thiết lập quyền cho các tài khoản khác
    // 1 là admin, 2 là giáo viên, 3 là sinh viên
    // set username với quyền 1,2,3
    function setrole($email, $radio){
        // update password 
        $sql = "UPDATE account SET role = ? where email = ?";

        if (is_email_exists($email)) {
            # code...        
            $conn = open_database();
            $stm = $conn ->prepare($sql);
            $stm->bind_param('ss',$radio, $email);

            if(!$stm->execute()){
                return array('code' => 2, 'error' => 'Can not execute command');
            }
            return array('code' => 0, 'error' => 'Setup successfull');
        }
        return array('code' => 3, 'error' => 'Email does not exist');
    }

    // select quyền
    function selectrole($username){
        $sql = 'SELECT role from account where username = ?';

        $conn = open_database();
        $stm = $conn ->prepare($sql);
        $stm->bind_param('s', $username);
        if(!$stm->execute()){
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        $result = $stm->get_result();
        $data = $result->fetch_assoc();
        if ($result->num_rows == 0) {
            return array('code' => 2, 'error' => 'User does not exists');
        }
        if ($data['role'] == 1){
            # admin
            return 1;
        }elseif ($data['role'] == 2) {
            # giáo viên
            return 2;
        }elseif ($data['role'] == 3){
            # sinh viên
            return 3;
        }else{
            return false;
        }
    }

    // tham gia lớp học của sinh viên
    function joinclass($classid, $username){         
        if(is_classid_exists($classid)){
            $sql = "INSERT INTO student_class(ID, username, classid) VALUES (?,?,?)";
            $rand = random_int(1000000, 9999999);
            # code...
            $conn = open_database();
            $stm = $conn ->prepare($sql);
            $stm->bind_param('sss',$rand, $username, $classid);

            if(!$stm->execute()){
                return array('code' => 2, 'error' => 'Can not execute command');
            }
            return array('code' => 0, 'error' => 'Join successfull');
        }
        return array('code' => 1, 'error' => 'ID does not exists');
    }
?>