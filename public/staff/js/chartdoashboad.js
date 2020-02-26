var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thú 6", "Thứ 7", "Chủ nhật"],
        datasets: [{
            label:'Doanh thu bán hàng',
            data: [12, 19, 3, 5, 2, 3,18],
            backgroundColor: [
                '#0094DA',
                '#0094DA',
                '#0094DA',
                '#0094DA',
                '#0094DA',
                '#0094DA',
                '#0094DA'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});