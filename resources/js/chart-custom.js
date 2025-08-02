const ctx = document.getElementById('weightsChart');
const ctxImc = document.getElementById('imcsChart');
var weights = document.querySelector("#weights").value;
var imcs = document.querySelector("#imcs").value;
var target = document.querySelector("#targetWeight").value;
weights = JSON.parse(weights);
imcs = JSON.parse(imcs);
target = JSON.parse(target)

const labels = Object.keys(weights);
const data = Object.values(weights);
console.log(labels);
const formatData = data.map(value => value !== null ? value : NaN);

const labelsI = Object.keys(imcs);
const dataI = Object.values(imcs);
console.log(labels);
const formatDataI = dataI.map(value => value !== null ? value : NaN);

const labelT = Object.keys(target);
const dataT = Object.values(target);
console.log(labels);
const formatDataT = dataT.map(value => value !== null ? value : NaN);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Poids en Kg',
            data: weights,
            borderWidth: 1,
            fill: false,
            tension: 0.1,
            spanGaps: true
        }]
    },
    options: {
        locale: "fr-FR",
        responsive: true,
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    tooltypeFormat: 'DD/MM/YYYY',
                    displayFormats: {
                        day: 'dd MM'
                    }
                }
            },
            y: {
                label: 'Poids',
                beginAtZero: true,
                max: 160
            }
        },
        plugins: {
            annotation: {
                annotations: {
                    line1: {
                        type: 'line',
                        datasets: [{
                            // label: 'Poids en Kg',
                            data: target,
                            // borderWidth: 1,
                            // fill: false,
                            // tension: 0.1,
                            // spanGaps: true
                        }],
                        yMin: target,
                        yMax: target,
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 2,
                    },
                    label: {
                        display: true,
                        content: 'Poids Cible ' + target + ' Kg',
                        yValue: target,
                        color: 'rgb(255, 99, 132)',
                        backgroundColor: '#ffff',
                        position: 'start',
                    },
                }
            }
        }
    }
});

new Chart(ctxImc, {
    type: 'line',
    data: {
        labels: labelsI,
        datasets: [{
            label: 'Imc',
            data: imcs,
            borderWidth: 1,
            fill: false,
            tension: 0.1,
            spanGaps: true
        }]
    },
    options: {
        locale: "fr-FR",
        responsive: true,
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    tooltypeFormat: 'DD/MM/YYYY',
                    displayFormats: {
                        day: 'dd MM'
                    }
                }
            },
            y: {
                label: 'Imc',
                beginAtZero: true,
                max: 50
            }
        },
        plugins: {
            annotation: {
                annotations: {
                    line1: {
                        type: 'line',
                        yMin: 22.9,
                        yMax: 22.9,
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 2,
                    },
                    label: {
                        display: true,
                        content: 'Imc Cible',
                        // yValue: 70,
                        color: 'rgb(255, 99, 132)',
                        backgroundColor: '#ffff',
                        position: 'start',
                    },
                }
            }
        }
    }
});