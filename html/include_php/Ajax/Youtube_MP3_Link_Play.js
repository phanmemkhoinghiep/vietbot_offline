const ytdl = require('ytdl-core');

const getMP3Link = async (videoURL) => {
    const info = await ytdl.getInfo(videoURL);

    // Chọn chất lượng âm thanh cao nhất
    const audioFormat = ytdl.chooseFormat(info.formats, { quality: 'highestaudio' });

    // Lấy liên kết của file âm thanh
    const mp3Link = audioFormat.url;

    return mp3Link;
};

// Lấy đường link từ tham số dòng lệnh
const videoURL = process.argv[2];

if (!videoURL) {
    console.error('Vui lòng cung cấp đường link video YouTube.');
    process.exit(1); // Thoát với mã lỗi
}

// Gọi hàm getMP3Link với đường link từ tham số dòng lệnh
getMP3Link(videoURL)
    .then((mp3Link) => {
        console.log(mp3Link);
    })
    .catch((error) => {
        console.error('Lỗi:', error);
    });
