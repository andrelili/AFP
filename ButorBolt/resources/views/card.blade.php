<div class="card-container">
    <h2>Bankkártyás fizetés</h2>

    <form id="cardForm">

        <div class="input-group">
            <label>Kártyaszám</label>
            <input type="text" id="card_number" placeholder="1234 1234 1234 1234" maxlength="19">
            <small class="error" id="err_card"></small>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label>Lejárat (MM/YY)</label>
                <input type="text" id="expiration" placeholder="07/27" maxlength="5">
                <small class="error" id="err_exp"></small>
            </div>

            <div class="input-group">
                <label>CVC</label>
                <input type="text" id="cvc" placeholder="123" maxlength="3">
                <small class="error" id="err_cvc"></small>
            </div>
        </div>

        <div class="input-group">
            <label>Kártyatulajdonos neve</label>
            <input type="text" id="card_name" placeholder="Teszt Elek">
            <small class="error" id="err_name"></small>
        </div>

        <button type="submit" class="pay-btn">Fizetés</button>
    </form>
</div>

<style>
    .card-container {
        max-width: 450px;
        margin: 50px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.08);
        font-family: Arial, sans-serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: bold;
    }

    .input-group {
        margin-bottom: 20px;
    }

    .input-row {
        display: flex;
        gap: 20px;
    }

    label {
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
    }

    input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        outline: none;
    }

    input:focus {
        border-color: #4A4A4A;
    }

    .pay-btn {
        width: 100%;
        padding: 14px;
        background: black;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 10px;
    }

    .pay-btn:hover {
        background: #333;
    }

    .error {
        color: red;
        font-size: 12px;
        height: 14px;
        display: block;
        margin-top: 5px;
    }
</style>

<script>
document.getElementById('cardForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let valid = true;

    // Ürítsd ki a hibaüzeneteket
    document.querySelectorAll('.error').forEach(el => el.innerText = "");

    // Kártyaszám (minimum 16 számjegy)
    let card = document.getElementById("card_number").value.replace(/\s+/g, '');
    if (!/^[0-9]{16}$/.test(card)) {
        document.getElementById("err_card").innerText = "A kártyaszámnak 16 számjegynek kell lennie!";
        valid = false;
    }

    // Lejárat MM/YY
    let exp = document.getElementById("expiration").value;
    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(exp)) {
        document.getElementById("err_exp").innerText = "Hibás formátum! (pl. 07/27)";
        valid = false;
    }

    // CVC
    let cvc = document.getElementById("cvc").value;
    if (!/^[0-9]{3}$/.test(cvc)) {
        document.getElementById("err_cvc").innerText = "A CVC 3 számjegy!";
        valid = false;
    }

    // Név
    let name = document.getElementById("card_name").value.trim();
    if (name.length < 3) {
        document.getElementById("err_name").innerText = "Add meg a teljes neved!";
        valid = false;
    }

    // Ha minden jó
    if (valid) {
        alert("Sikeres fizetés (frontend teszt)!");
    }
});

// Kártyaszám automatikus formázás (1234 1234 1234 1234)
document.getElementById("card_number").addEventListener("input", function () {
    this.value = this.value
        .replace(/\D/g, '')
        .replace(/(.{4})/g, '$1 ')
        .trim();
});
</script>
