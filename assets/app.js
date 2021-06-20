/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import noUiSlider from 'nouislider'
import 'nouislider/dist/nouislider.css'
// start the Stimulus application
import './bootstrap';
const slider = document.getElementById('salaire-slider');

if(slider){
    const min = document.getElementById('min')
    const max = document.getElementById('max')
    const omin = Math.floor(parseInt(slider.dataset.min,10)/10)*10
    const omax = Math.ceil(parseInt(slider.dataset.max,10)/10)*10
const range = noUiSlider.create(slider, {
    start: [min.value || omin, max.value || omax],
    connect: true,
    range: {
        'min': omin,
        'max': omax
    }})

    range.on('slide', function(values,handle){
        if(handle==0 ){
         min.value = Math.round(values[0])
        }
        if(handle==1 ){
            max.value = Math.round(values[1]) 
        }
        console.log(values,handle)
    })
}
