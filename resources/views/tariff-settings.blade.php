<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/tariff-settings.css') }}">
    <title>Настройки тарифа</title>
</head>
<body>
@include('components.header-seller')
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Выберите количество товаров:</h1>
    
    <div class="slider-container">
        <input type="number" id="ad-count-manual" min="100" max="100000" step="100" value="100">
        <input type="range" id="ad-count" name="ad-count" min="100" max="100000" step="100">
    </div>

    <div class="price-container">
        <p>Стоимость размещения в день: <span id="daily-cost">₽0.00</span></p>
        <p>Стоимость размещения в день одного товара: <span id="daily-cost-per-item">₽0.00</span></p>
        <p>Стоимость размещения в месяц: <span id="monthly-cost">₽0.00</span></p>
        <button id="save-button">Сохранить</button>
    </div>

    <div class="payment-container" style="display: none;">
        <p>Сумма к оплате: <span id="payment-amount">₽0.00</span></p>
        <button id="pay-button-card">Оплатить картой</button>
        <button id="pay-button-card">Оплатить со счета</button>
    </div>
</div>

<h3>Нужно разместить больше 100.000 товаров?</h3>
<h3>- Напишите нам и мы подготовим для Вас персоональное предложение</h3>

<script>
    const slider = document.getElementById('ad-count');
    const manualInput = document.getElementById('ad-count-manual');
    const dailyCost = document.getElementById('daily-cost');
    const dailyCostPerItem = document.getElementById('daily-cost-per-item');
    const monthlyCost = document.getElementById('monthly-cost');
    const saveButton = document.getElementById('save-button');
    const paymentContainer = document.querySelector('.payment-container');
    const paymentAmount = document.getElementById('payment-amount');
    const payButtonCard = document.getElementById('pay-button-card');

    slider.oninput = function() {
        manualInput.value = this.value;
        updatePrices(this.value);
    }

    manualInput.oninput = function() {
        slider.value = this.value;
        updatePrices(this.value);
    }

    function updatePrices(adCount) {
        // Пример расчета цен в рублях
        const basePricePerDay = 0.75; // Базовая стоимость за одно объявление в день в рублях
        const discountFactor = 1 - Math.min(0.5, (adCount - 100) / 100000); // Дисконтный фактор

        const dailyCostValue = adCount * basePricePerDay * discountFactor;
        const dailyCostPerItemValue = basePricePerDay * discountFactor;
        const monthlyCostValue = dailyCostValue * 30;

        dailyCost.textContent = `₽${dailyCostValue.toFixed(2)}`;
        dailyCostPerItem.textContent = `₽${dailyCostPerItemValue.toFixed(2)}`;
        monthlyCost.textContent = `₽${monthlyCostValue.toFixed(2)}`;
    }

    saveButton.addEventListener('click', function() {
        const adCount = slider.value;
        const basePricePerDay = 0.75;
        const discountFactor = 1 - Math.min(0.5, (adCount - 100) / 100000);
        const dailyCostValue = adCount * basePricePerDay * discountFactor;
        const monthlyCostValue = dailyCostValue * 30;

        paymentAmount.textContent = `₽${monthlyCostValue.toFixed(2)}`;
        paymentContainer.style.display = 'block';
    });

    payButtonCard.addEventListener('click', function() {
        window.location.href = '/pay';
    });
</script>
@endsection

</body>
</html>