<?php
// Kết nối đến cơ sở dữ liệu MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "da_1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Xử lý dữ liệu được gửi từ form
if (isset($_POST['product_name'])) {
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];


    // Upload ảnh và video vào thư mục trên server
    $targetDir = "uploads/";

    $productImage = uploadFile($_FILES['product_image'], $targetDir);
    $productVideo = uploadFile($_FILES['product_video'], $targetDir);

    // Lưu thông tin sản phẩm vào cơ sở dữ liệu
    $sql = "INSERT INTO products (name, description , image_path, video_path) VALUES (?, ? ,?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $productName, $productDescription, $productImage, $productVideo);

    if ($stmt->execute()) {
        echo "Sản phẩm đã được thêm thành công.";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// Hàm upload file
function uploadFile($file, $targetDir)
{
    $targetFile = $targetDir . basename($file['name']);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $newFileName = uniqid() . "." . $fileType;
    $targetPath = $targetDir . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $targetPath;
    } else {
        echo "Lỗi khi tải lên tệp tin.";
        return "";
    }
}
?>

<a href="../admin/admin.php">back</a>
