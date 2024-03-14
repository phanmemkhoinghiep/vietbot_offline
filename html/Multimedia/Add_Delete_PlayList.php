<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['delete_all_play_list'] === 'delete_all_play_list') {
        // Xóa toàn bộ danh sách phát
        $data = array("play_list" => []);
        file_put_contents('Play_List.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        // Chuẩn bị thông báo để xuất dưới dạng JSON
        $response = array(
            'success' => true,
            'message' => "Đã xóa toàn bộ danh sách phát."
        );

        // Xuất thông báo dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
	
    if ($_POST['add_play_list'] === 'add_play_list') {
        // Đường dẫn đến tệp Play_List.json
        $file_path = 'Play_List.json';

        // Kiểm tra xem các tham số cần thiết đã được truyền hay chưa
        if (isset($_POST['title']) && isset($_POST['channel_artist_content']) && isset($_POST['time']) && isset($_POST['source']) && isset($_POST['images']) && isset($_POST['link'])) {
            // Dữ liệu của bài hát mới
            $new_song_data = array(
                "title" => $_POST['title'],
                "images" => $_POST['images'],
                "channel_artist_content" => $_POST['channel_artist_content'],
                "link" => $_POST['link'],
                "time" => $_POST['time'],
                "source" => $_POST['source']
            );

            // Đọc dữ liệu hiện tại từ tệp JSON
            $json_data = file_get_contents($file_path);
            $data = json_decode($json_data, true);

            // Thêm bài hát mới vào mảng danh sách phát
            //$data['play_list'][] = $new_song_data;
			// Thêm bài hát mới vào đầu mảng danh sách phát
			array_unshift($data['play_list'], $new_song_data);

            // Ghi lại dữ liệu mới vào tệp JSON
            file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

                    // Chuẩn bị thông báo để xuất dưới dạng JSON
        $response = array(
            'success' => true,
            'message' => "Thêm mới thành công"
        );
        } else {
        $response = array(
            'success' => false,
            'message' => "Thêm mới thất bại"
        );
        }
        // Xuất thông báo dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($response);
		exit();
    }
    // Lấy link của bài hát muốn xóa
    $song_link = $_POST['song_link'];
    // Đọc dữ liệu từ tệp JSON
    $json_data = file_get_contents('Play_List.json');
    $data = json_decode($json_data, true);

    // Tìm và xóa bài hát từ danh sách bằng cách sử dụng link
    $deleted = false;
    $deleted_song_title = ''; // Tên của bài hát đã xóa
    foreach ($data['play_list'] as $key => $song) {
        if ($song['link'] == $song_link) {
            // Lưu tên của bài hát trước khi xóa
            $deleted_song_title = $song['title'];
            unset($data['play_list'][$key]);
            $deleted = true;
            break; // Đảm bảo chỉ xóa một bài hát duy nhất
        }
    }

    // Điều chỉnh lại chỉ mục của mảng
    $data['play_list'] = array_values($data['play_list']);

    // Ghi lại dữ liệu mới vào tệp JSON
    file_put_contents('Play_List.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    // Chuẩn bị thông báo để xuất dưới dạng JSON
    $response = array();
    if ($deleted) {
        $response['success'] = true;
        $response['message'] = "Xóa bài hát '{$deleted_song_title}' thành công.";
    } else {
        $response['success'] = false;
        $response['message'] = "Không thể xóa bài hát. Bài hát không tồn tại trong danh sách.";
    }

    // Xuất thông báo dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
