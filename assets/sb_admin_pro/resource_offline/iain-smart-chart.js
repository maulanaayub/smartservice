//detect apakah screen kurang dari 800
var isMobile = false;
if ($(window).width() < 800) {
    // $(".pie-legend").hide();
    isMobile = true;

} else {
    // $(".pie-legend").show();
    isMobile = false;
}
// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Metropolis"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + "").replace(",", "").replace(" ", "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

//chart 1
var myAreaChart;
var ctx1 = document.getElementById("myAreaChart");
function chart1() {
    if (typeof (ctx1) != 'undefined' && ctx1 != null) {
        myAreaChart = new Chart(ctx1, {
            type: "bar",
            data: {
                labels: tahun_smt_all_fak,
                // labels: [
                //     tahun_sebelumnya_4,
                //     tahun_sebelumnya_3,
                //     tahun_sebelumnya_2,
                //     tahun_sebelumnya_1,
                //     tahun_berjalan
                // ],
                datasets: [{
                    label: "Semester 1",
                    backgroundColor: "rgba(119, 187, 82, 1)",
                    hoverBackgroundColor: "rgba(119, 183, 82, 1)",
                    borderColor: "#4e73df",
                    data: mhs_aktif_ganjil,
                    maxBarThickness: 25
                },
                {
                    label: "Semester 2",
                    backgroundColor: "rgba(255, 99, 34, 1)",
                    hoverBackgroundColor: "rgba(255, 99, 59, 1)",
                    borderColor: "#4e73df",
                    data: mhs_aktif_genap,
                    maxBarThickness: 25
                }],

            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: "month"
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6,
                        },
                        // scaleLabel: {
                        //     display: true,
                        //     labelString: 'Rentang waktu 5 tahun terakhir',
                        //     fontColor: '#212121'
                        // }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            maxTicksLimit: 8,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }]
                },
                legend: {
                    display: isMobile ? false : true,
                    position: 'bottom'
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel =
                                chart.datasets[tooltipItem.datasetIndex].label || "";
                            return datasetLabel + " : " + number_format(tooltipItem.yLabel) + " mahasiswa";
                        }
                    }
                },
                // plugins: {
                //     labels: {
                //         render: 'value',
                //         fontSize: 8,
                //         fontColor: 'black',
                //     }
                // },

                plugins: {
                    // Change options for ALL labels of THIS CHART
                    datalabels: {
                        display: function (context) {
                            return context.chart.width > 400;
                        },
                        anchor: 'center',
                        rotation: 270,
                        color: 'white',
                        font: {
                            weight: 'bold',
                            size: 10,
                            // family:'calibri'
                        }
                    },

                },
                responsive: true,

            }
        });
    }
}


//chart 2
var myBarChart;
var ctx2 = document.getElementById("myBarChart");
function chart2() {
    if (typeof (ctx2) != 'undefined' && ctx2 != null) {
        myBarChart = new Chart(ctx2, {
            type: "bar",
            data: {
                labels: label_mhs_aktif_per_fak,
                datasets: [{
                    label: "F Ekonomi",
                    backgroundColor: "#FC8C3F",
                    hoverBackgroundColor: "#F96600",
                    borderColor: "#FC8C3F",
                    data: mhs_ekonomi,
                    //maxBarThickness: 25
                },
                {
                    label: "F Syariah",
                    backgroundColor: "#767676",
                    hoverBackgroundColor: "#6D6D6D",
                    borderColor: "#767676",
                    data: mhs_syariah,
                    maxBarThickness: 25
                },
                {
                    label: "F Ushuluddin",
                    backgroundColor: "#43F4FF",
                    hoverBackgroundColor: "#00F0FF",
                    borderColor: "#43F4FF",
                    data: mhs_ushuludin,
                    maxBarThickness: 25
                },
                {
                    label: "F Dakwah",
                    backgroundColor: "#7C6D52",
                    hoverBackgroundColor: "#796A50",
                    borderColor: "#514435",
                    data: mhs_dakwah,
                    maxBarThickness: 25
                },
                {
                    label: "F Tarbiyah",
                    backgroundColor: "#7AFF38",
                    hoverBackgroundColor: "#53F701",
                    borderColor: "#7AFF38",
                    data: mhs_tarbiyah,
                    maxBarThickness: 25
                },
                {
                    label: "Pascasarjana",
                    backgroundColor: "#9D4BFF",
                    hoverBackgroundColor: "#8621FF",
                    borderColor: "#9D4BFF",
                    data: mhs_pasca,
                    maxBarThickness: 25
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: "month"
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }]
                },
                legend: {
                    display: isMobile ? false : true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 15
                    },
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel =
                                chart.datasets[tooltipItem.datasetIndex].label || "";
                            return datasetLabel + " : " + number_format(tooltipItem.yLabel) + " mahasiswa";
                        }
                    }
                },

                plugins: {
                    // Change options for ALL labels of THIS CHART
                    datalabels: {
                        display: function (context) {
                            return context.chart.width > 700;
                        },
                        anchor: 'end',
                        align: 'top',
                        clamp: false,
                        rotation: 0,
                        color: 'black',
                        font: {
                            // weight: 'bold',
                            size: 8,
                            // family:'calibri'
                        },



                    }
                }
            }
        });
    }
}




// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Metropolis"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";



//setting label untuk menampilkan presentase
// var plugins_mhs_per_prodi =  {
//     labels: {
//         display:false,
//         render: 'percentage',
//         fontColor: 'black',
//         precision: 2,
//         fontSize: 10,
//         fontStyle: 'bold',
//         position: 'outside'
//     }
// };

var plugins_mhs_per_prodi = {
    // Change options for ALL labels of THIS CHART
    datalabels: {
        formatter: (value, any) => {
            let sum = 0;
            let dataArr = any.chart.data.datasets[0].data;
            dataArr.map(data => {
                sum += parseInt(data);//jika tidak di parse int nilainya 0%
            });
            let percentage = (value * 100 / sum).toFixed(2) + "%";
            return percentage;
        },
        // display: function (context) {
        //     return context.chart.width > 300;
        // },
        display: true,
        anchor: 'center',
        align: 'center',
        rotation: 0,
        color: 'white',
        font: {
            // weight: 'bold',
            size: 10,
            // family:'calibri'
        },

    }

};
var callbacks_tooltips_per_prodi = {
    label: function (tooltipItem, data) {
        var indice = tooltipItem.index;
        return data.labels[indice] + ': ' + data.datasets[0].data[indice] + ' mahasiswa';
    }
};

var options_per_prodi = {
    maintainAspectRatio: false,
    tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: callbacks_tooltips_per_prodi
    },
    legend: {
        display: isMobile ? false : true,
        position: 'right',
    },
    cutoutPercentage: 60,
    plugins: plugins_mhs_per_prodi,
    responsive: true,
    Fullwidth: true,
    maintainAspectRatio: false,
};
var background_color_pie = ["#ff7003", "#00fc11", "#ff66c4", "#106b00", "#fc0000", "#df00fc", "#00fff7", "#95CD01", "#0509f7"];
var hover_bg_color_pie = ["#db6204", "#02de11", "#d950a4", "#0f5403", "#e60202", "#be00d6", "#02ded7", "#81B100", "#0408db"];
//chart 3 awal yang ditampilkan untuk mhs_aktif_per_prodi milik ftik
//$("#label_chart_mhs_aktif_per_prodi").text(label_mhs_aktif_per_prodi + " FTIK");
var myPieChart
var ctx3 = document.getElementById("mhs_prodichart");
function chart3() {
    if (typeof (ctx3) != 'undefined' && ctx3 != null) {
        $("#label_chart_mhs_aktif_per_prodi").text(label_mhs_aktif_per_prodi + " FTIK");
        myPieChart = new Chart(ctx3, {
            type: "pie",
            data: {
                labels: label_prodi_ftik,
                datasets: [{
                    data: mhs_prodi_ftik,
                    backgroundColor: background_color_pie,
                    hoverBackgroundColor: hover_bg_color_pie,
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }]
            },
            options: options_per_prodi

        });

    }
}




$("#ftik_click").on('click', function () {
    myPieChart.data.labels = label_prodi_ftik;
    myPieChart.data.datasets[0].data = mhs_prodi_ftik;
    myPieChart.update();


    // $('#mhs_prodichart').replaceWith($('<canvas id="mhs_prodichart" width="100%" height="30"></canvas>'));//untuk menghapus chart sebelumnya
    $("#label_chart_mhs_aktif_per_prodi").text(label_mhs_aktif_per_prodi + " FTIK");
    // var ctx3 = document.getElementById("mhs_prodichart");
    // var myPieChart = new Chart(ctx3, {
    //     type: "pie",
    //     data: {
    //         labels: label_prodi_ftik,
    //         datasets: [{
    //             data: mhs_prodi_ftik,
    //             backgroundColor: background_color_pie,
    //             hoverBackgroundColor: hover_bg_color_pie,
    //             hoverBorderColor: "rgba(234, 236, 244, 1)"
    //         }]
    //     },
    //     options: options_per_prodi
    // });

});

$("#febi_click").on('click', function () {
    myPieChart.data.labels = label_prodi_febi;
    myPieChart.data.datasets[0].data = mhs_prodi_febi;
    myPieChart.update();
    // $('#mhs_prodichart').replaceWith($('<canvas id="mhs_prodichart" width="100%" height="30"></canvas>'));
    $("#label_chart_mhs_aktif_per_prodi").text(label_mhs_aktif_per_prodi + " FEBI");
    // var ctx3 = document.getElementById("mhs_prodichart");
    // var myPieChart = new Chart(ctx3, {
    //     type: "pie",
    //     data: {
    //         labels: label_prodi_febi,
    //         datasets: [{
    //             data: mhs_prodi_febi,
    //             backgroundColor: background_color_pie,
    //             hoverBackgroundColor: hover_bg_color_pie,
    //             hoverBorderColor: "rgba(234, 236, 244, 1)"
    //         }]
    //     },
    //     options: options_per_prodi
    // });
});

$("#fs_click").on('click', function () {
    myPieChart.data.labels = label_prodi_fs;
    myPieChart.data.datasets[0].data = mhs_prodi_fs;
    myPieChart.update();
    // $('#mhs_prodichart').replaceWith($('<canvas id="mhs_prodichart" width="100%" height="30"></canvas>'));
    $("#label_chart_mhs_aktif_per_prodi").text(label_mhs_aktif_per_prodi + " F.Syariah");
    // var ctx3 = document.getElementById("mhs_prodichart");
    // var myPieChart = new Chart(ctx3, {
    //     type: "pie",
    //     data: {
    //         labels: label_prodi_fs,
    //         datasets: [{
    //             data: mhs_prodi_fs,
    //             backgroundColor: background_color_pie,
    //             hoverBackgroundColor: hover_bg_color_pie,
    //             hoverBorderColor: "rgba(234, 236, 244, 1)"
    //         }]
    //     },
    //     options: options_per_prodi
    // });
});

$("#fd_click").on('click', function () {
    myPieChart.data.labels = label_prodi_fd;
    myPieChart.data.datasets[0].data = mhs_prodi_fd;
    myPieChart.update();
    // $('#mhs_prodichart').replaceWith($('<canvas id="mhs_prodichart" width="100%" height="30"></canvas>'));
    $("#label_chart_mhs_aktif_per_prodi").text(label_mhs_aktif_per_prodi + " F.Dakwah");
    // var ctx3 = document.getElementById("mhs_prodichart");
    // var myPieChart = new Chart(ctx3, {
    //     type: "pie",
    //     data: {
    //         labels: label_prodi_fd,
    //         datasets: [{
    //             data: mhs_prodi_fd,
    //             backgroundColor: background_color_pie,
    //             hoverBackgroundColor: hover_bg_color_pie,
    //             hoverBorderColor: "rgba(234, 236, 244, 1)"
    //         }]
    //     },
    //     options: options_per_prodi
    // });
});

$("#fuadah_click").on('click', function () {
    myPieChart.data.labels = label_prodi_fuadah;
    myPieChart.data.datasets[0].data = mhs_prodi_fuadah;
    myPieChart.update();
    // $('#mhs_prodichart').replaceWith($('<canvas id="mhs_prodichart" width="100%" height="30"></canvas>'));
    $("#label_chart_mhs_aktif_per_prodi").text(label_mhs_aktif_per_prodi + " FUADAH");
    // var ctx3 = document.getElementById("mhs_prodichart");
    // var myPieChart = new Chart(ctx3, {
    //     type: "pie",
    //     data: {
    //         labels: label_prodi_fuadah,
    //         datasets: [{
    //             data: mhs_prodi_fuadah,
    //             backgroundColor: background_color_pie,
    //             hoverBackgroundColor: hover_bg_color_pie,
    //             hoverBorderColor: "rgba(234, 236, 244, 1)"
    //         }]
    //     },
    //     options: options_per_prodi
    // });
});

$("#pasca_click").on('click', function () {
    myPieChart.data.labels = label_prodi_pasca;
    myPieChart.data.datasets[0].data = mhs_prodi_pasca;
    myPieChart.update();
    // $('#mhs_prodichart').replaceWith($('<canvas id="mhs_prodichart" width="100%" height="30"></canvas>'));
    $("#label_chart_mhs_aktif_per_prodi").text(label_mhs_aktif_per_prodi + " Pascasarjana");
    // var ctx3 = document.getElementById("mhs_prodichart");
    // var myPieChart = new Chart(ctx3, {
    //     type: "pie",
    //     data: {
    //         labels: label_prodi_pasca,
    //         datasets: [{
    //             data: mhs_prodi_pasca,
    //             backgroundColor: background_color_pie,
    //             hoverBackgroundColor: hover_bg_color_pie,
    //             hoverBorderColor: "rgba(234, 236, 244, 1)"
    //         }]
    //     },
    //     options: options_per_prodi
    // });
});


//chart 4 jumlah dosen karyawan
var myPieChart2;
var ctx4 = document.getElementById("dosen_karyawan");
function chart4(){
    if (typeof (ctx4) != 'undefined' && ctx4 != null) {
         myPieChart2 = new Chart(ctx4, {
            type: "pie",
            data: {
                labels: label_pegawai,
                datasets: [{
                    data: jumlah_pegawai,
                    backgroundColor: background_color_pie,
                    hoverBackgroundColor: hover_bg_color_pie,
                    hoverBorderColor: "rgba(234, 236, 244, 1)"
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var indice = tooltipItem.index;
                            return data.labels[indice] + ': ' + data.datasets[0].data[indice] + ' Orang';
                        }
                    }
                },
                legend: {
                    display: isMobile ? false : true,
                    position: 'right',
                },
                cutoutPercentage: 60,
                plugins: plugins_mhs_per_prodi,
                responsive: true,
                maintainAspectRatio: false,
            },
    
        });
    }
}


$(window).resize(function (e) {
    if ($(this).width() < 800) {
        // $(".pie-legend").hide();
        if (isMobile == false) {
            isMobile = true;
            if (typeof (ctx1) != 'undefined' && ctx1 != null) {
                myAreaChart.options.legend.display = false;
                myAreaChart.update();
            }
            if (typeof (ctx2) != 'undefined' && ctx2 != null) {
                myBarChart.options.legend.display = false;
                myBarChart.update();
            }
            if (typeof (ctx3) != 'undefined' && ctx3 != null) {
                myPieChart.options.legend.display = false;
                myPieChart.update();
            }
            if (typeof (ctx4) != 'undefined' && ctx4 != null) {
                myPieChart2.options.legend.display = false;
                myPieChart2.update();
            }

            // console.log('hide legend');
        }

    } else {
        // $(".pie-legend").show();
        if (isMobile == true) {
            isMobile = false;
            if (typeof (ctx1) != 'undefined' && ctx1 != null) {
                myAreaChart.options.legend.display = true;
                myAreaChart.update();
            }
            if (typeof (ctx2) != 'undefined' && ctx2 != null) {
                myBarChart.options.legend.display = true;
                myBarChart.update();
            }
            if (typeof (ctx3) != 'undefined' && ctx3 != null) {
                myPieChart.options.legend.display = true;
                myPieChart.update();
            }
            if (typeof (ctx4) != 'undefined' && ctx4 != null) {
                myPieChart2.options.legend.display = true;
                myPieChart2.update();
            }
            // console.log('tampilkan legend');
        }
        //
    }

});

function refresh_chart1() {
    refresh = 1;
    tahun_smt_all_fak = [];
    mhs_aktif_ganjil = [];
    mhs_aktif_genap = [];
    myAreaChart.destroy();
    load_chart_mhs_all_fak();
}
function refresh_chart2() {
    refresh2 = 1;
    label_mhs_aktif_per_fak = [];
    mhs_ushuludin = [];
    mhs_dakwah = [];
    mhs_tarbiyah = [];
    mhs_ekonomi = [];
    mhs_syariah = [];
    mhs_pasca = [];
    myBarChart.destroy();
    load_chart_mhs_per_fak();
}

function refresh_chart3() {
    refresh3 = 1;
    label_prodi_ftik = [];
    label_prodi_fd = [];
    label_prodi_febi = [];
    label_prodi_fs = [];
    label_prodi_fuadah = [];
    label_prodi_pasca = [];
    mhs_prodi_ftik = [];
    mhs_prodi_febi = [];
    mhs_prodi_fs = [];
    mhs_prodi_fuadah = [];
    mhs_prodi_fd = [];
    mhs_prodi_pasca = [];
    myPieChart.destroy();
    load_chart_mhs_per_prodi();
}
function refresh_chart4() {
    refresh4 = 1;
    label_pegawai = [];
    jumlah_pegawai = [];
    myPieChart2.destroy();
    load_data_pegawai();
}

