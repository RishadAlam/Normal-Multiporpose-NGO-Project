$(document).ready(function () {
    /**
     * Summer Note
     */
    $(".summernote").summernote({
        height: 100,
    });

    /**
     * Select2
     */
    $(".select").select2({
        placeholder: "Select an option...",
        width: "resolve",
    });

    /**
     * Time Picker
     */
    $(".timepicker").mdtimepicker({
        // format of the time value (data-time attribute)
        timeFormat: "hh:mm:ss.000",

        // format of the input value
        format: "h:mm tt",

        // theme of the timepicker
        // 'red', 'purple', 'indigo', 'teal', 'green', 'dark'
        theme: "indigo",

        // determines if input is readonly
        readOnly: true,

        // determines if display value has zero padding for hour value less than 10 (i.e. 05:30 PM); 24-hour format has padding by default
        hourPadding: false,

        // determines if clear button is visible
        clearBtn: false,
    });

    $(function () {
        var start = moment().startOf("month");
        var end = moment();

        function cb(start, end) {
            $("#daterange span").html(
                start.format("DD-MM-YYYY") + " -> " + end.format("DD-MM-YYYY")
            );
        }

        $("#daterange").daterangepicker(
            {
                startDate: start,
                endDate: end,
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment()],
                    "Last Month": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                    "Last 365 Days": [moment().subtract(364, "days"), moment()],
                },
            },
            cb
        );

        cb(start, end);
    });
});
