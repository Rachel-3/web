<?php
// 데이터베이스 연결 설정
$host = 'localhost';  // 데이터베이스 호스트
$dbname = 'login';  // 데이터베이스 이름
$username_db = 'root';  // 데이터베이스 사용자명
$password_db = '0075';  // 데이터베이스 비밀번호

// 로그인 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 사용자가 제출한 폼 데이터 가져오기
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 데이터베이스 연결
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 사용자 정보 확인
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 로그인 성공 시
        if ($user) {
            header("Location: index.html");
            exit();
        } else {
            // 로그인 실패 시
            echo '<script>alert("로그인에 실패했습니다.");</script>';
            header("Location: login.html");
            exit();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
