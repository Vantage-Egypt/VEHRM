$(document).ready(function () {
    $('#tmonthSelect').on('change', function () {
        var selectedTMonthID = $(this).val();

        $.ajax({
            url: 'takeattendance.php', 
            type: 'post',
            data: { tmonthID: selectedTMonthID },
            success: function (response) {
                $('#employeeTableContainer').html(response);
            }
        });
    });
});
