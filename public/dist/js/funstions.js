$(document).ready(function () {
    /**
     * Get ALl Divition
     */
    function divisions(division) {
        $.ajax({
            url: "{{ asset('json/bd-divisions.json') }}",
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                var divisions =
                    "<option disabled selected>Choose a Division...</option>";
                $.each(data.divisions, function (key, value) {
                    divisions +=
                        "<option data-id='" +
                        value.id +
                        "' value='" +
                        value.name +
                        "'>" +
                        value.name +
                        "</option>";
                });
                $("#" + division).html("");
                $("#" + division).html(divisions);
            },
        });
    }

    /**
     * Get ALl District
     */
    function districts(district, division_id) {
        $.ajax({
            url: "{{ asset('json/bd-districts.json') }}",
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                var districts =
                    "<option disabled selected>Choose a Districts...</option>";
                $.each(data.districts, function (key, value) {
                    if (value.division_id == division_id) {
                        districts +=
                            "<option data-id='" +
                            value.id +
                            "' value='" +
                            value.name +
                            "'>" +
                            value.name +
                            "</option>";
                    }
                });
                $("#" + district).html("");
                $("#" + district).html(districts);
            },
        });
    }

    /**
     * Get ALl Upazila
     * Get ALl Post Codes
     */
    function policePost(upazila, postcode, district_id) {
        /**
         * Get ALl Upazila
         */
        $.ajax({
            url: "{{ asset('json/bd-upazilas.json') }}",
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                // console.table(data.districts)
                var upazilas =
                    "<option disabled selected>Choose a Police Station...</option>";
                $.each(data.upazilas, function (key, value) {
                    if (value.district_id == district_id) {
                        upazilas +=
                            "<option data-id='" +
                            value.id +
                            "' value='" +
                            value.name +
                            "'>" +
                            value.name +
                            "</option>";
                    }
                });
                $("#" + upazila).html("");
                $("#" + upazila).html(upazilas);
            },
        });

        /**
         * Get ALl Post Codes
         */
        $.ajax({
            url: "{{ asset('json/bd-postcodes.json') }}",
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                // console.table(data.districts)
                var postcodes =
                    "<option disabled selected>Choose a Police Station...</option>";
                $.each(data.postcodes, function (key, value) {
                    if (value.district_id == district_id) {
                        postcodes +=
                            "<option value='" +
                            value.postOffice +
                            " - " +
                            value.postCode +
                            "'>" +
                            value.postOffice +
                            " - " +
                            value.postCode +
                            "</option>";
                    }
                });
                $("#" + postcode).html("");
                $("#" + postcode).html(postcodes);
            },
        });
    }

    /**
     * Choose Divisions
     */
    divisions("divisions");
    divisions("p_divisions");

    /**
     * Choose Districts
     */
    $("#divisions").on("change", function () {
        var division_id = $(this).find(":selected").data("id");
        districts("districts", division_id);
    });

    $("#p_divisions").on("change", function () {
        var division_id = $(this).find(":selected").data("id");
        districts("p_districts", division_id);
    });

    /**
     * Choose Upazila
     * Choose Post Codes
     */
    $("#districts").on("change", function () {
        var district_id = $(this).find(":selected").data("id");
        policePost("upazilas", "postcodes", district_id);
    });

    $("#p_districts").on("change", function () {
        var district_id = $(this).find(":selected").data("id");
        policePost("p_upazilas", "p_postcodes", district_id);
    });
});
