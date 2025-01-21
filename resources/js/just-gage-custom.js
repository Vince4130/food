// var myColors = [
//     "#a3f5ff",
//     "#54ce54",
//     "#ffff00",
//     "#ffb800",
//     "#ff6800",
//     "#f44242"
// ];

// Récupération des données
var myImc    = document.querySelector("#myImc").value;
var myWeight = document.querySelector("#myWeight").value;
var range =  document.querySelector("#range").value;
var idealWeight = document.querySelector("#idealWeight").value;
var age = document.querySelector("#age").value;
var morphoCoefficient = document.querySelector("#morphoCoefficient").value;

range = JSON.parse(range);
idealWeight = JSON.parse(idealWeight);

// Calcul du poids ideal formule de Lorentz et Creff
var height = idealWeight.height;
var gender = idealWeight.sexe;
var coef = NaN;

if(gender = 'h') {
    coef = 4;
} else {
    coef = 2.5;
}

var lorentz = height - 100 - ((height -150)/coef);
var creff   = (height - 100 + age/10)*morphoCoefficient;
var i = 0;
for(i=0; i < range.length; i++) {
    range[i] = Math.floor(range[i]*100)/100;
}

// Jauge IMC
var g1 = new JustGage({
    id: "imc",
    value: myImc,
    min: 0,
    max: 60,
    donut: true,
    decimals: 2,
    title: "IMC",
    // levelColors: myColors,
    customSectors: {
        ranges: [{
            color: "#a3f5ff",
            lo: 0,
            hi: 18.5
        }, {
            color: "#54ce54",
            lo: 18.6,
            hi: 24.9
        }, {
            color: "#ffff00",
            lo: 25,
            hi: 29.9
        }, {
            color: "#ffb800",
            lo: 30,
            hi: 34.9
        }, {
            color: "#ff6800",
            lo: 35,
            hi: 39.9
        }, {
            color: "#f44242",
            lo: 40,
            hi: 100
        }]
    },
    pointer: true,
    pointerOptions: {
        toplength: -15,
        bottomlength: 10,
        bottomwidth: 12,
        color: '#8e8e93',
        stroke: '#ffffff',
        stroke_width: 3,
        stroke_linecap: 'round'
    },
    gaugeWidthScale: 0.6,
    counter: true,
    relativeGaugeSize: true
});

// Jauge poids actuel
var g2 = new JustGage({
    id: "weight",
    value: myWeight,
    min: 0,
    max: 300,
    donut: true,
    decimals: 2,
    title: "Poids",
    // levelColors: myColors,
    customSectors: {
        ranges: [{
            color: "#a3f5ff",
            lo: 0,
            hi: range[0] - 0.01
        }, {
            color: "#54ce54",
            lo: range[0],
            hi: range[1] - 0.01
        }, {
            color: "#ffff00",
            lo: range[1],
            hi: range[2] - 0.01
        }, {
            color: "#ffb800",
            lo: range[2],
            hi: range[3] - 0.01
        }, {
            color: "#ff6800",
            lo: range[3],
            hi: range[4] - 0.01
        }
        , {
            color: "#f44242",
            lo: range[4],
            hi: 300
        }]
    },
    pointer: true,
    pointerOptions: {
        toplength: -15,
        bottomlength: 10,
        bottomwidth: 12,
        color: '#8e8e93',
        stroke: '#ffffff',
        stroke_width: 3,
        stroke_linecap: 'round'
    },
    gaugeWidthScale: 0.6,
    counter: true,
    relativeGaugeSize: true
});

// Jauge poids idéal formule de Lorentz
var g3 = new JustGage({
    id: "lorentz",
    value: lorentz,
    min: 0,
    max: 200,
    donut: true,
    decimals: 2,
    title: "Poids idéal",
    customSectors: {
        ranges: [{
            color: "#54ce54",
            lo: 0,
            hi: lorentz
        }, {
            color: "#f44242",
            lo: lorentz + 0.01,
            hi: 200
        }]
    },
    pointer: true,
    pointerOptions: {
        toplength: -15,
        bottomlength: 10,
        bottomwidth: 12,
        color: '#8e8e93',
        stroke: '#ffffff',
        stroke_width: 3,
        stroke_linecap: 'round'
    },
    gaugeWidthScale: 0.6,
    counter: true,
    relativeGaugeSize: true
});

// Jauge poids idéal formule de Creff
var g4 = new JustGage({
    id: "creff",
    value: creff,
    min: 0,
    max: 200,
    donut: true,
    decimals: 2,
    title: "Poids idéal",
    customSectors: {
        ranges: [{
            color: "#54ce54",
            lo: 0,
            hi: creff
        }, {
            color: "#f44242",
            lo: creff + 0.01,
            hi: 200
        }]
    },
    pointer: true,
    pointerOptions: {
        toplength: -15,
        bottomlength: 10,
        bottomwidth: 12,
        color: '#8e8e93',
        stroke: '#ffffff',
        stroke_width: 3,
        stroke_linecap: 'round'
    },
    gaugeWidthScale: 0.6,
    counter: true,
    relativeGaugeSize: true
});