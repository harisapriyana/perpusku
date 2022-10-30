$(document).ready(function () {
    read();
});

function read() {
    $.get("{{ url('book') }}", {}, function (data, status) {
        $("#table-books").html(data);
    });
}
