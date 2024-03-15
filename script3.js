const input = document.querySelector('input');
const upload = document.querySelector('button');
const percent = document.querySelector('.percent');
const progressBar = document.querySelector('.progress-bar span');


upload.onclick = () => {

    var http = new XMLHttpRequest();

    var data = new FormData();

    for(var i = 0; i < input.files.length; i++) {
        data.append('file' + i, input.files[i]);
    }

    data.append('files_length', input.files.length);

    http.onload = () => {
        percent.innerHTML = "Done";
    }

    http.upload.onprogress = (e) => {
        var percent_complete = (e.loaded / e.total) * 100;
        percent.innerHTML = Math.floor(percent_complete) + '%';
        progressBar.style.width = percent_complete + '%';
    }

    http.open('POST', 'share_memory.php', true);
    http.send(data);
}