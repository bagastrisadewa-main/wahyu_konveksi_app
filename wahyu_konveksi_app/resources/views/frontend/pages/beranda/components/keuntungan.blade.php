<div class="section py-5 bg-white"> 
  <div class="container">

    {{-- Judul --}}
    <div class="text-center mb-5">
      <h2 class="h3 fw-bold mb-0 text-dark">
        Keuntungan Order di <span class="fw-bold text-primary">WHS KONVEKSINDO</span>
      </h2>
    </div>

    {{-- Grid Keuntungan --}}
    <div class="row g-4 justify-content-center">

      {{-- Free Keychain (pakai icon_shield dari keunggulan) --}}
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 border-0 shadow-lg rounded-5 text-center p-4 transition hover-shadow">
          <div class="icon-circle bg-white border border-dark text-dark mb-3 mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width:64px; height:64px;">
            <img src="{{ asset('assets_frontend/assets/images/icon/free.png') }}" width="35" height="35" alt="free">
         
          </div>
          <p class="fw-medium mb-0">FREE KEYCHAIN</p>
        </div>
      </div>

      {{-- Cashback (pakai icon_user dari keunggulan) --}}
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 border-0 shadow-lg rounded-5 text-center p-4 transition hover-shadow">
          <div class="icon-circle bg-white border border-dark text-dark mb-3 mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width:64px; height:64px;">
                  <img src="{{ asset('assets_frontend/assets/images/icon/money.png') }}" width="40" height="40" alt="cashback">
            
          </div>
          <p class="fw-medium mb-1">CASHBACK</p>
          <small class="text-muted">(*S&amp;K Berlaku)</small>
        </div>
      </div>

      {{-- Free Ongkir (pakai icon_heart dari keunggulan) --}}
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 border-0 shadow-lg rounded-5 text-center p-4 transition hover-shadow">
          <div class="icon-circle bg-white border border-dark text-dark mb-3 mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width:64px; height:64px;">
             <img src="{{ asset('assets_frontend/assets/images/icon/free-ship.png') }}" width="40" height="40" alt="cashback">
          </div>
          <p class="fw-medium mb-1">FREE ONGKIR</p>
          <small class="text-muted">(*S&amp;K Berlaku)</small>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
  .icon-circle {
    width: 64px; 
    height: 64px;
    border-radius: 50%;
    border: 2px solid #000;
    background: #fff;
    color: #000;
    font-size: 2rem;
  }
  .hover-shadow {
    transition: all 0.3s ease;
  }
  .hover-shadow:hover {
    box-shadow: 0 12px 30px rgba(0,0,0,0.45);
  }
  .shadow-lg {
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  }
  .icon {
    fill: currentColor;
  }
</style>
