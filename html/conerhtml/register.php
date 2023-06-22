<?php
// 데이터베이스 연결 설정
$host = 'localhost';  // 데이터베이스 호스트
$dbname = 'login';  // 데이터베이스 이름
$username_db = 'root';  // 데이터베이스 사용자명
$password_db = '0075';  // 데이터베이스 비밀번호

// 회원가입 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 사용자가 제출한 폼 데이터 가져오기
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 데이터베이스 연결
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 사용자가 입력한 아이디로 중복 확인
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 중복된 아이디가 없을 때
        if (!$user) {
            // 회원 정보를 데이터베이스에 추가
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            // 회원가입 성공 시
            echo '<script>alert("회원가입이 완료되었습니다.");</script>';
            header("Location: login.html");
            exit();
        } else {
            // 중복된 아이디가 있을 때
            echo '<script>alert("이미 사용 중인 아이디입니다.");</script>';
            header("Location: register.html");
            exit();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
