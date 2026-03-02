<!-- noUiSlider CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" rel="stylesheet">

<div class="mb-3">
    <div id="price-slider" class="my-2"></div>
    <div class="d-flex justify-content-between mt-1">
        <span id="price-min">Rp 0</span>
        <span id="price-max">Rp 0</span>
    </div>
    <input type="hidden" name="min_price" id="input-min-price" value="{{ request('min_price') }}">
    <input type="hidden" name="max_price" id="input-max-price" value="{{ request('max_price') }}">
</div>

<!-- noUiSlider JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const slider = document.getElementById('price-slider');
    const inputMin = document.getElementById('input-min-price');
    const inputMax = document.getElementById('input-max-price');
    const displayMin = document.getElementById('price-min');
    const displayMax = document.getElementById('price-max');

    let startMin = inputMin.value ? parseInt(inputMin.value) : 0;
    let startMax = inputMax.value ? parseInt(inputMax.value) : 500000;

    noUiSlider.create(slider, {
        start: [startMin, startMax],
        connect: true,
        step: 5000,
        range: { 'min': 0, 'max': 500000 },
        tooltips: [wNumb({prefix: 'Rp ', thousand: '.'}), wNumb({prefix: 'Rp ', thousand: '.'})],
        format: wNumb({decimals: 0})
    });

    slider.noUiSlider.on('update', function (values, handle) {
        const min = parseInt(values[0]);
        const max = parseInt(values[1]);
        displayMin.textContent = 'Rp ' + min.toLocaleString('id-ID');
        displayMax.textContent = 'Rp ' + max.toLocaleString('id-ID');
        inputMin.value = min;
        inputMax.value = max;
    });

});
</script>
