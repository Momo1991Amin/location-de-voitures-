"Use strict";
require('bootstrap');
import noUiSlider from 'nouislider';

const slider = document.getElementById('price-slider');
const min = document.getElementById('min');
const max = document.getElementById('max');
const minValue = Math.floor(parseInt(slider.dataset.min, 10) /10) * 10 
const maxValue = Math.ceil(parseInt(slider.dataset.max, 10) /10) * 10 

if(slider) {
    const range = noUiSlider.create(slider, {
        start: [min.value || minValue, max.value || maxValue],
        connect: true,
        step: 10,
        range: {
            'min': minValue,
            'max': maxValue
        }
    });

   
    range.on('slide', function(values, handle) {

        if(handle === 0) {
            min.value = Math.round(values[0]);
        }

        if(handle === 1) {
            max.value = Math.round(values[1]);
        }
    });
}
